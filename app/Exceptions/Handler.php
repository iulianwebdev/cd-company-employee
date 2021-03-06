<?php

namespace App\Exceptions;

use App\Exceptions\ModelRelationNotEmptyException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson() 
            && (
                $exception instanceof ModelNotFoundException 
                ||
                $exception instanceof ModelRelationNotEmptyException
            )
        )
           {

                $response = [
                    'data' => [
                        'error' => 'An unknown error has occured',
                        'details' => [],
                        'status' => 404
                    ]
                ];

                if (Auth::check()) {
                    $response['data']['error'] = $exception->getMessage();
                    $response['data']['details'] = get_class($exception);
                    $response['data']['status'] = 400;
                }

                return response()->json($response, $response['data']['status']);
           }

        return parent::render($request, $exception);
    }
}
