<?php
    session_start();
    require_once("../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    $_SESSION['role'] = 1;
    $role = $_SESSION['role'];

    require_once("../root/check_permission_admin.php");

    if(empty($_GET['chap_id']) || ($_GET["chap_id"] < 1)) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Phải truyền mã hợp lệ để chỉnh sửa!";
        $_SESSION['info_type'] = "error";

        header('Location: search.php');
        exit;
    }

    $chap_id = addslashes($_GET["chap_id"]);
    
    // Kiểm tra có nằm trong bảng chờ duyệt ?
    $sql = "select * from verify_queue_chapter where chap_id = '$chap_id'";
    $sql_result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($sql_result);
    $number_rows = mysqli_num_rows($sql_result);
    if($number_rows != 1) {
        // Kiểm tra có nằm trong bảng chapter ?
        $sql = "select * from chapter where chap_id = '$chap_id'";
        $sql_result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($sql_result);
        $number_rows = mysqli_num_rows($sql_result);

        if($number_rows != 1) {
            $_SESSION['info_title'] = "Có lỗi!";
            $_SESSION['info_message'] = "❌Không tìm thấy chương theo mã này!";
            $_SESSION['info_type'] = "error";
            
            header('Location: search.php');
            exit;
        }
    }

    // Lấy ID truyện, chap
    $sql = "select novel_id, chap from chapter 
    where chap_id = '$chap_id'";
    $sql_result = mysqli_query($conn, $sql);
    $result_tmp = mysqli_fetch_array($sql_result);
    $novel_id = $result_tmp['novel_id'];
    
    // Lấy tên truyện
    $sql = "select title from novel where id = $novel_id";
    $novel_title_query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($novel_title_query);
    $novel_title = $row['title'];

    mysqli_close($conn);
?>
<!-- Start HTML -->
    <?php require_once ('../root/zz.php')?>
    <?php zz('Xem nội dung') ?>
    <script defer src = "../assets/js/script.js"></script>
</head>
<body>

    <?php require_once ('../root/header.php')?>
    <?php require_once ('../root/menu.php')?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" method="POST" action="./process/verify.php">
            <h1 class= "form__title form__title--large">Truyện: <?php echo $novel_title?></h1>
            <h2 class= "form__title">Duyệt chương <?php echo $result_tmp["chap"]?></h1>
            <input type="hidden" name="chap_id" value="<?php echo $chap_id?>"/>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="chapter_content" cols="30" rows="50"><?php echo $result["chapter_content"]?></textarea>
            </div>

            <button type="submit" name="submit">Duyệt nội dung chương</button>
        </form>
    </div>

    <?php require_once ('../root/footer.php')?>
</body>
</html>