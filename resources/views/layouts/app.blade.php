<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/page.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <el-container>
        @include('layouts._header')
        <el-container>
            @include('layouts._sidebar')
            @include('layouts._main')
            @yield('content')
        </el-container>
        <el-footer style="height: auto">
            2018 © 广州市安拾科技有限公司
        </el-footer>
    </el-container>
</div>
{{--<script src="{{ mix('js/manifest.js') }}"></script>--}}
{{--<script src="{{ mix('js/vendor.js') }}"></script>--}}
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>