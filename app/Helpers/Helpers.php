<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;



if (!function_exists('loggedin')) {
    function loggedin()
    {
        return Auth::check() || user() !== null;
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
