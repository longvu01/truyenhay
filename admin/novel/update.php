<?php
    session_start();
    require_once("../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    // $_SESSION['id'] = 1;
    $ss_user_id = $_SESSION['id'];
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
        exit;
    } else if ($role != 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn không thể sửa truyện của người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }

    // Truyền mã không hợp lệ
    if(empty($_GET['id']) || ($_GET['id'] < 1)) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Phải truyền mã hợp lệ để chỉnh sửa!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
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
        exit;
    }
    // ----------------------------------------------------------------
    $result = mysqli_fetch_array($sql_result);

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>
<!-- Start HTML -->
    <?php require_once ('../root/zz.php')?>
    <?php zz('Sửa truyện') ?>
    <script defer src = "../assets/js/script.js"></script>
    <script defer src = "../assets/js/toast_msg.js"></script>
</head>
<body>
    <div id="toast"></div>

    <?php require_once ('../root/header.php')?>
    <?php require_once ('../root/menu.php')?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" id="form-update" method="POST" enctype="multipart/form-data" action="./process/process_add_to_queue.php">
            <h1 class= "form__title">Sửa truyện</h1>
            <input type="hidden" name="novel_id" value="<?php echo $id?>"/>
            <input type="hidden" name="total_chapters" value="<?php echo $result["total_chapters"]?>"/>
            
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
                <input type="hidden" name="old_title" value="<?php echo $result["title"]?>"/>
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

    <?php require_once ('../root/footer.php')?>

    <script type="module">
        import Validator from "../assets/js/validator.js"
        const formAdd = new Validator('#form-update')
    </script>
</body>
</html>