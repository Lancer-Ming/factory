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

function curl_post($url='',$postdata='',$options=array()){
    $ch=curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($options)){
        curl_setopt_array($ch, $options);
    }
    $data=curl_exec($ch);
    curl_close($ch);
    return $data;
}