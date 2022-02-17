<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    require_once("../../root/check_permission_admin.php");
    // Kiểm tra mã hợp lệ
    if(empty($_POST['novel_id']) ) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần có mã để duyệt!";
        $_SESSION['info_type'] = "error";

        header('Location: ../search.php');
        exit;
    }
    // Kiểm tra toàn vẹn dl user
    if(empty($_POST['category_id']) || empty($_POST['title']) || empty($_POST['status'])
    || empty($_POST['author']) || empty($_POST['pre_view'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Bạn cần giữ nguyên dữ liệu người dùng!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
    }
    // ----------------------------------------------------------------
    $novel_id = addslashes($_POST['novel_id']);
    $category_id = addslashes($_POST['category_id']);
    $title = addslashes($_POST['title']);
    $img_link_new = addslashes($_POST['img_link_new']);
    $status = addslashes($_POST['status']);
    $author = addslashes($_POST['author']);
    $pre_view = addslashes($_POST['pre_view']);

    $sql = "update novel set
    category_id = '$category_id',
    title = '$title',
    status = '$status',
    author = '$author',
    img_link = '$img_link_new',
    pre_view = '$pre_view',
    verify = 1
    where
    id = $novel_id";
    // die($sql);
    mysqli_query($conn, $sql);

    // Xóa trong hàng chờ
    $sql = "delete from verify_queue_novel where novel_id = '$novel_id'";
    mysqli_query($conn, $sql);

    // require_once '../mail.php';
    // // $email = $_SESSION['email'];
    // $email = "lelongvu17@gmail.com";
    // // $name = $_SESSION['name'];
    // $name = "Longg Vũ";
    // $title = "Truyện của bạn đã được duyệt";
    // $content = "Truyện của bạn đã được duyệt, hãy <a href='localhost/truyenhay/admin/chapter/index.php'>quay lại</a> và thêm chương mới nhé";
    // sendMail($email, $name, $title, $content);

    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "✅Bạn đã duyệt truyện này";
    $_SESSION['info_type'] = "success";

    header('Location: ../search.php');
    
    mysqli_close($conn);
?>