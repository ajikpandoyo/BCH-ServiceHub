<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ListUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->status === 'active') {
            $query->whereNotNull('last_login_at')
                ->where('last_login_at', '>', now()->subDays(30));
        } elseif ($request->status === 'inactive') {
            $query->where(function($q) {
                $q->whereNull('last_login_at')
                    ->orWhere('last_login_at', '<=', now()->subDays(30));
            });
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        
        $users = $query->latest()->paginate(10);

        return view('admin.list-user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.list-user.show', compact('user'));
    }

    public function export()
    {
        return Excel::download(new UserExport, 'users-'.date('Y-m-d').'.xlsx');
    }
}