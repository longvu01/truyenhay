<?php
  session_start();
  require_once("../../../connect.php");
  require_once("../../root/check_permission.php");

  if(isset($_POST['category_name'])) {

    $category_name = addslashes($_POST['category_name']);
    $sql = "select count(*) from categories where category_name = '$category_name'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];
    // Nếu đã tồn tại tên thể loại thì thông báo
    if($number_rows == 1) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "Thể loại bạn thêm đã tồn tại!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
    } else {
        $sql = "insert into categories (category_name) values ('$category_name')";
        mysqli_query($conn, $sql);

        $_SESSION['info_title'] = "Thành công!";
        $_SESSION['info_message'] = "Bạn đã thêm thể loại thành công!";
        $_SESSION['info_type'] = "success";

        header('Location: ../');
        exit;
    }
  } 

  header('Location: ../');

  mysqli_close($conn);
?>