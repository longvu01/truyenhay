<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 0;
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
    <title>Thêm truyện</title>
    <link rel="stylesheet" href="../../css/reset1.css">
    <link rel="stylesheet" href="../../css/base1.css">
    <link rel="stylesheet" href="../../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src = "../../js/main.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header_admin.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    
    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process" id="form-add" method="POST" enctype="multipart/form-data" action="process_insert.php">
            <h1 class= "form__title">Thêm truyện</h1>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Thể loại</label>
                    <select name="category_id" class="form-control" rules="required">
                        <option value="" hidden>Chọn thể loại</option>
                        <?php foreach ($cates as $cate) {?>
                            <option value="<?php echo $cate["id"]?>">
                                <?php echo $cate["category_name"]?>
                            </option>
                        <?php } ?>
                    </select>
                    <span class="form-message"></span>
                </div>
            </div>
            <!-- User id qua session -->
            <input name="user_id" type = "hidden" value = "1"/>
            <!--  -->
            <div class="form-group">
                <label>Tác giả</label>
                <input name="author" placeholder="Nhập tên tác giả" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>
            
            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title" placeholder="Nhập tiêu đề" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>
            
            <div class="form-group">
                <label>Ảnh</label>
                <input name="img_link" type = "file" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>
            
            <div class="form-group">
                <label>Xem trước/ mô tả</label>
                <textarea name="pre_view" id="" cols="30" rows="10" class="form-control" rules="required"></textarea>
                <span class="form-message"></span>
            </div>

            <button class="btn" type="submit">Thêm truyện</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src = "../../js/toast_msg.js"></script>
    <?php if(isset($_SESSION['info_title']) && isset($_SESSION['info_message']) && isset($_SESSION['info_type'])) { ?>
        <?php 
            $info_title = $_SESSION['info_title'];
            $info_message = $_SESSION['info_message'];
            $info_type = $_SESSION['info_type'];
            unset($_SESSION['info_title']);
            unset($_SESSION['info_message']);
            unset($_SESSION['info_type']);
            echo "<script>showToast({
                title: '$info_title',
                message: '$info_message',
                type: '$info_type',
                duration: 5000,
            })</script>";
        ?>
    <?php }?> 
    
    <script src = "../../js/validator.js"></script>
    <script>
        const formAdd = new Validator('#form-add')
    </script>
</body>
</html>