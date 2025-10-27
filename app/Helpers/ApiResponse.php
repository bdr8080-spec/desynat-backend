<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Generate a standardized JSON response.
     *
     * @param string $status
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public static function generateResponse(string $status, string $message, $data = null, int $code = 200): JsonResponse
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
