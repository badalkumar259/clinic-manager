<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

function activity_log($action, $model, $user = null, $meta = [])
{
    $userId = $user ? $user->id : auth()->id();
    ActivityLog::create([
        'user_id' => $userId,
        'action' => $action,
        'model_type' => get_class($model),
        'model_id' => $model->id ?? null,
        'meta' => $meta,
    ]);
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return Auth::check() && Auth::user()->role == 'Admin';
    }
}

if (!function_exists('isClinician')) {
    function isClinician()
    {
        return Auth::check() && Auth::user()->role == 'clinician';
    }
}
