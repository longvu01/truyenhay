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
      })</script>";
  ?>
<?php }?>  