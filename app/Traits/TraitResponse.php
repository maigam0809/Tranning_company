<?php
namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Arr;
use Exception;
use Illuminate\Http\JsonResponse;

trait TraitResponse
{
	public function responseApi($data, int $status = 200): JsonResponse
    {
        $dataType = 'success';

        if (preg_match('/^[4|5].{2}$/', $status)) {
            $dataType = 'errors';
        }

        $responseFormat = [
            'api'    => request()->url(),
            $dataType => Arr::wrap($data),
        ];
        
        if (app()->bound('debugbar') && app('debugbar')->isEnabled()) {
            $debug = app('debugbar')->getData();
            $queries = collect($debug['queries']['statements'])
                ->map(function ($statement) {
                    return $statement['sql'];
                });
            $responseFormat['debug'] = [
                'queries' => $queries ?? null,
            ];
        }

        return response()->json($responseFormat, $status);
    }
}