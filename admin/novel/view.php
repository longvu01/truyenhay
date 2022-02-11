<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
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
    
    $id = addslashes($_GET["id"]);
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

    $sql = "select category_name
    from categories, novel
    where categories.id = novel.category_id
    and novel.id = '$id'";

    $cate_name_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($cate_name_query);
    $cate_name = $row['category_name'];

    mysqli_close($conn);
?>
<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Duyệt truyện') ?>
    <script defer src = "../../js/script.js"></script>
</head>
<body>

    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" method="POST" action="./process/verify.php">
            <h1 class= "form__title">Duyệt truyện</h1>
            <input type="hidden" name="id" value="<?php echo $id?>"/>

            <div class="form-group">
                <label>Thể loại</label>
                <input value="<?php echo $cate_name?>"/>
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input value="<?php echo $result["title"]?>"/>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <img src="../../photos/<?php echo $result["img_link"]?>" width="200px"/>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <input value="<?php echo $result["status"]?>"/>
            </div>

            <div class="form-group">
                <label>Tác giả</label>
                <input value="<?php echo $result["author"]?>"/>
            </div>

            <div class="form-group">
                <label>Xem trước</label>
                <textarea cols="30" rows="10"><?php echo $result["pre_view"]?></textarea>
            </div>

            <button type="submit" name="submit">Duyệt truyện</button>
        </form>
    </div>

    <?php require_once ('../root/footer.php'); ?>
</body>
</html>