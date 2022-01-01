<?php
    session_start();
    require_once("../../cdb.php");

    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../../' </script>";
        exit;
    }

    if(isset($_POST['category_name'])) {
        $location = "window.location = 'index.php'";

        $category_name = addslashes($_POST['category_name']);
        $sql = "select count(*) from categories where category_name = '$category_name'";
        $result = mysqli_query($conn, $sql);
        $number_rows = mysqli_fetch_array($result)['count(*)'];
        // Nếu đã tồn tại tên thể loại thì thông báo và điều hướng quay lại
        if($number_rows == 1) {
            echo '<script>alert("Thể loại bạn thêm đã tồn tại!")</script>';
            echo"<script>$location</script>";
            die();
        }
        
        $sql = "insert into categories (category_name) values ('$category_name')";
        // die($sql);
        mysqli_query($conn, $sql);
        echo '<script>alert("Bạn đã thêm thể loại thành công!")</script>';
        echo"<script>$location</script>";
    }

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tùy chỉnh thể loại</title>
    <link rel="stylesheet" href="../../css/reset1.css">
    <link rel="stylesheet" href="../../css/base1.css">
    <link rel="stylesheet" href="../../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php require_once ('../root/header_admin.php'); ?>
    <?php require_once ('../root/menu.php'); ?>
    
    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process active" method="POST">
            <h1 class= "form__title">Tùy chỉnh thể loại</h1>
            <div class="form-group">
                <label>Thể loại mới</label>
                <input name="category_name" />
            </div>

            <button class="btn" type="submit" name="submit">Thêm thể loại</button>
        </form>
        <!-- Search -->
        <div class="form form__process">
            <h1 class= "form__title">Thể loại hiện có</h1>
            <table >
                <tr>
                    <th>Tên thể loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
                <?php foreach ($cates as $cate) {?>
                    <tr>
                        <form class="form form__process" method="POST" action="process_update.php">
                            <td>
                                <input type="hidden" name="id" value="<?php echo $cate["id"]?>"/>
                                <input class = "category__name-input" name="category_name" value="<?php echo $cate["category_name"]?>"/>
                            </td>

                            <td>
                                <button><i class="fas fa-edit"></i></button>
                            </td>

                            <td>
                                <a href="process_delete.php?id=<?php echo $cate['id'];?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
        
    </div>

    <script src="../../js/main.js"></script>
</body>
</html>