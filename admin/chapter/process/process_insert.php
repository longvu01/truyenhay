<?php
    session_start();
    require_once("../../../connect.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../../root/check_permission.php");
    // Back to home page when data is empty
    if(empty($_POST['novel_id']) || empty($_POST['chapter_content'])) {
        $_SESSION['info_title'] = "Có lỗi!";
        $_SESSION['info_message'] = "❌Cần điền đầy đủ thông tin!";
        $_SESSION['info_type'] = "error";

        header('Location: ../');
        exit;
    }

    $novel_id = addslashes($_POST['novel_id']);
    $chapter_content = addslashes($_POST['chapter_content']);

    $sql = "SELECT * FROM chapter where novel_id = $novel_id ORDER BY chap DESC LIMIT 1";
    // die($sql);

    $chapter = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($chapter);
    $chap = $result['chap'];

    $chap = $chap >= 1 ? ++$chap : 1;
    $sql = "insert into chapter (novel_id, chap, chapter_content) values ('$novel_id', $chap, '$chapter_content')";
    // die($sql);
    mysqli_query($conn, $sql);

    // Update total_chapters
    $sql = "update novel 
    set total_chapters = total_chapters + 1
    where id = $novel_id";
    // die($sql);
    mysqli_query($conn, $sql);

    // Thông báo và quay lại trang tìm kiếm
    $_SESSION['info_title'] = "Thành công!";
    $_SESSION['info_message'] = "Bạn đã thêm chương mới thành công!";
    $_SESSION['info_type'] = "success";

    header('Location: ../');

    mysqli_close($conn);
?>