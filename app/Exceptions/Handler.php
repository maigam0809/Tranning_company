<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
// use App\Exceptions\ExceptionTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Response;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use \Illuminate\Validation\ValidationException;
use App\Traits\TraitResponse;

class Handler extends ExceptionHandler
{
    use TraitResponse;

    protected $dontReport = [
        
    ];

  
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
        });

        $this->renderable(function(TokenInvalidException $e, $request){
            return $this->responseApi(['message'=>'Invalid token'],401);
        });
        
        $this->renderable(function (TokenExpiredException $e, $request) {
            return $this->responseApi(['message'=>'Token has Expired'],401);
        });

        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return $this->responseApi([
                'success' => false,
                'message'=>'User not found',
        ],401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return $this->responseApi([
                'success' => false,
                'message'=>'Token not parsed'],401
            );
        });


        $this->renderable(function (ValidationException $e, $request) {
            return $this->responseApi([
                'success' => false,
                'message'=>$e->getMessage()],401
            );
        });
    }
}
