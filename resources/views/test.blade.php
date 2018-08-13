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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var url = 'http://factory.test/crane';
    var data = {
        item_id: 2,
        right_unit_id: 1,
        produce_unit_id: 1,
        is_monitor: 1,
        driver: 1,
        record_no: '123',
        floor_no: '1#',
        model: '123',
        left_no: '12321312',
        parameters: "a: {a:1}",
        left_at: '2018-02-12 23:22:11',
        install_unit_id: parseInt('1'),
        sn: '123',
        GPRS: '32323232',
        validity_month: 10,
        model: 10,
        paid_at: '2018-02-12 23:22:11',
        installed_at: '2018-02-12 23:22:11',
        function_config: 'a: {a:1}',
        identify: 'a: {a:1}',
    };
    $.post(url, data, function(res) {
        console.log(res)
    });
</script>
</body>
</html>