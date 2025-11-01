<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryPass extends Model
{
    /** @use HasFactory<\Database\Factories\TemporaryPassFactory> */
    use HasFactory;

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
        'valid_from',
        'valid_until',
        'approved_by',
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
}

