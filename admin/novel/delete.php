<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo "<script>window.location = 'index.php' </script>";
        die();
    }

    $location = "window.location = 'index.php'";

    if(empty($_GET['id']) ) {
        echo "<script>alert('❌Yêu cầu không hợp lệ!')</script>";
        echo "<script>$location</script>";
        die();
    }

    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : 1;
    if ($id < 1) {
        echo "<script>alert('Chưa có truyện nào!')</script>";
        echo "<script>window.location = 'index.php' </script>";
        die();
    }
    // ----------------------------------------------------------------
    $sql = "select * from novel where id = $id";

    $sql_result = mysqli_query($conn, $sql);
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
    <title>Xóa truyện</title>
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
        <form class="form form__process" method="POST" enctype="multipart/form-data" action="process_delete.php">
            <h1 class= "form__title">Xóa truyện</h1>
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Thể loại</label>
                    <select disabled>
                        <?php foreach ($cates as $cate) {?>
                            <option value="<?php echo $cate["id"]?>" <?php if ($cate["id"] == $result["category_id"]){?> selected <?php } ?>>
                                <?php echo $cate["category_name"]?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tác giả</label>
                <input value="<?php echo $result["author"]?>" disabled/>
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input value="<?php echo $result["title"]?>" disabled/>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <input value="<?php echo $result["status"]?>" disabled/>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <image src="../../photos/<?php echo $result["img_link"]?>" width="300" disabled/>
            </div>
    
            <div class="form-group">
                <label>Tổng số chương</label>
                <input value="<?php echo $result["total_chapters"]?>" disabled/>
            </div>

            <div class="form-group">
                <label>Xem trước</label>
                <textarea name="pre_view" id="" cols="30" rows="10" disabled><?php echo $result["pre_view"]?></textarea>
            </div>

            <div class="form-group">
                <label>Lượt xem</label>
                <input value="<?php echo $result["view_count"]?>" disabled/>
            </div>

            <button id= "btn_del" type="submit" name="submit">Xóa truyện</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src="../../js/main.js"></script>
</body>
</html>