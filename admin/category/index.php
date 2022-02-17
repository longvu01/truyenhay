<?php
    session_start();
    require_once("../../connect.php");
    require_once("../root/check_permission.php");

    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        header('Location: ../');
        exit;
    }

    $sql = "select * from categories limit 5";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Tùy chỉnh thể loại') ?>
    <script defer src = "../assets/js/script.js"></script>
    <script defer src = "../assets/js/toast_msg.js"></script>
    <script type="module" defer src = "./js/mutate_data.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>

    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process" id="form-add">
            <h1 class= "form__title">Tùy chỉnh thể loại</h1>
            <div class="form-group">
                <label>Thể loại mới</label>
                <input id = "category_name" name="category_name" type="text" placeholder="Nhập tên thể loại" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>

            <button class="btn" type="submit">Thêm thể loại</button>
        </form>
        <!-- Search -->
        <div class="form form__process">
            <h1 class= "form__title">Thể loại hiện có</h1>
            <table id="table">
                <tr id="first-row">
                    <th>Tên thể loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </table>
            <!-- Spinner -->
            <div class="spinner-container">
                <div class="load-spinner hidden"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>
            <button class="btn__show-more">
                Hiển thị thêm 🔻
            </button>
        </div>

    </div>

    <?php require_once ('../root/footer.php')?>
</body>
</html>