<?php

namespace App\Exceptions;

use App\Mail\ExceptionMail;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $this->sendEmail($e); // sends an em
        });
    }

    /**
     * Send the exception via email
     * @param Throwable $exception
     * @return void
     */
    public function sendEmail(Throwable $exception)
    {
        try {
            Mail::to('dev@noop.pt')->send(new ExceptionMail($exception));
        } catch (Exception $ex) {
            Log::error($exception);
            Log::error($ex);
        }
    }
}
