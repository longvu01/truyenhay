<?php
    session_start();
    require_once("../cdb.php");
    $role = 1
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị</title>
    <link rel="stylesheet" href="../css/reset1.css">
    <link rel="stylesheet" href="../css/base1.css">
    <link rel="stylesheet" href="../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="admin__page">
        <h1>Chọn chức năng</h1>
        <ul>
            <?php if ($role == 1) { ?>
                <li>
                    <a href="category">Thể loại</a>
                </li>
            <?php } ?>
            <li>
                <a href="novel">Viết Truyện</a>
            </li>

            <li>
                <a href="chapter">Thêm chương</a>
            </li>
        </ul>
    </div>
</body>
</html>