<?php

namespace App\Listeners;

use Request;
use App\Events;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events as LaravelEvents;

class LogActivity
{
    public function login(LaravelEvents\Login $event)
    {
        $ip = \Request::getClientIp(true);
        //$ua = $request->header('User-Agent');
        $server = \Request::server();
        $userAgent = $server['HTTP_USER_AGENT'];
        $this->info($event, "User {$event->user->email} logged in from {$ip} {$userAgent}", $event->user->only('id', 'email'));
        try {
            DB::table('authentication_log')->insert([
                'authenticatable_type' => 'Login',
                'authenticatable_id' => $event->user->id,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'login_at' => date('Y-m-d H:i:s'),
                'login_successful' => 1
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout(LaravelEvents\Logout $event)
    {
//        $ip = \Request::getClientIp(true);
//        $this->info($event, "User {$event->user->email} logged out from {$ip}", $event->user->only('id', 'email'));
        $ip = \Request::getClientIp(true);
        try {
            $result = DB::table('authentication_log')->latest('login_at')->first();
            DB::table('authentication_log')->where('id', $result->id)->update([
                'logout_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function registered(LaravelEvents\Registered $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info($event, "User registered: {$event->user->email} from {$ip}");
    }

    public function failed(LaravelEvents\Failed $event)
    {
//        $ip = \Request::getClientIp(true);
//        $this->info($event, "User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
        $ip = \Request::getClientIp(true);
        //$ua = $request->header('User-Agent');
        $server = \Request::server();
        $userAgent = $server['HTTP_USER_AGENT'];
        try {
            DB::table('authentication_log')->insert([
                'authenticatable_type' => 'Login',
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'login_at' => date('Y-m-d H:i:s'),
                'login_successful' => false
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function passwordReset(LaravelEvents\PasswordReset $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info($event, "User {$event->user->email} password reset from {$ip}", $event->user->only('id', 'email'));
    }

    protected function info(object $event, string $message, array $context = [])
    {
        //$class = class_basename($event::class);
        $class = get_class($event);

        Log::info("[{$class}] {$message}", $context);
    }
}
