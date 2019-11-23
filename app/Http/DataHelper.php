<?php
namespace App\Http;

class DataHelper
{
    public static function makeResponse($isSuccess, $message, $data = null) {
        return response()->json(['isSuccess'=> $isSuccess, 'message' => $message, 'data' => $data], 200);
    }
}