<?php
    session_start();
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // $role = $_SESSION['role'];
    $role = 1;
    // Session user id
    // $ss_user_id = $_SESSION['id'];
    $ss_user_id = 2;

    if(empty($_POST['chap_id']) ) {
        echo"<script>window.location = 'index.php'</script>";
    }
    $chap_id = addslashes($_POST['chap_id']);
    // Nếu đúng là tác giả/ admin thì được phép xóa
    $sql = "SELECT user.id FROM chapter
    join novel 
    on chapter.novel_id = novel.id
    join user
    ON novel.user_id = user.id
    where chapter.chap_id = '$chap_id'";

    $sql_result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($sql_result);
    $user_id = $row['id'];
    
    if(isset($ss_user_id)) {
        if($user_id != $ss_user_id && $role != 1) {
            echo"<script>window.location = 'index.php'</script>";
        }
    } else {
        echo"<script>window.location = 'index.php'</script>";
    }

    if ($chap_id < 1) {
        echo '<script>alert("Truyện chưa có chương nào!")</script>';
        echo"<script>window.location = 'search_chapter.php'</script>";
        die();
    }
    // ----------------------------------------------------------------
    $novel_title = addslashes($_POST['novel_title']);

    // Cập nhật lại tổng số chap trong bảng novel tương ứng với chap_id
    $sql = "update novel 
    set total_chapters = total_chapters - 1
    where id = (select novel_id from chapter where chap_id = '$chap_id')";
    // die($sql);
    mysqli_query($conn, $sql);

    // Xóa chương tương ứng với chap_id
    $sql = "delete from chapter where chap_id = '$chap_id'";
    // die($sql);
    mysqli_query($conn, $sql);

    $location = "window.location = 'search.php?search=$novel_title'";
    echo '<script>alert("Bạn đã xoá chương thành công!")</script>';
    echo"<script>$location</script>";
    mysqli_close($conn);
?>