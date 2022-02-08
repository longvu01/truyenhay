<div class="pagination">
    <?php for($i = 1; $i <= $total_page; ++$i) { ?>
        <a href="?p=<?php echo $i ?><?php if($search) echo '&search=' . $search ?>">
            <?php if($i === $p) { ?>
                <span><?= $i ?></span>
            <?php } else {?>
                <?= $i ?>
            <?php }?>
        </a>
    <?php } ?>
</div>