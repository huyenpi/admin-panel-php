<div id="sidebar" class="fl-left">
    <ul id="list-cat">
        <li <?php if (get_action() == 'reset') echo "class='active'"; ?>>
            <a href="?mod=user&act=reset" title="" >Đổi mật khẩu</a>
        </li>
        <li <?php if (get_action() == 'update') echo "class='active'"; ?>>
            <a href="?mod=user&act=update" title="" >Cập nhật thông tin</a>
        </li>
        <li  <?php if (get_controller() == 'team' && get_action() == 'index') echo "class='active'"; ?>>
            <a href="?mod=user&controller=team" title="">Nhóm quản trị</a>
        </li>
        <li>
            <a href="?mod=user&act=logout" title="">Thoát</a>
        </li>
    </ul>
</div>

