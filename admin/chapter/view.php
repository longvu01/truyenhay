<?php
require_once("../../cdb.php");

// $id = $_GET['id'];
// $chap_id = isset($_REQUEST["chap_id"]) ? $_REQUEST["chap_id"] : 1;
// if ($chap_id < 1) {
//     echo '<script>alert("Truyện chưa có chương nào!")</script>';
//     echo"<script>window.location = 'search.php'</script>";
//     return ;
// }

$location = "window.location = 'search_chapter.php'";
// if(empty($_GET['chap_id']) || ($chap_id < 1)) {
//     echo '<script>alert("❌Phải truyền mã hợp lệ để chỉnh sửa!")</script>';
//     echo"<script>$location</script>";
// }

$sql = "select * from chapter where chap_id = '$chap_id'";
// die($sql);
$sql_result = mysqli_query($conn, $sql);
$number_rows = mysqli_num_rows($sql_result);
if($number_rows != 1) {
    echo '<script>alert("❌Không tìm thấy chương theo mã này!")</script>';
    echo"<script>$location</script>";
}

$result = mysqli_fetch_array($sql_result);

$sql = "SELECT title FROM novel 
join chapter
on novel.id = chapter.novel_id
where chap_id = '$chap_id'";
$result_novel = mysqli_query($conn, $sql);
$novel = mysqli_fetch_array($result_novel);
$novel_title = $novel['title'];

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem nội dung</title>
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
    <!-- Form -->
    <div class="wrapper">
        <form class="form form__process" method="POST" action="verify.php">
            <h1 class= "form__title form__title--large">Truyện: <?php echo $novel_title?></h1>
            <h2 class= "form__title">Xem chương <?php echo $result["chap"]?></h1>
            <input type="hidden" name="chap_id" value="<?php echo $chap_id?>"/>
            <input type="hidden" name="novel_title" value="<?php echo $novel_title?>"/>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="chapter_content" id="" cols="30" rows="50" disabled><?php echo $result["chapter_content"]?></textarea>
            </div>

            <button type="submit" name="submit">Duyệt nội dung chương</button>
        </form>
    </div>

    <footer class="footer">
        <p class="footer__text">K1 - J2 School</p>
        <img src="../../img/j2team.png" alt="">
    </footer>

    <script src="../../js/main.js"></script>
</body>
</html>