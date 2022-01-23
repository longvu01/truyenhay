<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;

    $p = isset($_REQUEST["p"]) ? addslashes($_REQUEST["p"]) * 1 : 0;
	if ($p < 1) $p = 1;
    
    $search = "";
    if(isset($_GET['search'])){
        $search = addslashes($_GET['search']);
    }

	$sql_total_records = "select count(*) from novel where title like '%$search%'";
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
    where novel.title like '%$search%' 
    or category_name like '%$search%'
    or author like '%$search%'
    or pre_view like '%$search%' 
    order by novel.id
    limit $nop offset $offset";
    // die($sql);
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm truyện</title>
    <link rel="stylesheet" href="../../css/reset1.css">
    <link rel="stylesheet" href="../../css/base1.css">
    <link rel="stylesheet" href="../../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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