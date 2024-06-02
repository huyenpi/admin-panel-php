<html>

<head>
    <title>AdminIsmart - Khôi phục mật khẩu</title>
    <link rel="stylesheet" href="public/css/reset.css" />
    <link rel="stylesheet" href="public/css/recover_pass.css" />

    <style>
        #form-recover-pass label {
            font-weight: bold;
        }

        #form-recover-pass #btn-recover-pass {
            background: #4fa327;
            padding: 5px 10px;
            border: none;
            border-radius: 5%;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div id="wp-form-recover-pass">
        <form action="?mod=user&act=recoverPass&token=<?php echo get_value('token'); ?>" id="form-recover-pass"
            method='post'>
            <fieldset>
                <legend>Admin Ismart - Khôi phục mật khẩu</legend>
                <label for="new-password">Mật khẩu mới</label>
                <input type="password" name="new_password" id="new_password">
                <?php echo form_error('new_password'); ?>
                <label for="confirm_password">Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" id="confirm_password">
                <?php echo form_error('confirm_password'); ?>
                <button type="submit" name="btn-recover-pass" id="btn-recover-pass">Cập nhật</button>

            </fieldset>
        </form>
    </div>

</body>

</html>