<?php
    session_start();
    require_once("../../cdb.php");

    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../../' </script>";
        exit;
    }

    $location = "window.location = 'index.php'";
    if(empty($_POST['id']) ) {
        echo '<script>alert("❌Yêu cầu không hợp lệ!")</script>';
        echo"<script>$location</script>";
    }

    $id = $_POST['id'];
    $category_name = $_POST['category_name'];

    $sql = "update categories set
    category_name = '$category_name'
    where
    id = $id";

    // die($sql);

    mysqli_query($conn, $sql);
    echo '<script>alert("✅Bạn đã sửa thể loại thành công!")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>