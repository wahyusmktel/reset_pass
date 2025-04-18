<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleWorkspaceService;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class GoogleUserController extends Controller
{
    public function index(GoogleWorkspaceService $google)
    {
        if (request()->has('refresh')) {
            Cache::forget('google_users_cache');
        }

        $q = request('q');
        $allUsers = collect($google->listUsers());

        $filtered = $allUsers->filter(function ($user) use ($q) {
            return !$q || Str::contains(
                strtolower($user['email'] . ' ' . $user['name']),
                strtolower($q)
            );
        });

        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedData = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $users = new LengthAwarePaginator(
            $pagedData,
            $filtered->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.google-users.index', compact('users'));
    }

    public function show($id, GoogleWorkspaceService $google)
    {
        $user = $google->getUser($id); // Pastikan ini return array

        return view('admin.google-users.show', compact('user'));
    }

    public function reset($id, Request $request, GoogleWorkspaceService $google)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        try {
            $google->resetPasswordById($id, $request->password);

            return back()->with('success', 'Berhasil reset password akun: ' . $id);
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }
}
