<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    // $user_id = $_SESSION['id'];
    $user_id = 2;

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Thêm truyện') ?>
    <script defer src = "../../js/script.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    
    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process" id="form-add" method="POST" enctype="multipart/form-data" action="./process/process_insert.php">
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
            <input name="user_id" type = "hidden" value = "<?php echo $user_id ?>"/>
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

    <?php require_once ('../root/footer.php'); ?>
    
    <script src = "../../js/toast_msg.js"></script>
    <?php require_once ('../root/show_toast.php'); ?>
    
    <script type="module">
        import Validator from "../../js/validator.js"
        const formAdd = new Validator('#form-add')
    </script>
</body>
</html>