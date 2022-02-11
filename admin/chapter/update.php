<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $ss_user_id = $_SESSION['id'];
    $ss_user_id = 1;
    // $role = $_SESSION['role'];
    $role = 0;
    if($role != 0) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn không thể sửa chương của người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }

    if(empty($_GET['chap_id']) || ($_GET["chap_id"] < 1)) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Phải truyền mã hợp lệ để chỉnh sửa!";
        $_SESSION['info_type'] = "error";

        header('Location: search.php');
        exit;
    }

    $chap_id = addslashes($_GET["chap_id"]);

    // Nếu đúng là tác giả thì được phép chỉnh sửa
    $sql = "SELECT user.id FROM chapter
    join novel 
    on chapter.novel_id = novel.id
    join user
    ON novel.user_id = user.id
    where chapter.chap_id = '$chap_id'";

    $sql_result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($sql_result);
    $user_id = $row['id'];
    
    if(isset($ss_user_id)) {
        if($user_id != $ss_user_id) {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
    
    // ----------------------------------------------------------------
    $sql = "select * from chapter where chap_id = '$chap_id'";
    $sql_result = mysqli_query($conn, $sql);
    $number_rows = mysqli_num_rows($sql_result);
    
    if($number_rows != 1) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Không tìm thấy chương theo mã này!";
        $_SESSION['info_type'] = "error";

        header('Location: index.php');
        exit;
    }

    $result = mysqli_fetch_array($sql_result);

    $sql = "SELECT title FROM novel 
    join chapter
    on novel.id = chapter.novel_id
    where chap_id = '$chap_id'";
    $result_novel = mysqli_query($conn, $sql);
    $novel = mysqli_fetch_array($result_novel);
    $novel_title = $novel['title'];
    
    mysqli_close($conn);
?>
<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Sửa chương') ?>

    <script defer src = "../../js/script.js"></script>
    <script defer src = "../../js/toast_msg.js"></script>
</head>
<body>
    <div id="toast"></div>

    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" id="form-update" method="POST" enctype="multipart/form-data" action="process_update.php">
            <h1 class= "form__title form__title--large">Truyện: <?php echo $novel_title?></h1>
            <h2 class= "form__title">Sửa chương <?php echo $result["chap"]?></h1>
            <input type="hidden" name="chap_id" value="<?php echo $chap_id?>"/>
            <input type="hidden" name="novel_title" value="<?php echo $novel_title?>"/>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="chapter_content" id="" cols="30" rows="50" placeholder="Nhập nội dung chương" class="form-control" rules="required"><?php echo $result["chapter_content"]?></textarea>
                <span class="form-message"></span>
            </div>

            <button type="submit">Sửa nội dung chương</button>
        </form>
    </div>

    <?php require_once ('../root/footer.php'); ?>

    <script type="module">
        import Validator from "../../js/validator.js"
        const formAdd = new Validator('#form-update')
    </script>
</body>
</html>