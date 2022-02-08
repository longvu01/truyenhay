<?php
    session_start();
    require_once("../../cdb.php");
    require_once("../root/check_permission.php");

    // $role = $_SESSION['role'];
    $role = 1;
    if($role != 1) {
        echo"<script>window.location = '../' </script>";
        exit;
    }

    $sql = "select * from categories";
    $cates = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>

<!-- Start HTML -->
    <?php require_once ('../root/lazy.php'); ?>
    <?php lazy('Tùy chỉnh thể loại') ?>
    <script defer src = "../../js/main.js"></script>
</head>
<body>
    <div id="toast"></div>
    
    <?php require_once ('../root/header.php'); ?>
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

    <?php require_once ('../root/footer.php'); ?>
    
    <script src = "../../js/toast_msg.js"></script>
    <?php require_once ('../root/show_toast.php'); ?>

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