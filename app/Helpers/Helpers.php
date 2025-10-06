<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\LogStatus;


if (!function_exists('loggedin')) {
    function loggedin()
    {
        return Auth::check() || user() !== null;
    }
}

if (!function_exists('log_status')) {
    function log_status($data)
    {
        try {
            LogStatus::create([
                'id_detail'           => $data['id_detail'],
                'model'               => $data['model'] ?? null,
                'deskripsi'           => $data['deskripsi'] ?? null,
                'controller_function' => $data['controller_function'] ?? null,
                'id_user'             => auth()->id(),
                'nama'                => auth()->user()->name,
                'ip_address'          => request()->ip()
            ]);
        } catch (\Exception $e) {
            Log::error('DB Logging Error: ' . $e->getMessage());
        }
    }
}

if (!function_exists('setUser')) {
    function setUser()
    {
        session()->put('user', Auth::user());
    }
}

if (!function_exists('user')) {
    function user($func = null)
    {
        $user = Auth::user() ?? session('user');

        if (!$user) {
            return null;
        }

        switch ($func) {
            case 'name':
                return $user->name;
            case 'username':
                return $user->username;
            case 'email':
                return $user->email;
            default:
                return $user;
        }
    }
}

if (!function_exists('setRole')) {
    function setRole(array $role = null)
    {
        $roles = $role ?? (Auth::user() ? Auth::user()->getRoleNames()->toArray() : []);
        session()->put('role', $roles);
    }
}

if (!function_exists('role')) {
    function role($checkRole)
    {
        $roles = session('role', []);
        return in_array($checkRole, $roles);
    }
}

if (!function_exists('getRole')) {
    function getRole()
    {
        return session('role', []);
    }
}

if (!function_exists('PermissionChecking')) {
    function PermissionChecking($param)
    {
        /**
         * The param that are mass assignable.
         *
         * @param array<string>
         */

        if (!Gate::any($param)) {
            return abort(403);
        }
    }
}
