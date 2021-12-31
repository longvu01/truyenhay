<?php
require_once("../../cdb.php");

// $id = $_GET['id'];
$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 1;
if ($id < 1) {
    echo '<script>alert("Chưa có truyện nào!")</script>';
    echo"<script>window.location = 'custom_category.php'</script>";
    return ;
}

$location = "window.location = 'index.php'";
if(empty($_GET['id']) || ($id < 1)) {
    echo '<script>alert("❌Phải truyền mã hợp lệ để chỉnh sửa!")</script>';
    echo"<script>$location</script>";
}

$sql = "select * from novel where id = '$id'";

$sql_result = mysqli_query($conn, $sql);
$number_rows = mysqli_num_rows($sql_result);
if($number_rows != 1) {
    echo '<script>alert("❌Không tìm thấy truyện theo mã này!")</script>';
    echo"<script>$location</script>";
}

$result = mysqli_fetch_array($sql_result);

$sql = "select * from categories";
$cates = mysqli_query($conn, $sql);



mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa truyện</title>
    <link rel="stylesheet" href="../../css/reset1.css">
    <link rel="stylesheet" href="../../css/base1.css">
    <link rel="stylesheet" href="../../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php require_once ('../root/header_admin.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" method="POST" enctype="multipart/form-data" action="process_update.php">
            <h1 class= "form__title">Sửa truyện</h1>
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select name="category_id">
                        <?php foreach ($cates as $cate) {?>
                            <option value="<?php echo $cate["id"]?>" 
                                <?php if ($cate["id"] == $result["category_id"]){?> 
                                    selected 
                                <?php } ?>>
                                <?php echo $cate["category_name"]?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title" value="<?php echo $result["title"]?>"/>
            </div>

            <div class="form-group">
                <label>Đổi ảnh mới</label>
                <input name="img_link_new" type="file"/>
                <br>
                <br>
                <label>Hoặc vẫn giữ ảnh cũ</label>
                <img src="../../photos/<?php echo $result["img_link"]?>" width="200px"/>
                <input type="hidden" name="img_link_old" value="<?php echo $result["img_link"]?>"/>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <input name="status" value="<?php echo $result["status"]?>"/>
            </div>

            <div class="form-group">
                <label>Tác giả</label>
                <input name="author" value="<?php echo $result["author"]?>"/>
            </div>

            <div class="form-group">
                <label>Xem trước</label>
                <textarea name="pre_view" id="" cols="30" rows="10"><?php echo $result["pre_view"]?></textarea>
            </div>

            <button type="submit" name="submit">Sửa thông tin</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src="../../js/main.js"></script>
</body>
</html>