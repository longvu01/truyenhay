<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    // $user_id = $_SESSION['id'];
    $user_id = 2;
    
    $sql = "select * from novel where user_id = '$user_id'";
    $novels = mysqli_query($conn, $sql);
    
    // Count
    $sql_total_records = "select count(*) from novel where user_id = '$user_id'";
    $arr_total = mysqli_query($conn, $sql_total_records);
    $total_result = mysqli_fetch_array($arr_total);
    $total_records = $total_result['count(*)'];

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Thêm chương') ?>
    <script defer src = "../../js/script.js"></script>
</head>
<body>
    <div id="toast"></div>

    <?php require_once ('../root/header.php'); ?>
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
                            <?php if($total_records != 0) { ?>
                                <?php foreach ($novels as $novel) {?>
                                    <option value="<?php echo $novel["id"]?>">
                                        <?php echo $novel["title"]?>
                                    </option>
                                <?php } ?>
                            <?php } else { ?>
                                <option disabled>Bạn chưa có truyện nào</option>
                            <?php } ?>
                    </select>
                    <span class="form-message"></span>
                </div>
            </div>
            
            <div class="form-group">
                <label>Nội dung chương</label>
                <textarea name="chapter_content" id="" cols="30" rows="50" 
                placeholder="Nhập nội dung chương" class="form-control" rules="required" <?php if($total_records == 0) echo 'disabled' ?>>
                </textarea>
                <span class="form-message"></span>
            </div>

            <button class="btn" type="submit" <?php if($total_records == 0) echo 'disabled' ?>>Thêm chương mới</button>
        </form>
    </div>

    <?php require_once ('../root/footer.php'); ?>
    
    <script src = "../../js/toast_msg.js"></script>
    <?php require_once ('../root/show_toast.php'); ?>

    <script type="module">
        import Validator from "../../js/validator.js"
        const formAdd = new Validator('#form-add')
    </script>
</body>
</html>