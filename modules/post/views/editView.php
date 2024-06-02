<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật bài viết</h3>
                </div>
                <?php echo get_result(); ?>
                <div class="section" id="detail-page">
                    <div class="section-detail">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <label for="title">Tiêu đề</label>
                            <input type="text" name="post_title" id="title" value="<?php echo $is_change == true ? set_value('post_title') : $post_item['post_title']; ?>">
                            <?php echo form_error('post_title'); ?>
                            <label for="title">Slug ( Friendly_url )</label>
                            <input type="text" name="slug" id="slug" value="<?php echo $is_change == true ? set_value('slug') : $post_item['slug']; ?>">
                            <?php echo form_error('slug'); ?>
                            <label for="desc">Mô tả</label>
                            <textarea name="post_desc" id="desc"><?php echo $is_change == true ? set_value('post_desc') : $post_item['post_desc']; ?></textarea>
                            <?php echo form_error('post_desc'); ?>
                            <label for="content">Nội dung</label>
                            <textarea name="post_content" id="content" class="ckeditor"><?php echo $is_change == true ? set_value('post_content') : $post_item['post_content']; ?></textarea>
                            <?php echo form_error('post_content'); ?>
                            <label>Hình ảnh</label>
                            <div id="uploadFile">
                                <input type="file" name="thumb" id="thumb">
                                <img src="<?php
                                $temp_thumb = !empty($post_item['post_thumb']) ? $post_item['post_thumb'] : "public/images/img-thumb.png";
                                echo $is_change == true ? set_value('upload_file') : $temp_thumb;
                                ?>"
                                     />
                            </div>
                            <?php if (!empty($list_post_cat)) {
                                ?>

                                <label for="cat">Danh mục cha</label>
                                <select name="cat" id="cat">
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php
                                    foreach ($list_post_cat as $cat_item) {
                                        ?>

                                        <option value="<?php echo $cat_item['post_cat_id'] ?>" 
                                        <?php
                                        if (!empty($post_cat_id)) {
                                            echo $post_cat_id;
                                        } else {
                                            echo ($post_item['post_cat_id'] == $cat_item['post_cat_id']) ? "selected" : "";
                                        }
                                        ?>>
                                            <?php echo $cat_item['post_cat_title'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('post_cat_id'); ?>
                                <label for='status'>Trạng thái</label>
                                <select name="status" id='status'>
                                    <?php $status = $is_change == true ? set_value('status') : $post_item['status']; ?>
                                    <option value = "publish" <?php echo $status == 'publish' ? 'selected' : ''; ?>>Xuất bản</option>
                                    <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Chờ duyệt</option>
                                    <option value="trash" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Thùng rác</option>
                                </select>
                            <?php }
                            ?>
                            <button type="submit" name="btn-edit" id="btn-edit">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#thumb").change(function () {
                if (this.files && this.files[0]) {
                    var fileReader = new FileReader();
                    fileReader.onload = function (event) {
                        console.log(fileReader.result);
                        $('#uploadFile img').attr('src', event.target.result);
                    };
                    fileReader.readAsDataURL(this.files[0]);
                }
            });
        })
    </script>
    <?php get_footer(); ?>

