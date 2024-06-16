<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

     public const SUCCESS_OK = 1;
    public const SUCCESS_FALSE = 0;

    public function responseSuccess($code, $data = null): JsonResponse
    {
        $output = [
            'success' => self::SUCCESS_OK,
            'data' => $data,
        ];

        return response()->json($output, $code);
    }

    public function responseOk($data = null): JsonResponse
    {
        $output = [
            'success' => self::SUCCESS_OK,
            'data' => $data,
        ];

        return response()->json($output, Response::HTTP_OK);
    }

    public function responseError($code, $errorCode, $message, $data = null): JsonResponse
    {
        $output = [
            'success' => self::SUCCESS_FALSE,
            'data' => $data,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message
            ]
        ];

        return response()->json($output, $code);
    }
}
