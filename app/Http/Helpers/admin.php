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