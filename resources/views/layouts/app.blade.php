<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '安拾智慧工地管理平台') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/page.css') }}" rel="stylesheet">
</head>
<body>
<div id="layout-app">
    <el-container class="page-container">
        @include('layouts._header')
        <el-container class="section-container">
            @include('layouts._sidebar')
            <el-container class="main-container">
                <el-main class="main-wrapper">
                    <breadcrumb></breadcrumb>
                    <div class="view-container" :class="this.$route.path.split('/').join('_').substr(1)">
                        <router-view/>
                    </div>
                </el-main>
            </el-container>
        </el-container>
        <el-footer style="height: auto">
            2018 © 广东德实控股有限公司<p style="color:#666;">安拾科技技术支持</p>
        </el-footer>
    </el-container>
</div>
{{--<script src="https://unpkg.com/element-ui@2.4.2/lib/index.js"></script>--}}
{{--<script src="{{ mix('js/manifest.js') }}"></script>--}}
{{--<script src="{{ mix('js/vendor.js') }}"></script>--}}
<script src="{{asset('vendor/ckplayer/ckplayer/ckplayer.js')}}"></script>
{{--<script src="{{ asset('js/ezuikit.js') }}"></script>--}}
<script src="{{ mix('js/main.js') }}"></script>

</body>
</html>