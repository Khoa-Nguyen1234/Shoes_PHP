<?php
include '../../database/dbhelper.php';
function truncateContent($content, $limit = 100) {
    if (strlen($content) <= $limit) {
        return $content;
    }
    $lastSpace = strrpos(substr($content, 0, $limit), ' ');
    return substr($content, 0, $lastSpace) . '...';
}
function isValidImageURL($url) {
    $extensions = ['jpeg', 'jpg', 'png', 'gif'];
    $path_parts = pathinfo($url);
    return in_array(strtolower($path_parts['extension']), $extensions);
}

$blogs = executeResult("SELECT * FROM blogs");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Entries</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
    <header>
        <h1>Blog Entries</h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="text" placeholder="Search blogs..." />
        </div>
        <div class="user-wrapper">
            <div>
                <h4>Admin</h4>
            </div>
        </div>
    </header>
    <main>
        <div class="add-blog-link">
            <a href="../blog/add_blog.php">Thêm Blog</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Tên Blog</th>
                    <th class="blog-content-column">Nội Dung</th>
                    <th>Hình ảnh</th>
                    <th>Tính năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blogs as $blog) : ?>
                    <tr>
                        <td><?= $blog['id'] ?></td>
                        <td><?= $blog['title'] ?></td>
                        <td><?= truncateContent($blog['content']) ?></td>
                        <td>
                            <?php if (!empty($blog['image_path']) && isValidImageURL($blog['image_path'])) : ?>
                                <img src="<?= $blog['image_path'] ?>" alt="Blog Image" class="blog-img">
                            <?php else : ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="../blog/edit_blog.php?id=<?= $blog['id'] ?>">Edit</a> |
                            <a href="../blog/delete_blog.php?id=<?= $blog['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa blog này hay không ?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
