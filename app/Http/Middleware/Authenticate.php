<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Authenticate extends Middleware
{
    use HasApiTokens, Notifiable;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    

    
}
