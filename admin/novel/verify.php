<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../' </script>";
        die();
    }
    // Kiểm tra mã hợp lệ
    $location = "window.location = 'search.php'";
    if(empty($_POST['id']) ) {
        echo '<script>alert("❌Cần có mã để duyệt!")</script>';
        echo"<script>$location</script>";
        die();
    }
    // ----------------------------------------------------------------
    $id = addslashes($_POST['id']);
    $sql = "update novel set verify = 1 where id = $id";

    mysqli_query($conn, $sql);

    echo "<script>alert('✅Bạn đã duyệt truyện này!')</script>";

    require_once '../mail.php';
    $email = "lelongvu17@gmail.com";
    $name = "Longg Vũ";
    $title = "Truyện của bạn đã được duyệt";
    $content = "Truyện của bạn đã được duyệt, hãy <a href='localhost/truyenhay/admin/chapter/index.php'>quay lại</a> và thêm chương mới nhé";
    sendMail($email, $name, $title, $content);

    echo "<script>$location</script>";
    mysqli_close($conn);
?>