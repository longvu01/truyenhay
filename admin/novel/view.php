<?php
    session_start();
    require_once("../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    require_once("../root/check_permission_admin.php");

    // Truyền mã không hợp lệ
    if(empty($_GET['novel_id']) || ($_GET['novel_id'] < 1)) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Phải truyền mã hợp lệ để chỉnh sửa!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }
    
    $novel_id = addslashes($_GET["novel_id"]);
    // Không tìm được truyện theo mã
    $sql = "select * from verify_queue_novel where novel_id = '$novel_id'";
    $sql_result = mysqli_query($conn, $sql);
    $number_rows = mysqli_num_rows($sql_result);
    if($number_rows != 1) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Không tìm thấy truyện cần duyệt theo mã này!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }
    // ----------------------------------------------------------------
    $result = mysqli_fetch_array($sql_result);

    $sql = "select category_name, category_id
    from categories, verify_queue_novel
    where categories.id = verify_queue_novel.category_id
    and novel_id = '$novel_id'";

    $cate_name_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($cate_name_query);
    $cate_name = $row['category_name'];
    $category_id = $row['category_id'];

    mysqli_close($conn);
?>
<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Duyệt truyện') ?>
    <script defer src = "../assets/js/script.js"></script>
</head>
<body>

    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" method="POST" enctype="multipart/form-data" action="./process/verify.php">
            <h1 class= "form__title">Duyệt truyện</h1>
            <input type="hidden" name="novel_id" value="<?php echo $novel_id?>"/>
            <input type="hidden" name="category_id" value="<?php echo $category_id?>"/>

            <div class="form-group">
                <label>Thể loại</label>
                <input value="<?php echo $cate_name?>"/>
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title" value="<?php echo $result["title"]?>"/>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <img src="../../photos/<?php echo $result["img_link"]?>" width="200px"/>
                <input type="hidden" name="img_link_new" value="<?php echo $result["img_link"]?>"/>
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
                <textarea name="pre_view" cols="30" rows="10"><?php echo $result["pre_view"]?></textarea>
            </div>

            <button type="submit" name="submit">Duyệt truyện</button>
        </form>
    </div>

    <?php require_once ('../root/footer.php'); ?>
</body>
</html>