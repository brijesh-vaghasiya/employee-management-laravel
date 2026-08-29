<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginLog;

class LogFailedLogin
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
    public function handle(Failed $event): void
    {
        $email = $event->credentials['email'] ?? 'Unknown Email';
        $guard = $event->guard ?? 'Unknown Guard';

        LoginLog::create([
            'email' => $email,
            'role' => $guard, // Using guard to hint at attempt type
            'result' => 'Failed',
            'ip_address' => request()->ip(),
            'login_date' => now(),
        ]);
    }
}
