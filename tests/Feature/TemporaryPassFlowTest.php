<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Guest;
use App\Models\TemporaryPass;
use App\Models\UniversityMember;
use App\Services\ApplicationMailer;
use App\Support\MailSendResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;

class TemporaryPassFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_guest_visit_submission_persists_pass_and_email_log(): void
    {
        $this->mockMailer();

        $payload = [
            'name' => 'Janet Guest',
            'email' => 'janet@example.com',
            'reason' => 'Campus tour with admissions.',
        ];

        $response = $this->post(route('visit.submit'), $payload);

        $response->assertRedirect(route('visit.show'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('guests', [
            'email' => $payload['email'],
            'name' => $payload['name'],
        ]);

        $temporaryPass = TemporaryPass::where('passable_type', Guest::class)->first();
        $this->assertNotNull($temporaryPass);
        $this->assertEquals('pending', $temporaryPass->status);
        $this->assertEquals($payload['reason'], $temporaryPass->reason);

        $this->assertDatabaseHas('email_logs', [
            'temporary_pass_id' => $temporaryPass->id,
            'recipient_email' => $payload['email'],
            'status' => 'sent',
        ]);
    }

    public function test_member_is_rate_limited_when_requesting_duplicate_reason(): void
    {
        $this->mockMailer();

        $memberId = 42;
        TemporaryPass::create([
            'passable_type' => UniversityMember::class,
            'passable_id' => $memberId,
            'status' => 'approved',
            'reason' => 'lost_id',
        ]);

        $response = $this->withSession([
                'member' => 'Alex Student',
                'member_id' => $memberId,
                'member_email' => 'alex.student@example.com',
                'member_username' => 'STU12345',
            ])
            ->from(route('tpas.members.apply'))
            ->post(route('tpas.members.submit'), [
                'reason' => 'lost_id',
            ]);

        $response->assertRedirect(route('tpas.members.apply'));
        $response->assertSessionHas('error');

        $rejectedPass = TemporaryPass::where('passable_type', UniversityMember::class)
            ->where('passable_id', $memberId)
            ->where('status', 'rejected')
            ->latest()
            ->first();

        $this->assertNotNull($rejectedPass);
        $this->assertEquals('lost_id', $rejectedPass->reason);

        $this->assertDatabaseHas('email_logs', [
            'temporary_pass_id' => $rejectedPass->id,
            'recipient_email' => 'alex.student@example.com',
            'status' => 'sent',
        ]);
    }

    public function test_admin_can_approve_guest_pass(): void
    {
        $this->mockMailer();
        Storage::fake('public');

        $admin = Admin::create([
            'name' => 'Primary Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $guest = Guest::create([
            'name' => 'Visitor Guest',
            'email' => 'visitor@example.com',
        ]);

        $token = (string) Str::uuid();
        $path = "qrcodes/{$token}.png";
        Storage::disk('public')->put($path, 'qr');

        $pass = TemporaryPass::create([
            'passable_type' => Guest::class,
            'passable_id' => $guest->id,
            'status' => 'pending',
            'reason' => 'Department visit',
            'qr_code_token' => $token,
            'qr_code_path' => $path,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.pass.approve', $pass->id));

        $response->assertRedirect(route('adminDashboard'));
        $response->assertSessionHas('success');

        $pass->refresh();

        $this->assertEquals('approved', $pass->status);
        $this->assertEquals($admin->id, $pass->approved_by);
        $this->assertNotNull($pass->valid_from);
        $this->assertNotNull($pass->valid_until);
        $this->assertTrue($pass->valid_until->greaterThan($pass->valid_from));

        $this->assertDatabaseHas('email_logs', [
            'temporary_pass_id' => $pass->id,
            'recipient_email' => 'visitor@example.com',
            'status' => 'sent',
        ]);
    }

    public function test_member_application_generates_qr_code_and_confirmation(): void
    {
        $this->mockMailer();
        Storage::fake('public');

        $response = $this->withSession($this->memberSession())
            ->post(route('tpas.members.submit'), ['reason' => 'damaged_card']);

        $response->assertRedirect(route('confirmation'));
        $response->assertSessionHasAll([
            'status',
            'qr_url',
            'verify_url',
            'qr_token',
        ]);

        $pass = TemporaryPass::where('passable_type', UniversityMember::class)->first();
        $this->assertNotNull($pass);
        $this->assertEquals('approved', $pass->status);
        $this->assertEquals('damaged_card', $pass->reason);
        $this->assertNotNull($pass->qr_code_token);
        $this->assertNotNull($pass->qr_code_path);

        Storage::disk('public')->assertExists($pass->qr_code_path);

        $this->assertDatabaseHas('email_logs', [
            'temporary_pass_id' => $pass->id,
            'recipient_email' => $this->memberSession()['member_email'],
            'status' => 'sent',
        ]);
    }

    public function test_admin_can_reject_pass(): void
    {
        $this->mockMailer();

        $admin = $this->createAdmin();
        $guest = Guest::create([
            'name' => 'Rejectable Guest',
            'email' => 'reject@example.com',
        ]);

        $pass = TemporaryPass::create([
            'passable_type' => Guest::class,
            'passable_id' => $guest->id,
            'status' => 'pending',
            'reason' => 'General visit',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.pass.reject', $pass->id));

        $response->assertRedirect(route('adminDashboard'));
        $response->assertSessionHas('success');

        $pass->refresh();

        $this->assertEquals('rejected', $pass->status);
        $this->assertEquals($admin->id, $pass->approved_by);
        $this->assertNull($pass->qr_code_token);
        $this->assertNull($pass->valid_from);
        $this->assertNull($pass->valid_until);

        $this->assertDatabaseHas('email_logs', [
            'temporary_pass_id' => $pass->id,
            'recipient_email' => 'reject@example.com',
            'status' => 'sent',
        ]);
    }

    public function test_admin_can_reset_member_rate_limit(): void
    {
        $this->mockMailer();

        $admin = $this->createAdmin();
        $memberId = 77;

        $recent = TemporaryPass::create([
            'passable_type' => UniversityMember::class,
            'passable_id' => $memberId,
            'status' => 'approved',
            'reason' => 'lost_id',
        ]);
        $recent->forceFill([
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ])->saveQuietly();

        $old = TemporaryPass::create([
            'passable_type' => UniversityMember::class,
            'passable_id' => $memberId,
            'status' => 'approved',
            'reason' => 'lost_id',
        ]);
        $old->forceFill([
            'created_at' => now()->subDays(45),
            'updated_at' => now()->subDays(45),
        ])->saveQuietly();

        $response = $this->actingAs($admin)
            ->post(route('admin.member.reset'), ['member_id' => $memberId]);

        $response->assertRedirect(route('adminDashboard'));
        $response->assertSessionHas('success');

        $this->assertEquals('rejected', $recent->fresh()->status);
        $this->assertEquals('approved', $old->fresh()->status, 'Older records should remain untouched');
    }

    public function test_qr_verify_endpoint_returns_pass_data(): void
    {
        $token = (string) Str::uuid();
        $pass = TemporaryPass::create([
            'passable_type' => Guest::class,
            'passable_id' => Guest::create([
                'name' => 'QR Guest',
                'email' => 'qr@example.com',
            ])->id,
            'status' => 'approved',
            'reason' => 'Campus visit',
            'qr_code_token' => $token,
            'valid_from' => now(),
            'valid_until' => now()->addHours(4),
        ]);

        $response = $this->get(route('tpas.qr.verify', $token));

        $response->assertOk()
            ->assertJson([
                'token' => $token,
                'status' => 'approved',
            ]);
    }

    public function test_qr_show_endpoint_serves_png(): void
    {
        $token = (string) Str::uuid();
        $relativePath = "qrcodes/{$token}.png";
        $fullPath = storage_path('app/public/' . $relativePath);
        if (! is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }
        file_put_contents($fullPath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQIW2NgYGD4DwABAgEAffS4WQAAAABJRU5ErkJggg=='));

        $pass = TemporaryPass::create([
            'passable_type' => Guest::class,
            'passable_id' => Guest::create([
                'name' => 'QR Image Guest',
                'email' => 'qr-image@example.com',
            ])->id,
            'status' => 'approved',
            'reason' => 'Library visit',
            'qr_code_token' => $token,
            'qr_code_path' => $relativePath,
        ]);

        $response = $this->get(route('tpas.qr.show', $token));

        $response->assertOk();
        $this->assertSame('image/png', $response->headers->get('Content-Type'));

        @unlink($fullPath);
        $pass->delete();
    }

    private function mockMailer(): void
    {
        $mailer = Mockery::mock(ApplicationMailer::class);
        $mailer->shouldReceive('sendUsingView')->andReturn(MailSendResult::sent());
        $this->app->instance(ApplicationMailer::class, $mailer);
    }

    /**
     * @return array<string, string|int>
     */
    private function memberSession(): array
    {
        return [
            'member' => 'Alex Student',
            'member_id' => 1001,
            'member_email' => 'alex.student@example.com',
            'member_username' => 'STU1001',
        ];
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
