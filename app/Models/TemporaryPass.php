<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TemporaryPass extends Model
{
    /** @use HasFactory<\Database\Factories\TemporaryPassFactory> */
    use HasFactory;

    public const MEMBER_REASON_LABELS = [
        'lost_id' => 'Lost University ID',
        'misplaced_id' => 'Misplaced University ID',
        'damaged_card' => 'Damaged ID Card',
        'campus_event' => 'Attending Campus Event',
        'other' => 'Other',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'passable_id',
        'passable_type',
        'status',
        'reason',
        'qr_code_token',
        'qr_code_path',
        'valid_from',
        'valid_until',
        'approved_by',
    ];

    /**
     * Additional appended attributes.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'reason_label',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Get the parent passable model (UniversityMember or Guest).
     */
    public function passable()
    {
        return $this->morphTo();
    }

    /**
     * Get the admin who approved/rejected the pass.
     */
    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * Get the email logs for the temporary pass.
     */
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }

    /**
     * Convenience helper: return human-readable reason label.
     */
    public function getReasonLabelAttribute(): string
    {
        $labels = static::reasonLabels();

        return $labels[$this->reason] ?? $this->reason;
    }

    /**
     * Log an email event associated with this pass.
     */
    public function logEmail(string $recipient, string $subject, string $status = 'queued', ?string $errorMessage = null): EmailLog
    {
        return $this->emailLogs()->create([
            'recipient_email' => $recipient,
            'subject' => $subject,
            'status' => $status,
            'error_message' => $errorMessage,
            'sent_at' => now(),
        ]);
    }

    /**
     * All reason labels recognised by the system.
     *
     * @return array<string, string>
     */
    public static function reasonLabels(): array
    {
        return self::MEMBER_REASON_LABELS;
    }

    /**
     * Generate and persist a QR code image for this pass using the token.
     * Stores the PNG under the public disk at qrcodes/<token>.png and
     * updates the `qr_code_path` attribute.
     *
     * Returns the relative storage path (within public disk).
     */
    public function generateQrCodeImage(?string $payload = null, int $size = 512): string
    {
        if (!$this->qr_code_token) {
            // Ensure a token exists to uniquely identify this pass
            $this->qr_code_token = (string) str()->uuid();
        }

        $payload ??= $this->qr_code_token;
        $path = 'qrcodes/' . $this->qr_code_token . '.png';

        // Defer to simple-qrcode if available; otherwise write a placeholder
        if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
            $png = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->size($size)
                ->margin(1)
                ->errorCorrection('M')
                ->generate($payload);
            Storage::disk('public')->put($path, $png);
        } else {
            // Minimal placeholder image indicating missing QR dependency
            $placeholder = base64_decode('iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAALUlEQVRYR+3PMQEAAAgDINc/9C0YgYy0n0hQFQAAAAAAAAAAAAAAAAAAAAAAwEwG3p3G9r7dAAAAAElFTkSuQmCC');
            Storage::disk('public')->put($path, $placeholder);
        }

        $this->qr_code_path = $path;
        $this->save();

        return $path;
    }
}
