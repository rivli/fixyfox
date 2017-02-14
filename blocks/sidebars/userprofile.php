<div class="sidebar">
  <div class="sb_block" style="padding:3px;padding-bottom:0;">
    <img src="<?php echo $user['avatar'] ?>" class="popupimage" width="100%"  alt="<?php echo $user['name']." ".$user['lastname'] ?> ">
  </div>
     <?php if ($module == $_SESSION['id']) { ?>

        <a href="/communities/add" style="text-decoration: none;" ><div class="AddToFollowers">
          Создать сообщество
        </div></a>

    <?php } else {
      $userFollowers = explode("/",$user['followers']);
      if (!in_array($_SESSION['id'],$userFollowers)) {
       ?>
      <a href="/<?php echo $module; ?>/follow" style="text-decoration:none" >
          <div class="AddToFollowers">Подписаться</div>
      </a>
      <?php } else { ?>
        <a href="/<?php echo $module; ?>/unfollow" style="text-decoration:none" >
            <div class="AddToFollowers">Отписаться</div>
        </a>
      <?php } ?>
      <a href="/m/<?php echo $module; ?>" style="text-decoration:none" >
          <div class="AddToFollowers">Отправить сообщение</div>
      </a>

<?php };
$UserProjectsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities` WHERE `creator` = '".$module."'"));
if ($UserProjectsNumber[0] == 0) {
if ($module==$_SESSION['id']) {
 ?>
  <div class="description">
  Здесь вы можете добавить проект.
 </div>

<?php ;} else { ?>
  <div class="description">
    У пользователя нет пока проектов.
  </div>
<?php ;};} else {
 ?>

  <?php };

    if ($user['communities']) { ?>
      <br>
      <div class="sb_block_name">
        Сообщества
      </div>
        <div class="sb_block">
    <?php
    $communities22 = explode("/",$user['communities']);//получаем УРЛи добавляем новый если нет его в списке
    $communitiesNumber22 = count($communities22);
    $communitiesNumber22 -= 1;
    $z=0;
      while ($z <= $communitiesNumber22) {
      $community11 = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `communities` WHERE `url` = '".$communities22[$z]."'"));
      if ($community11['creator'] == $module) {
      echo '<a href="/'.$community11['url'].'" class="postname" title="'.$community11['name'].'" >'.$community11['name'].'</a> - Создатель';
      echo "<hr style=\"height:1px;\" >";} else {
          echo '<a href="/'.$community11['url'].'" class="postname" title="'.$community11['name'].'" >'.$community11['name'].'</a>';
          echo "<hr style=\"height:1px;\" >";
      }
      $z++;
    }; ?>
  </div><br><?php };

    if ($user['followers']) { ?>
      <div class="sb_block_name">
        Подписчики
      </div>
        <div class="sb_block">
    <?php
    $followers = explode("/",$user['followers']);//получаем УРЛи добавляем новый если нет его в списке
    $followersNum = count($followers);
    $followersNum -= 1;
    $i=0;
      while ($i <= $followersNum) {
      $follower = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$followers[$i]."'"));
      echo '<a href="/'.$follower['id'].'" class="postname" title="'.$follower['name'].' '.$follower['lastname'].'" >'.$follower['name'].' '.$follower['lastname'].'</a>';
      echo "<hr style=\"height:1px;\" >";
      $i++;
    }; ?>
  </div><br><?php };

  if ($user['follow']) { ?>
    <div class="sb_block_name">
      Подписки
    </div>
      <div class="sb_block">
  <?php
  $follows = explode("/",$user['follow']);//получаем УРЛи добавляем новый если нет его в списке
  $followsNum = count($follows);
  $followsNum -= 1;
  $j=0;
    while ($j <= $followsNum) {
    $follow = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$follows[$j]."'"));
    echo '<a href="/'.$follow['id'].'" class="postname" title="'.$follow['name'].' '.$follow['lastname'].'" >'.$follow['name'].' '.$follow['lastname'].'</a>';
    echo "<hr style=\"height:1px;\" >";
    $j++;
  }; ?>
</div><br><?php }; ?>



</div>
</body>
</html>
