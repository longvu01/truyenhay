<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    // $user_id = $_SESSION['id'];
    $user_id = 1;

    // Default page = 1
    $p = isset($_REQUEST["p"]) ? addslashes($_REQUEST["p"]) * 1 : 0;
	if ($p < 1) $p = 1;
    
    // Default search = ""
    $search = "";
    if(isset($_GET['search'])){
        $search = addslashes($_GET['search']);
    }
    
    // Condition for each role
    $cond = '';
    if($role != 1) {
        $cond = "and user_id = '$user_id'";
    }

	$sql_total_records = "select count(*) from novel where title like '%$search%' $cond";
    $arr_total = mysqli_query($conn, $sql_total_records);
    $total_result = mysqli_fetch_array($arr_total);
    $total_records = $total_result['count(*)'];

    // Number records / page
    $nop = 5;

    $total_page = ceil($total_records / $nop);
    $offset = $nop * ($p - 1);
    // sql select and search
    $sql = "select
    novel.*,
    categories.category_name as c_name
    from novel 
    join categories on novel.category_id = categories.id
    where (novel.title like '%$search%' 
    or category_name like '%$search%'
    or author like '%$search%'
    or pre_view like '%$search%')
    $cond
    order by novel.id
    limit $nop offset $offset";
    // die($sql);
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/lazy.php'); ?>
    <?php lazy('Tìm kiếm truyện') ?>
    <script defer src = "../../js/main.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <!-- SEARCH -->
        <form class="form form__process" method="GET">
            <h1 class= "form__title">Tìm kiếm truyện</h1>
            <div class="form__search">
                <input name="search" type="search" value="<?php echo $search ?>" />
                <button>Tìm kiếm</button>
            </div>
            <table >
                <tr>
                    <th>Tên thể loại</th>
                    <th>Tiêu đề</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Tổng số chương</th>
                    <th>Xem trước</th>
                    <?php if($role == 1) { ?>
                        <th>Tác giả</th>
                        <th>Id truyện</th><!--  -->
                        <th>Xem, Duyệt</th><!--  -->
                        <th>Xóa</th>
                    <?php } else {?>
                            <th>Lượt xem</th>
                            <th>Duyệt</th>
                            <th>Thêm chương</th>
                            <th>Sửa</th>
                    <?php } ?>
                </tr>
                <?php foreach ($result as $item) {?>
                    <tr>
                        <td><?php echo $item['c_name'];?></td>
                        <td><?php echo $item['title'];?></td>
                        <td>
                            <img src="../../photos/<?php echo $item['img_link']?>">
                        </td>
                        <td><?php echo $item['status']?></td>
                        <td><?php echo $item['total_chapters'];?></td>
                        <td><p><?php echo nl2br($item['pre_view']);?></p></td>
                        <?php if($role == 1) { ?>
                            <td><?php echo $item['author'] ?></td>
                            <td><?php echo $item['id'];?></td>
                            <td>
                                <?php if($item['verify'] == 0) { ?>
                                    <a class="verify" href="view.php?id=<?php echo $item['id'];?>"><i class="fas fa-check-square"></i></a>
                                <?php } else {?>
                                    Đã duyệt
                                <?php } ?>
                            </td>
                            <td>
                                <a href="delete.php?id=<?php echo $item['id'];?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        <?php } else {?>
                            <td><?php echo $item['view_count'];?></td>
                            <td>
                                <?php echo $item['verify'] == 0 ? 'Chưa duyệt ❌' : 'Đã duyệt ✅' ?>
                            </td>
                            <td>
                                <a href="insert_chapter.php"><i class="far fa-plus-square"></i></a>
                            </td>
                            <td>
                                <a href="update.php?id=<?php echo $item['id'];?>"><i class="fas fa-edit"></i></a>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <br/>
        </form>
        <?php require_once ('../root/pagination.php'); ?>
    </div>

    <?php require_once ('../root/footer.php'); ?>
    
    <script src = "../../js/toast_msg.js"></script>
    <?php require_once ('../root/show_toast.php'); ?>
</body>
</html>