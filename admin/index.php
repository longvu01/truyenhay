<?php
    require_once("../cdb.php");

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm truyện</title>
    <link rel="stylesheet" href="../css/reset1.css">
    <link rel="stylesheet" href="../css/base1.css">
    <link rel="stylesheet" href="../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <script>
        alert("Em chưa làm phần validate đâu nên thầy test thì nhập đủ data với đừng chửi em 🙄")
    </script>
    <?php require_once ('root/header_admin.php'); ?>
    <?php require_once ('root/menu.php'); ?>
    
    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process active" method="POST" enctype="multipart/form-data" action="process_insert.php">
            <h1 class= "form__title">Thêm truyện</h1>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Thể loại</label>
                    <select name="category_id">
                        <option value="" hidden>Chọn thể loại</option>
                        <?php foreach ($cates as $cate) {?>
                            <option value="<?php echo $cate["id"]?>">
                                <?php echo $cate["category_name"]?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- User id qua session -->
            <input name="user_id" type = "hidden" value = "1"/>
            <!--  -->
            <div class="form-group">
                <label>Tác giả</label>
                <input name="author" />
            </div>

            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title"/>
            </div>

            <div class="form-group">
                <label>Ảnh</label>
                <input name="img_link" type = "file"/>
            </div>

            <div class="form-group">
                <label>Xem trước/ mô tả</label>
                <textarea name="pre_view" id="" cols="30" rows="10"></textarea>
            </div>

            <button class="btn" type="submit" name="submit">Thêm truyện</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../img/j2team.png" alt="">
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>