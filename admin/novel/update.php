<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    // $ss_user_id = $_SESSION['id'];
    $ss_user_id = 1;
    $role = 0;

    $id = addslashes($_GET["id"]);
    // Nếu đúng là tác giả thì được phép sửa
    $sql = "SELECT user.id FROM novel
    join user
    ON novel.user_id = user.id
    where novel.id = '$id'";
    $sql_result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($sql_result);
    $user_id = $row['id'];

    if($user_id != $ss_user_id) {
        header('Location: index.php');
        die();
    } else if ($role != 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn không thể sửa truyện của người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        die();
    }

    // Truyền mã không hợp lệ
    if(empty($_GET['id']) || ($_GET['id'] < 1)) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Phải truyền mã hợp lệ để chỉnh sửa!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        die();
    }

    // Không tìm được truyện theo mã
    $sql = "select * from novel where id = '$id'";
    $sql_result = mysqli_query($conn, $sql);
    $number_rows = mysqli_num_rows($sql_result);
    if($number_rows != 1) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Không tìm thấy truyện theo mã này!";
        $_SESSION['info_type'] = "error";
        
        header('Location: index.php');
        die();
    }
    // ----------------------------------------------------------------
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
    <script defer src = "../../js/main.js"></script>
    <script defer src = "../../js/toast_msg.js"></script>
</head>
<body>
    <div id="toast"></div>

    <?php require_once ('../root/header_admin.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" id="form-update" method="POST" enctype="multipart/form-data" action="process_update.php">
            <h1 class= "form__title">Sửa truyện</h1>
            <input type="hidden" name="id" value="<?php echo $id?>"/>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select name="category_id" class="form-control" rules="required">
                        <?php foreach ($cates as $cate) {?>
                            <option value="<?php echo $cate["id"]?>" 
                                <?php if ($cate["id"] == $result["category_id"]){?> 
                                    selected 
                                <?php } ?>>
                                <?php echo $cate["category_name"]?>
                            </option>
                        <?php } ?>
                    </select>
                    <span class="form-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title" value="<?php echo $result["title"]?>" placeholder="Nhập tiêu đề" class="form-control" rules="required"/>
                <span class="form-message"></span>

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
                <input name="status" value="<?php echo $result["status"]?>" placeholder="Nhập trạng thái truyện(Hoàn thành/ Chưa hoàn thành)" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label>Tác giả</label>
                <input name="author" value="<?php echo $result["author"]?>" placeholder="Nhập tên tác giả" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>

            <div class="form-group">
                <label>Xem trước</label>
                <textarea name="pre_view" id="" cols="30" rows="10" placeholder="Nhập nội dung xem trước" class="form-control" rules="required"><?php echo $result["pre_view"]?></textarea>
                <span class="form-message"></span>
            </div>

            <button type="submit">Sửa thông tin</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src = "../../js/validator.js"></script>
    <script>
        const formAdd = new Validator('#form-update')
    </script>
</body>
</html>