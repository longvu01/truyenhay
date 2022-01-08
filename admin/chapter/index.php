<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 0;
    // $user_id = $_SESSION['id'];
    $user_id = 1;
    
    $sql = "select * from novel where user_id = '$user_id'";
    $novels = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm chương</title>
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
        <form class="form form__process active" id="form-add" method="POST" enctype="multipart/form-data" action="process_insert.php">
            <h1 class= "form__title">Thêm chương</h1>

            <div class = "form__process--top">
                <div class="form-group">
                    <label>Chọn truyện của bạn</label>
                    <select name="novel_id" class="form-control" rules="required">
                        <option value="" hidden>Chọn truyện</option>
                            <?php foreach ($novels as $novel) {?>
                                <option value="<?php echo $novel["id"]?>">
                                    <?php echo $novel["title"]?>
                                </option>
                            <?php } ?>
                    </select>
                    <span class="form-message"></span>
                </div>
            </div>
            
            <div class="form-group">
                <label>Nội dung chương</label>
                <textarea name="chapter_content" id="" cols="30" rows="50" placeholder="Nhập nội dung chương" class="form-control" rules="required"></textarea>
                <span class="form-message"></span>
            </div>

            <button class="btn" type="submit">Thêm chương mới</button>
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