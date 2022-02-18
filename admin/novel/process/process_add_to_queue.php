<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");

    // $_SESSION['id'] = 1;
    $user_id = $_SESSION['id'];

    if(empty($_POST['category_id']) || empty($_POST['title']) || empty($_POST['status'])
    || empty($_POST['author']) || empty($_POST['pre_view'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần điền đầy đủ thông tin!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
    }
    // Xử lý upload ảnh
    $img_link_new = $_FILES['img_link_new'];
    if($img_link_new['size'] > 0) {
        $folder = '../../photos/' ;
        $file_extension = explode('.', $img_link_new['name'])[1];
        $file_name = time() . '.' . $file_extension;
        $file_path = $folder . $file_name;
        move_uploaded_file($img_link_new["tmp_name"], $file_path);
    } else {
        $file_name = $_POST['img_link_old'];
    }
    
    $novel_id = addslashes($_POST['novel_id']);
    $category_id = addslashes($_POST['category_id']);
    $status = addslashes($_POST['status']);
    $total_chapters = addslashes($_POST['total_chapters']);
    $author = addslashes($_POST['author']);
    $pre_view = addslashes($_POST['pre_view']);

    // Kiểm tra đã có trong hàng đợi chưa
    $sql = "select novel_id, user_id from verify_queue_novel where novel_id = '$novel_id' and user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    foreach ($result as $each) {
      if($each['novel_id'] == $novel_id && $each['user_id'] == $user_id) {
        $_SESSION['info_title'] = "Thông báo!";
        $_SESSION['info_message'] = "Truyện của bạn đã nằm trong hàng chờ duyệt! Hãy liên hệ với quản trị viên để được duyệt sớm nhất!";
        $_SESSION['info_type'] = "info";
  
        header('Location: ../search.php');
        exit;
      }
    }

    // Địa chỉ điều hướng quay lại khi trùng tên truyện hoặc sửa thông tin thành công
    $title = addslashes($_POST['title']);
    $old_title = addslashes($_POST['old_title']);
    if(!$title === $old_title) {
      $sql = "select count(*) from novel where title = '$title' and id != '$novel_id'";
      $result = mysqli_query($conn, $sql);
      $number_rows = mysqli_fetch_array($result)['count(*)'];
      // Nếu đã tồn tại tên truyện thì thông báo và điều hướng quay lại
      if($number_rows == 1) {
          $_SESSION['info_title'] = "Thông báo!";
          $_SESSION['info_message'] = "Tên truyện này đã có người đặt!";
          $_SESSION['info_type'] = "info";
  
          header('Location: ../update.php?id=' . $novel_id);
          exit;
      }
    }

    $sql = "insert into verify_queue_novel 
    (user_id, category_id, title, author, img_link, status, pre_view, novel_id, total_chapters, verify)
    values 
    ('$user_id', '$category_id', '$title', '$author', '$file_name','$status', '$pre_view', '$novel_id', '$total_chapters', 0)";
    // die($sql);

    mysqli_query($conn, $sql);

    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã sửa thông tin truyện thành công! Hãy liên hệ với quản trị viên để được duyệt sớm nhất";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php');

    mysqli_close($conn);
?>