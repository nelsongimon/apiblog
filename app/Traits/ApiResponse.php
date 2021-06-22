<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
    private function responseObject(Model $data, $code = 200, $message = null, $status = true)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    private function responseCollection(Collection $data, $code = 200, $message = null, $status = true)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    private function successResponse($message, $code, $status = true)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
        ], $code);
    }

    private function errorResponse($error, $code, $status = false)
    {
        return response()->json([
            'status'  => $status,
            'error' => $error,
        ], $code);
    }
}
