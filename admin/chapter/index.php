<?php
    require_once("../../cdb.php");

    $user_id = 1;

    $sql = "select * from novel where user_id = '$user_id'";
    $novels = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm chương</title>
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
        <form class="form form__process active" method="POST" enctype="multipart/form-data" action="process_insert.php">
            <h1 class= "form__title">Thêm chương</h1>

            <div class = "form__process--top">
                <div class="form-group">
                    <label>Chọn truyện của bạn</label>
                    <select name="novel_id">
                        <option value="" hidden>Chọn truyện</option>
                            <?php foreach ($novels as $novel) {?>
                                <option value="<?php echo $novel["id"]?>">
                                    <?php echo $novel["title"]?>
                                </option>
                            <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Nội dung chương</label>
                <textarea name="chapter_content" id="" cols="30" rows="50"></textarea>
            </div>

            <button class="btn" type="submit" name="submit">Thêm chương mới</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src="../../js/main.js"></script>
</body>
</html>