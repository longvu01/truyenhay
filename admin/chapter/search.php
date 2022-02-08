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
    $p = isset($_REQUEST["p"]) ? $_REQUEST["p"] * 1 : 0;
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

	$sql_total_records = "select sum(total_chapters) from novel where title like '%$search%' $cond";
    $arr_total = mysqli_query($conn, $sql_total_records);
    $total_result = mysqli_fetch_array($arr_total);
    // print_r($total_result);exit();
    $total_records = $total_result['sum(total_chapters)'];
    // Number records / page
    $nop = 5;

    $total_page = ceil($total_records / $nop);
    $offset = $nop * ($p - 1);


    // sql select and search
    $sql = "select 
    chapter.*,
    novel.title as n_name
    from chapter 
    join novel on chapter.novel_id = novel.id
    where (novel.title like '%$search%'
    or chapter_content like '%$search%')
    $cond
    order by novel.id, chap
    limit $nop offset $offset";
    // die($sql);
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/zz.php'); ?>
    <?php zz('Tìm chương') ?>
    <script defer src = "../../js/main.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
    <?php require ('../root/menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <!-- SEARCH -->
        <form class="form form__process" method="GET">
            <h1 class= "form__title">Tìm chương</h1>
            <div class="form__search">
                <input name="search" type="search" value="<?php echo $search ?>" placeholder="Nhập tên truyện có chương cần sửa"/>
                <button>Tìm tên truyện</button>
            </div>
            <table >
                <tr>
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
                <?php foreach ($result as $item) {?>
                    <tr>
                        <td><?php echo $item['n_name'];?></td>
                        <td><?php echo $item['chap'];?></td>
                        <td><p><?php echo nl2br($item['chapter_content'])?></p></td>
                        <?php if($role == 1) { ?>
                            <td>
                                <?php if($item['verify'] == 0) { ?>
                                    <a class="verify" href="view.php?chap_id=<?php echo $item['chap_id']?>"><i class="fas fa-check-square"></i></a>
                                <?php } else {?>
                                    Đã duyệt
                                <?php } ?>
                            </td>
                            <td><a href="delete.php?chap_id=<?php echo $item['chap_id'];?>"><i class="fas fa-trash-alt"></i></a></td>
                        <?php } else {?>
                            <td>
                                <?php echo $item['verify'] == 0 ? 'Chưa duyệt ❌' : 'Đã duyệt ✅' ?>
                            </td>
                            <td><a href="update.php?chap_id=<?php echo $item['chap_id'];?>"><i class="fas fa-edit"></i></a></td>
                            <td><a href="delete.php?chap_id=<?php echo $item['chap_id'];?>"><i class="fas fa-trash-alt"></i></a></td>
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