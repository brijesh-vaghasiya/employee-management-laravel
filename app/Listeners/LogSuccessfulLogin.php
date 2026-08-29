<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginLog;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $role = $user->role ?? (get_class($user) === 'App\Models\Employee' ? 'Employee' : 'Unknown');
        $email = $user->email ?? 'N/A';

        LoginLog::create([
            'email' => $email,
            'role' => $role,
            'result' => 'Success',
            'ip_address' => request()->ip(),
            'login_date' => now(),
        ]);
    }
}
