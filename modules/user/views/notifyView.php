<html>

<head>
    <title>AdminIsmart - Khôi phục mật khẩu</title>
    <link rel="stylesheet" href="public/css/reset.css" />
    <link rel="stylesheet" href="public/css/recover_pass.css" />
    <style>
        #notify {
            width: 400px;
            padding: 10px;
            margin: 100px auto;

            text-align: center;
            background-color: antiquewhite;
        }

        #notify a {
            text-decoration: underline;
            color: green;
            font-size: 18px;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div id="notify">

        <p>
            <?php echo get_result() ?>
        </p>
        <a href="?">Đăng nhập Ismart</a>
    </div>

</body>

</html>