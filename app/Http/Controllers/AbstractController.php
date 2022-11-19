<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class AbstractController extends Controller
{
    /**
     * returns a simple json response with message, status and code
     *
     * @param  string $message
     * @param  bool $status
     * @param  int $code
     * @return JsonResponse
     */
    protected function simpleJsonResponse(string $message, bool $status, int $code): JsonResponse
    {
        return (new JsonResponse([
            'status' => $status,
            'message' => $message,
        ]))->setStatusCode($code);
    }
}
