<html>

<head>
    <title>AdminIsmart-Trang đăng nhập</title>
    <link rel="stylesheet" href="public/css/reset.css" />
    <link rel="stylesheet" href="public/css/login.css" />
</head>

<body>
    <div id="wp-form-login">
        <form action="?mod=user&act=login" id="form-login" method='post'>
            <fieldset>
                <legend>Admin Ismart - Đăng nhập</legend>
                <?php if (!empty(form_error('account'))) { ?>
                    <p class='error'>
                        <?php echo form_error('account'); ?>
                    </p>
                <?php } ?>
                <input type="text" name="username" value="<?php if (!empty($username))
                    echo $username ?>" placeholder="Username" />
                <?php if (!empty(form_error('username'))) { ?>
                    <p class='error'>
                        <?php echo form_error('username'); ?>
                    </p>
                <?php } ?>
                <input type="password" name="password" value="" placeholder="Password" />
                <?php if (!empty(form_error('password'))) { ?>
                    <p class='error'>
                        <?php echo form_error('password'); ?>
                    </p>
                <?php } ?>
                <input type='checkbox' id='remember_me' name='remember_me' />
                <label for='remember_me'>Remember me</label>
                <input type="submit" name="btn-login" value="Đăng nhập" />
                <a href="?mod=user&act=mailToReset" id="lost-pass">Quên mật khẩu?</a>
            </fieldset>
        </form>
    </div>

</body>

</html>