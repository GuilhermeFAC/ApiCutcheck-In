<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Nette\Utils\Json;

trait HttpResponses
{
    protected function sucess($data, $message = null, $code = 200)
    {
        return response()->Json([
            'status' => 'Request was succesful',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response()->Json([
            'status' => 'Error was occurred!',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
};
