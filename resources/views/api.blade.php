<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
11
<script src="/js/jquery.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var url = '{{ route('system.user.update', ['user'=> 7]) }}';
    var data = {
        username: '1234',
        realname: '1234',
        sex: 1,
        email: '123456789@qq.com',
        role_id: '3',
        password: '123123'
    };
    var method = 'PATCH';
    $.ajax({
        url: url,
        method: method,
        data: data,
        success: function(res) {
            console.log(res)
        },
        error: function(error) {
            console.log(error)
        }
    });
</script>
</body>
</html>