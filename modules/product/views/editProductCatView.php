<?php get_header(); ?>
<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Cập nhật danh mục sản phẩm</h3>
                </div>
            </div>
            <?php echo get_result();
            ?>
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="title">Tên danh mục</label>
                        <input type="text" name="title" id="title" value="<?php echo $is_change == false ? $product_cat_item['product_cat_title'] : set_value('product_cat_title'); ?>">
                        <?php echo form_error('product_cat_title') ?>
                        <label for="title">Slug ( Friendly_url )</label>
                        <input type="text" name="slug" id="slug" value="<?php echo $is_change == true ? set_value('slug') : $product_cat_item['slug']; ?>">
                        <label for="desc">Mô tả</label>
                        <textarea name="desc" id="desc"><?php echo$is_change == true ? set_value('product_cat_desc') : $product_cat_item['product_cat_desc']; ?></textarea>
                        <?php if (!empty($list_product_cat)) {
                            ?>
                            <label>Danh mục cha</label>
                            <select name="parent-cat">
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($list_product_cat as $cat_item) {
                                    ?>
                                    <option value="<?php echo $cat_item['product_cat_id']; ?>" <?php echo $cat_item['product_cat_id'] == set_value('parent_cat') || $cat_item['product_cat_id'] == $product_cat_item['parent_cat_id'] ? "selected" : ""; ?>><?php echo $cat_item['product_cat_title']; ?></option>
                                <?php }
                                ?>
                            </select>
                        <?php }
                        ?>
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status">
                            <option value="public" <?php echo $product_cat_item['status'] == 'public' || set_value('status') == 'public' ? 'selected' : '' ?>>Công khai</option>
                            <option value="private" <?php echo $product_cat_item['status'] == 'private' || set_value('status') == 'private' ? 'selected' : '' ?>>Riêng tư</option>
                            <option value="trash" <?php echo $product_cat_item['status'] == 'trash' || set_value('status') == 'trash' ? 'selected' : '' ?>>Thùng rác</option>
                        </select>
                        <button type="submit" name="btn-edit" id="btn-edit">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>



