<?php

function successJson($data='', $msg='', $status=200, $extra=null)
{
    return  response()->json([
        'info' => [
            "extra" => $extra,
            'data' => $data
        ],
        'response_status' => 'success',
        'msg' => $msg
    ], $status);
}


function failJson($msg='', $status='')
{
    return response()->json([
        'response_status' => 'fail',
        'msg' => $msg
    ], $status);

}