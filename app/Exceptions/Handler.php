<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
// use Illuminate\Database\QueryException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if ($exception instanceof \Illuminate\Database\QueryException) 
        //     {
        //         $status = Response::HTTP_METHOD_NOT_ALLOWED;
        //         $exception = new MethodNotAllowedHttpException([],                 
        //         'HTTP_METHOD_NOT_ALLOWED', $exception);
        //     }
        return parent::render($request, $exception);


        // if ($e instanceof ModelNotFoundException) {
        //     $response_code = Response::HTTP_NOT_FOUND;
        //     $e = new NotFoundHttpException('Resource non trouvée.', $e);
        // } elseif ($e instanceof NotFoundHttpException) {
        //     $response_code = Response::HTTP_NOT_FOUND;
        //     $e = new NotFoundHttpException('Service non trouvé.', $e);
        // } elseif ($e instanceof QueryException) {
        //     $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
        //     $e = new QueryException('Requête échouée.', $e);
        // } else {
        //     $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
        //     $e = new HttpException($response_code, 'Erreur interne au serveur.');
        // }

        // return response()->json([
        //     'response_code' => $response_code,
        //     'response_message' => $e->getMessage()
        // ], $response_code);
    }
}
