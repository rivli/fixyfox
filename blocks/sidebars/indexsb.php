<div class="sidebar">
    <?php
      if ($_SESSION['status'] != 'login') {
        echo '<div class="sb_block">';
        include 'module/users/login.php';
        echo '</div>';
      } else {
     ?>

    <div class="sb_block_name">
     FIXYFOX
    </div>
    <div class="sb_block">
      Добро пожаловать
    </div><br>
</div>
    <?php   REKLAMMA(); } ?>
</body>
</html>
