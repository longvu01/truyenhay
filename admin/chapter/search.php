<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    ///
    $_SESSION['role'] = 0;
    $role = $_SESSION['role'];
    ///
    $_SESSION['id'] = 1;
    $user_id = $_SESSION['id'];

    // Number records / page
    $_SESSION['nop'] = 5;
    // Number buttons page display
    $_SESSION['window'] = 5;

    // Default search = ""
    $search = "";
    if(isset($_GET['search'])){
        $search = addslashes($_GET['search']);
    }

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Tìm chương') ?>
    <script defer src = "../../js/script.js"></script>
    <!-- <script defer src = "./js/get_data_search.js"></script> -->
    <script defer src = "./js/test.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
    <?php require ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <!-- SEARCH -->
        <form class="form form__process" id="form-search" method="GET">
            <h1 class= "form__title">Tìm chương</h1>
            <div class="form__search">
                <input id="input-search" name="search" type="search" value="<?php echo $search ?>" placeholder="Nhập tên truyện cần tìm"/>
                <button>Tìm tên truyện</button>
            </div>
            <table>
                <!-- Spinner -->
                <!--  -->
                <tr id="row">
                    <th>Tên truyện</th>
                    <th>Chương</th>
                    <th>Nội dung</th>
                    <?php if($role == 1) { ?>
                        <th>Xem, Duyệt</th>
                        <th>Xóa</th>
                        <?php } else {?>
                        <th>Duyệt</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    <?php } ?>
                </tr>
            </table>
            <br/>
            <br/>
            <div class="load-spinner hidden"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </form>
        <div class="pagination"></div>
    </div>

    <?php require_once ('../root/footer.php'); ?>
    
    <script src = "../../js/toast_msg.js"></script>
    <?php require_once ('../root/show_toast.php'); ?>
</body>
</html>