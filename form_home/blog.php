<?php 
require_once('database/dbhelper.php');
$blogs = executeResult("SELECT * FROM blogs");
?>
<!-- Blog section start -->
<div class="blog fade-in" id="blog">
    <br>
    <div class="heading">
        <h1>Cẩm nang về <span> SHOESHOP</span></h1>
    </div>
    <div class="box-container">
        <?php foreach($blogs as $blog): ?>
            <div class="box">
                <img src="./image/blog/<?php echo basename($blog['image_path']); ?>" alt="">
                <div class="content">
                    <h3><?php echo $blog['title']; ?></h3>
                    <p><?php echo substr($blog['content'], 0, 150) . '...'; ?></p>
                    <a href="blog_post.php?blog_id=<?php echo $blog['id']; ?>" class="btn">Xem thêm</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Blog section end -->
