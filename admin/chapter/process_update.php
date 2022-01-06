<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 0;
    if($role != 0) {
        echo '<script>alert("❌Bạn không được sửa chương của người dùng!")</script>';
        echo"<script>window.location = 'index.php' </script>";
        die();
    }
    
    if(empty($_POST['chap_id']) || empty($_POST['chapter_content'])) {
        echo "<script>alert('❌Cần điền đầy đủ thông tin!')</script>";
        echo "<script>window.location = 'search.php'</script>";
    }
    // ----------------------------------------------------------------
    $chap_id = addslashes($_POST['chap_id']);
    $chapter_content = addslashes($_POST['chapter_content']);
    $novel_title = addslashes($_POST['novel_title']);

    $sql = "update chapter set
    chapter_content = '$chapter_content'
    where
    chap_id = $chap_id";

    mysqli_query($conn, $sql);

    $location = "window.location = 'search.php?search=$novel_title'";
    echo '<script>alert("✅Bạn đã sửa thông tin chương thành công!")</script>';
    echo "<script>$location</script>";
    mysqli_close($conn);
?>