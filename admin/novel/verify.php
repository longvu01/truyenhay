<?php
    session_start();
    require_once("../../cdb.php");

    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../' </script>";
        exit;
    }
    // Get id and back to last record from table when data is empty
    $location = "window.location = 'search.php'";
    if(empty($_POST['id']) ) {
        $sql = 'SELECT * FROM novel ORDER BY id DESC LIMIT 1';
        $resultLast = mysqli_query($conn, $sql);
        $item = mysqli_fetch_array($resultLast);
        $id = $item['id'];
        echo '<script>alert("❌Cần điền đầy đủ thông tin!")</script>';
        echo"<script>$location</script>";
    }

    $id = addslashes($_POST['id']);
    $sql = "update novel set verify = 1 where id = $id";

    // die($sql);

    mysqli_query($conn, $sql);
    echo '<script>alert("✅Bạn đã duyệt truyện này!")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>