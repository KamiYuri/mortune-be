<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected function success($data=null, $message=null, $code=200): JsonResponse
    {
        return response()->json([
            'status' => 'OK',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message, $code): JsonResponse
    {
        return response()->json([
            'status' => 'FAILED',
            'message' => $message,
        ], $code);
    }
}
