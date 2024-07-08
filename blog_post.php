<?php
include 'database/dbhelper.php';
$blog_id = isset($_GET['blog_id']) ? intval($_GET['blog_id']) : 0;
$blog = executeSingleResult("SELECT * FROM blogs WHERE id=?", [$blog_id]);
include 'layout/header.php';
?>
<div class="blog-detail">
    <?php 
    if ($blog && !empty($blog)): 
    ?>
        <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
        <img src="./image/blog/<?php echo htmlspecialchars(basename($blog['image_path'])); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
        <div class="blog-content">
            <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
        </div>
    <?php 
    else: 
    ?>
        <p>Không tìm thấy bài viết.</p>
    <?php 
    endif; 
    ?>
</div>
<style>
body {
    background-color: #f7f7f7;
    font-family: 'Arial', sans-serif;
    padding: 0;
    margin: 0;
}
.blog-detail {
    max-width: 900px;
    margin: 50px auto;
    padding: 25px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    transition: transform .2s ease-in-out;
}
.blog-detail:hover {
    transform: translateY(-5px);
}
.blog-detail h2 {
    font-size: 32px;
    margin-bottom: 25px;
    color: #333;
    text-align: center;
}
.blog-detail img {
    max-width: 100%;
    height: auto;
    margin: 0 auto 25px auto;
    display: block;
    border-radius: 5px;
}
.blog-content p {
    font-size: 18px;
    line-height: 1.8;
    color: #555;
    text-align: justify;
}
.blog-content p:not(:last-child) {
    margin-bottom: 20px;
}
</style>
<?php include 'layout/footer.php'; ?>
