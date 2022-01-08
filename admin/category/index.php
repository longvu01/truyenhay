<?php
    session_start();
    require_once("../../cdb.php");
    require_once("../root/check_permission.php");

    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../' </script>";
        die();
    }

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tùy chỉnh thể loại</title>
    <link rel="stylesheet" href="../../css/reset1.css">
    <link rel="stylesheet" href="../../css/base1.css">
    <link rel="stylesheet" href="../../css/style1.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,700;0,800;0,900;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src = "../../js/main.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header_admin.php'); ?>
    <?php require_once ('../root/menu.php'); ?>

    <div class="wrapper">
    <!-- Form -->
        <form class="form form__process active" method="POST" id="form-add" action="process_insert.php">
            <h1 class= "form__title">Tùy chỉnh thể loại</h1>
            <div class="form-group">
                <label>Thể loại mới</label>
                <input id = "category_name" name="category_name" type="text" placeholder="Nhập tên thể loại" class="form-control" rules="required"/>
                <span class="form-message"></span>
            </div>

            <button class="btn" type="submit">Thêm thể loại</button>
        </form>
        <!-- Search -->
        <div class="form form__process">
            <h1 class= "form__title">Thể loại hiện có</h1>
            <table >
                <tr>
                    <th>Tên thể loại</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
                <?php foreach ($cates as $cate) {?>
                    <tr>
                        <form class="form form__process form-update" method="POST" action="process_update.php">
                            <td>
                                <input type="hidden" name="id" value="<?php echo $cate["id"]?>"/>
                                <div class="form-group">
                                    <input class = "category__name-input form-control" name="category_name" value="<?php echo $cate["category_name"]?>"/>
                                    <span class="form-message"></span>
                                </div>
                            </td>

                            <td>
                                <button type="submit"><i class="fas fa-edit"></i></button>
                            </td>

                            <td>
                                <a href="process_delete.php?id=<?php echo $cate['id']?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>

    <script src = "../../js/toast_msg.js"></script>
    <?php if(isset($_SESSION['info_title']) && isset($_SESSION['info_message']) && isset($_SESSION['info_type'])) { ?>
        <?php 
            $info_title = $_SESSION['info_title'];
            $info_message = $_SESSION['info_message'];
            $info_type = $_SESSION['info_type'];
            unset($_SESSION['info_title']);
            unset($_SESSION['info_message']);
            unset($_SESSION['info_type']);
            echo "<script>showToast({
                title: '$info_title',
                message: '$info_message',
                type: '$info_type',
                duration: 5000,
            })</script>";
        ?>
    <?php }?>  

    <script src = "../../js/validator.js"></script>
    <script>
        const formAdd = new Validator('#form-add')

        // Cái form update render từ PHP nó lsao ý nên là em show error thôi chứ chưa validate = js đc 🙄
        const updateInput = document.querySelectorAll('.category__name-input')
        if(updateInput) {
            for(let input of updateInput) {
                const formGroup = input.closest('.form-group')
                const errorElement = formGroup.querySelector('.form-message')
                function showError() {
                    errorElement.textContent = 'Vui lòng nhập trường này'
                    formGroup.classList.add('invalid')
                    showToast({
                        title: 'Thiếu thông tin!',
                        message: 'Bạn cần nhập đủ các trường',
                        type: 'warning',
                        duration: 5000,
                    });
                }
                function clearError() {
                    errorElement.textContent = ''
                    formGroup.classList.remove('invalid')
                }
                function handleValidate() {
                    if(!input.value.trim()) showError()
                    else clearError()
                }
                input.oninput = handleValidate
            }
        }
    </script>

</body>
</html>