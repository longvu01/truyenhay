<?php
include("../../cdb.php");
// Get id and back to last record from table
$sql = 'SELECT * FROM novel ORDER BY id DESC LIMIT 1';
$resultLast = mysqli_query($conn, $sql);
$item = mysqli_fetch_array($resultLast);
mysqli_close($conn);
?>
<div class="menu">
        <div class="menu__header">
            <a href="../../"><img src="../../img/convert.png" alt=""></a>
            <span class="menu__bar" id="menu__bar">
                <i class="fas fa-align-left"></i>
            </span>
        </div>

        <div class="menu__content">
            <div class="menu__left">
                <div class ="menu__left--top">
                    <a href="#"><i class="fas fa-address-book"></i></a>
                    <a href="#"><i class="fab fa-accusoft"></i></a>
                    <a href="#"><i class="fab fa-artstation"></i></a>
                    <a href="#"><i class="fas fa-money-check-alt"></i></a>
                    <a href="#"><i class="fas fa-cog"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                    <a href="#"><i class="fas fa-laptop"></i></a>
                    <a href="#"><i class="fas fa-users"></i></a>
                </div>
                <div>
                    <a href="#"><i class="fas fa-sign-out-alt"></i></a>
                    <a href="#"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <div class="menu__right">
                <p>Thể loại</p>
                <a href= "../category/index.php" class="menu__right--item">Tùy chỉnh thể loại<i class="fas fa-plus"></i></a>
                <p>Truyện</p>
                <a href= "../novel/index.php" class="menu__right--item">Thêm truyện<i class="fas fa-plus"></i></a>
                <a href= "../novel/search.php" class="menu__right--item">Tìm kiếm truyện<i class="fas fa-search"></i></a>
                <a href= "../novel/update.php?id=<?php echo $item['id'];?>" class="menu__right--item">Sửa truyện<i class="fas fa-edit"></i></a>
                <a href= "../novel/delete.php?id=<?php echo $item['id'];?>" class="menu__right--item">Xóa truyện<i class="fas fa-trash"></i></a>
                <p>Chương truyện</p>
                <a href= "../chapter/index.php" class="menu__right--item">Thêm chương<i class="fas fa-plus"></i></a>
                <a href= "../chapter/search.php" class="menu__right--item">Tìm chương<i class="fas fa-plus"></i></a>
            </div>
        </div>
        
        <div class="menu__bottom">
            <div class="admin__info">
                <a href="#" class="admin_name">Administrator</a>
                <div class="admin__options"><i class="fas fa-ellipsis-v"></i></div>
            </div>
        </div>
    </div>