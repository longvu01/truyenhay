<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");
    // Back to home page when data is empty
    if(empty($_POST['category_id']) || empty($_POST['title']) || empty($_POST['author'])
    || empty($_FILES['img_link']) || empty($_POST['pre_view'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần điền đầy đủ thông tin!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
    }
    // ----------------------------------------------------------------
    $user_id = addslashes($_POST['user_id']);
    $category_id = addslashes($_POST['category_id']);
    $author = addslashes($_POST['author']);
    $img_link = $_FILES['img_link'];
    $pre_view = addslashes($_POST['pre_view']);

    $folder = '../../photos/' ;
    $file_extension = explode('.', $img_link['name'])[1];
    $file_name = time() . '.' . $file_extension;
    $file_path = $folder . $file_name;
    move_uploaded_file($img_link["tmp_name"], $file_path);

    // Kiểm tra tên truyện đã tồn tại trong DB chưa
    $title = addslashes($_POST['title']);
    $sql = "select count(*) from novel where title = '$title'";
    $result = mysqli_query($conn, $sql);
    $number_rows = mysqli_fetch_array($result)['count(*)'];
    // Nếu đã tồn tại tên truyện thì thông báo và điều hướng quay lại
    if($number_rows == 1) {
        $_SESSION['info_title'] = "Thông báo!";
        $_SESSION['info_message'] = "Tên truyện này có người đặt gòi !";
        $_SESSION['info_type'] = "info";

        header('Location: ../');
        exit;
    }

    $sql = "insert into novel 
    (user_id, category_id, title, author, img_link, pre_view)
    values 
    ('$user_id', '$category_id', '$title', '$author', '$file_name', '$pre_view')";

    // die($sql);
    mysqli_query($conn, $sql);

    // Thông báo và điều hướng đến trang thêm chương mới
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã thêm truyện thành công!";
    $_SESSION['info_type'] = "success";

    header('Location: ../../chapter/index.php');

    mysqli_close($conn);
?>