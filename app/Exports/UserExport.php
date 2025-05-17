<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('name', 'email', 'role', 'created_at', 'last_login_at')
            ->get()
            ->map(function ($user) {
                $isActive = $user->last_login_at && $user->last_login_at->isAfter(now()->subDays(30));
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'status' => $isActive ? 'Active' : 'Inactive',
                    'created_at' => $user->created_at->format('d/m/Y'),
                    'last_login_at' => $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-'
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Role',
            'Status',
            'Tanggal Daftar',
            'Terakhir Login'
        ];
    }
}