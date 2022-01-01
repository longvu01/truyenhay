<?php
    session_start();
    require_once("../../cdb.php");

    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../../' </script>";
        exit;
    }

    $location = "window.location = 'index.php'";

    $id = $_GET['id'];

    $sql = "select count(*) from novel where category_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];

    if($number_rows > 0) {
        echo '<script>alert("Cần xóa hết truyện có thể loại này trước!")</script>';
        echo"<script>$location</script>";
        exit;
    }

    $sql = "delete from categories where id = '$id'";
    // die($sql);
    mysqli_query($conn, $sql);

    // Get id and back to last record from table

    echo '<script>alert("Bạn đã xoá thể loại thành công!")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>