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
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="/js/socket.io.js"></script>
<script>
    var ws = new WebSocket("ws://120.132.116.135:8383");

    ws.onmessage = function(e) {
        var data = eval("("+ e.data + ")")
        var type = data.type || ''
        console.log(data)

        switch (type) {
            //将接收到的client_id发送给后台进行绑定
            case "init" :
//                $.post('/admin/chat/bind', {client_id: data.client_id})
                break
            case "logout" :

                break
            //say 发送消息了
            default :
                console.log(data)
        }
    }.bind(this)
</script>
</body>
</html>