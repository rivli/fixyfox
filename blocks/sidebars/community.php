
<?php

if (!$CommunityLogo) {
  $logo = "http://zakilven.bget.ru/resources/communities/communitylogo.jpg";
} else {
  $logo = $CommunityLogo['url'];
}
$AmIFollower = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Followers` WHERE `userid` = '".$_SESSION['id']."' and (`status` = 'follower' or `status` = 'creator')"));

 ?>

<div class="sidebar">
  <div class="sb_block" style="padding:3px;padding-bottom:0;">
    <img src="<?php echo $logo ?>" width="100%"  class="popupimage" alt="<?php echo $community['name']?>"  title="<?php echo $CommunityLogo['description'] ?>" >
  </div>
  <a href="/<?php echo $module ?>/photo" style="text-decoration: none;" ><div class="AddToFollowers">
    <span class="">Фотографии</span>
  </div></a>
<?php if (!$AmIFollower) { ?>
      <a href="/<?php echo $module ?>/query/follow" style="text-decoration: none;" ><div class="AddToFollowers">
        <span class="">Подписаться</span>
      </div></a>
<?php ;} else if ($AmIFollower['status'] != "creator") { ?>
    <a href="/<?php echo $module ?>/query/unfollow" style="text-decoration: none;" ><div class="AddToFollowers">
      <span class="">Отписаться</span>
    </div></a>
  <?php ;} else { ?>
    <a href="/<?php echo $module ?>/edit" style="text-decoration: none;" ><div class="AddToFollowers">
      <span class="">Редактировать</span>
    </div></a>
    <?php ;}; ?>
  <br>
  <div class="sb_block_name">
  Подписчики
  </div>
  <div class="sb_block">
  <?php
  $FollowersNumber = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT COUNT(*) FROM `".$module."Followers`"));
  $i = $FollowersNumber[0];
  while ($i >= 1) {
  $follower = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Followers` WHERE `id` = '".$i."'"));
  $user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE (`id` = '".$follower['userid']."')"));
  if ($follower['status'] == 'creator') {
  echo '<a href="/'.$follower['userid'].'" class="postname" title="'.$user['name'].' '.$user['lastname'].'" >'.$user['name'].' '.$user['lastname'].'</a> - Создатель';
  echo "<hr style=\"height:1px;\" >";}
  else if ($follower['status'] == 'follower') {
    echo '<a href="/'.$follower['userid'].'" class="postname" title="'.$user['name'].' '.$user['lastname'].'" >'.$user['name'].' '.$user['lastname'].'</a>';
    echo "<hr style=\"height:1px;\" >";
  }
  $i--;
};
   ?>
</div><br>

</center>
</div>
