<div class="sidebar">
    <?php
      if ($_SESSION['status'] != 'login') {
        echo '<div class="sb_block">';
        include 'module/users/login.php';
        echo '</div>';
      } else {
        REKLAMMA();
     } ?>
</body>
</html>
