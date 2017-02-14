<div class="sidebar">
    <?php
      if ($_SESSION['status'] != 'login') {
        echo '<div class="sb_block">';
        include 'module/users/login.php';
        echo '</div>';

        echo '<br><div class="sb_block">
      <img src="http://www.houses.ru/upload/rk/657/6-230-335.jpg" width="100%" >
    </div>';
      } else {
     ?>

  <?php
  $UserProjectsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities` WHERE `creator` = '".$_SESSION['id']."'"));
  if ($UserProjectsNumber[0] == 0) { ?>
    <div class="description">
    Здесь вы можете добавить проект.
   </div>

  <?php ;} else {
   ?>

    <div class="sb_block_name">
     Мои Проекты
    </div>
    <div class="sb_block">
      <?php
      $projectsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities`"));
      $i = 1;
      while ($i <= $projectsNumber[0]--) {
      $community = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `communities` WHERE `id` = '".$i."'"));
      if ($community['creator'] == $_SESSION['id']) {
      echo '<a href="/'.$community['url'].'" class="postname" title="'.$community['name'].'" >'.$community['name'].'</a>';
      echo "<hr style=\"height:1px;\" >";}
      $i++;
    };
       ?>
    </div><br><?php }; ?>

        <a href="/communities/add" style="text-decoration: none;" ><div class="AddToFollowers">
          Создать сообщество
        </div></a>

      <?php }; ?>
</div>
<div class="scrollup"></div>
<script type='text/javascript' src='/js/addbuttons.js'></script>
</body>
</html>
