<?php

namespace App\Exceptions;


use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->error('Not Found', 'Cannot be found.', '1.0', 404);
                } else if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    if ($e->getStatusCode() === 403) {
                        return response()->error('Forbidden', "You don't have permission to access this resource.", '1.0',  403);
                    }
                } else if ($e instanceof \Illuminate\Database\QueryException) {
                    return response()->error('Server Error', "Internal Server Error.", '1.0',  500);
                }
            }
        });
    }
}
