<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo "<script>window.location = '../' </script>";
        die();
    }

    $location = "window.location = 'index.php'";

    if(empty($_GET['id']) ) {
        echo "<script>alert('❌Yêu cầu không hợp lệ!')</script>";
        echo "<script>$location</script>";
        die();
    }
    // ----------------------------------------------------------------
    $id = addslashes($_GET['id']);

    $sql = "select count(*) from novel where category_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];

    if($number_rows > 0) {
        echo "<script>alert('Cần xóa hết truyện có thể loại này trước!')</script>";
        echo "<script>$location</script>";
        die();
    }

    $sql = "delete from categories where id = '$id'";
    // die($sql);
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng quay lại
    echo "<script>alert('Bạn đã xoá thể loại thành công!')</script>";
    echo "<script>$location</script>";
    mysqli_close($conn);
?>