<?php
    session_start();
    require_once("../../cdb.php");

    if(empty($_SESSION['id']) ) {
        echo"<script>window.location = '../../'</script>";
    }

    // Get id and back to last record from table when data is empty
    if(empty($_POST['chap_id']) ) {
        echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
        echo"<script>window.location = 'search.php'</script>";
    }
    // die();
    $chap_id = addslashes($_POST['chap_id']);
    $chapter_content = addslashes($_POST['chapter_content']);
    $novel_title = addslashes($_POST['novel_title']);

    $sql = "update chapter set
    chapter_content = '$chapter_content'
    where
    chap_id = $chap_id";

    // die($sql);

    mysqli_query($conn, $sql);
    $location = "window.location = 'search.php?search=$novel_title'";
    echo '<script>alert("✅Bạn đã sửa thông tin chương thành công!")</script>';
    echo "<script>$location</script>";
    mysqli_close($conn);
?>