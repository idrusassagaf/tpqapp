<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting kolom
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * ======================
     * ROLE HELPERS
     * ======================
     */

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isAdminPendaftaran()
    {
        return $this->role === 'admin_pendaftaran';
    }

    public function isAdminBerita()
    {
        return $this->role === 'admin_berita';
    }

    public function isViewer()
    {
        return $this->role === 'viewer';
    }
    public function isAdmin()
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function canViewData()
    {
        return in_array($this->role, ['super_admin', 'admin', 'viewer']);
    }

    public function canManageData()
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function canPendaftaran()
    {
        return $this->role === 'pendaftaran';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }
}
