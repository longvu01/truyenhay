<?php
    require_once("../cdb.php");

    $sql = "select * from grab_categories";
    $cates = mysqli_query($conn, $sql);

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
    <?php require_once ('menu.php'); ?>
    
    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process active" method="POST" enctype="multipart/form-data" action="process_insert.php">
            <h1 class= "form__title">Thêm sản phẩm</h1>
            <div class = "form__process--top">
                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select name="cid" required>
                        <option hidden>Chọn chuyên mục</option>
                        <?php foreach ($cates as $item) {?>
                            <option value="<?php echo $item["id"]?>"><?php echo $item["title"]?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Đường dẫn ảnh sản phẩm</label>
                <input name="img_link" value=""/>
            </div>
    
            <div class="form-group">
                <label>Tiêu đề</label>
                <input name="title" value=""/>
            </div>
    
            <div class="form-group">
                <label>Giá ban đầu</label>
                <input name="original_price" value=""/>
            </div>

            <div class="form-group">
                <label>Giá hiện tại</label>
                <input name="current_price" value=""/>
            </div>

            <div class="form-group">
                <label>Size</label>
                <input name="size" value=""/>
            </div>

            <div class="form-group">
                <label>Màu sắc</label>
                <input name="colors" value=""/>
            </div>

            <div class="form-group">
                <label>Giới tính</label>
                <select name="gender" required>
                    <option hidden>Lựa chọn</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="both">Both</option>
                </select>
            </div>
    
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" rows="5"></textarea>
            </div>

            <button class="btn" type="submit" name="submit">Thêm sản phẩm</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../img/j2team.png" alt="">
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>