<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Thêm mới danh mục</h3>
                </div>
            </div>
            <?php echo get_result(); ?>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tên danh mục</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('product_cat_title'); ?>">
                        <?php echo form_error('product_cat_title') ?>
                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo set_value('slug'); ?>">
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc"><?php echo set_value('product_cat_desc'); ?></textarea>
                        <?php if (!empty($list_product_cat)) {
                            ?>
                            <label>Danh mục cha</label>
                            <select name="parent-cat">
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($list_product_cat as $cat_item) {
                                    ?>
                                    <option value="<?php echo $cat_item['product_cat_id']; ?>" <?php echo $cat_item['product_cat_id'] == set_value('parent_cat') ? "selected" : ""; ?>><?php echo $cat_item['product_cat_title']; ?></option>
                                <?php }
                                ?>
                            </select>
                        <?php }
                        ?>
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status">
                            <option value="public" <?php echo empty(set_value('status')) || set_value('status') == 'public' ? 'selected' : '' ?>>Công khai</option>
                            <option value="private" <?php echo set_value('status') == 'private' ? 'selected' : '' ?>>Riêng tư</option>
                        </select>
                        <button type="submit" name="btn-add" id="btn-add">Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

