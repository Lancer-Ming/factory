<?php

function successJson($data='', $msg='', $status=200, $extra=null)
{
    return  response()->json([
        'data' => $data,
        'response_status' => 'success',
        'msg' => $msg
    ], $status);
}


function failJson($msg='', $status=401)
{
    return response()->json([
        'response_status' => 'fail',
        'msg' => $msg
    ], $status);
}


function createRandomPwd()
{
    return str_pad(random_int(1, 99999), 6, 0, STR_PAD_LEFT);
}