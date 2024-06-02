<html>

<head>
    <title>AdminIsmart - Khôi phục mật khẩu</title>
    <link rel="stylesheet" href="public/css/reset.css" />
    <link rel="stylesheet" href="public/css/recover_pass.css" />

</head>

<body>
    <div id="wp-form-recover-pass">
        <form action="?mod=user&act=mailToReset" id="form-recover-pass" method='post'>
            <fieldset>
                <legend>Admin Ismart - Khôi phục mật khẩu</legend>

                <input type="email" name="email" placeholder="Email" value='<?php if ((!empty(get_value('email')))) {
                    echo set_value('email');
                } ?>' />

                <?php if (!empty(form_error('email'))) { ?>
                    <p class='error'>
                        <?php echo form_error('email'); ?>
                    </p>
                <?php } ?>

                <input type="submit" name="btn-mail-to-reset" value="Gửi mã" />
            </fieldset>
        </form>
    </div>

</body>

</html>