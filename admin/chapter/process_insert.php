<?php
    require_once("../../cdb.php");
    // Kiểm tra quyền, dữ liệu
    require_once("../root/check_permission.php");
    // Back to home page when data is empty
    if(empty($_POST['novel_id']) || empty($_POST['chapter_content'])) {
        echo "<script>alert('❌Cần điền đầy đủ thông tin!')</script>";
        echo "<script>window.location = 'index.php'</script>";
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
    echo "<script>alert('Bạn đã thêm chương mới thành công!')</script>";
    echo "<script>window.location = 'search.php'</script>";
    mysqli_close($conn);
?>