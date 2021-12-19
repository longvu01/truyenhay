<?php
    require("../cdb.php");

    $p = isset($_REQUEST["p"]) ? $_REQUEST["p"] * 1 : 0;
	if ($p < 1) $p = 1;
    // if(isset($_GET['page'])){
    //     $p = $_GET['page'];
    // }
    $search = "";
    if(isset($_GET['search'])){
        $search = $_GET['search'];
    }

	$sql_total_records = "select count(*) from grab_content where title like '%$search%'";
    $arr_total = mysqli_query($conn, $sql_total_records);
    $total_result = mysqli_fetch_array($arr_total);
    $total_records = $total_result['count(*)'];

    // Number records / page
    $nop = 2;

    $total_page = ceil($total_records / $nop);
    $offset = $nop * ($p - 1);

    $sql = "select * from grab_content where title like '%$search%' 
    limit $nop offset $offset";
    
    $result = mysqli_query($conn, $sql);


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reset1.css">
    <link rel="stylesheet" href="../css/base1.css">
    <link rel="stylesheet" href="../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <?php require_once ('header_admin.php'); ?>
    <?php require ('menu.php'); ?>
    <!-- Form -->
    <div class="wrapper">
        <!-- SEARCH -->
        <form class="form form__process" method="GET">
            <h1 class= "form__title">Tìm kiếm sản phẩm</h1>
            <div class="form__search">
                <input name="search" type="search" value="<?php echo $search ?>" />
                <button>Tìm kiếm</button>
            </div>
            <table >
                <tr>
                    <th>Id</th><!--  -->
                    <th>Ảnh sản phẩm</th>
                    <th>Tiêu đề</th>
                    <th>Giá bán</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Mô tả</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
                <?php foreach ($result as $item) {?>
                    <tr>
                        <td><?php echo $item['id'];?></td>
                        <td>
                            <img src="<?php echo $item['img_link']?>">
                        </td>
                        <td><?php echo $item['title'];?></td>
                        <td><?php echo '$'.$item['current_price']?></td>
                        <td><?php echo $item['size'];?></td>
                        <td><?php echo $item['colors'];?></td>
                        <td><?php echo $item['description'];?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $item['id'];?>"><i class="fas fa-edit"></i></a>
                        </td>
                        <td>
                            <a href="delete.php?id=<?php echo $item['id'];?>"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <br/>
            <br/>
        </form>
        <div class="pagination">
            <?php for($i = 1; $i <= $total_page; $i++) { ?>
                <a href="?p=<?php echo $i ?>&search=<?php echo $search ?>">
                    <?php echo $i ?>
                </a>
            <?php } ?>
        </div>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../img/j2team.png" alt="">
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>