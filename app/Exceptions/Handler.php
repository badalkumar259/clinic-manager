<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {

        if ($request->expectsJson() && $request->is('api/*')) {

            // Check if Authorization header exists
            $bearer = $request->header('Authorization');

            if (empty($bearer)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token missing!'
                ], 401);
            }

            // Check if Bearer token is given but invalid
            if (str_starts_with($bearer, 'Bearer ') && ! $request->user()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired token!'
                ], 401);
            }

            // Default fallback
            return response()->json([
                'error' => 'Unauthenticated.'
            ], 401);
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
