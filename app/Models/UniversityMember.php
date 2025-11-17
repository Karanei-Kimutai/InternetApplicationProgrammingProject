<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UniversityMember extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The database connection that should be used by the model.
     * This points to the connection we defined in config/database.php
     *
     * @var string
     */
    protected $connection = 'university';

    /**
     * The table associated with the model.
     * This points to the database VIEW in the external database.
     *
     * @var string
     */
    protected $table = 'v_university_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_url',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get all of the member's temporary passes.
     */
    public function passes()
    {
        return $this->morphMany(TemporaryPass::class, 'passable');
    }
}

