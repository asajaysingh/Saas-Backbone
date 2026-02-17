<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($data = null, $message = 'success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], (int) $status);
    }

    protected function error($message = 'Error', $error = null, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], (int) $status);
    }
}
