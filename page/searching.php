<?php $title="Поиск ".$page; include 'blocks/header.php'; ?>
<form class="" action="/p/query-searching" method="post">
  <input type="text" name="tags" value="<?php echo $page; ?>">
  <input type="submit" name="enter" value="Найти">
</form>
<br>
<?php

if ($page) {
  //Поиск в таблицах юзеров
  $postsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles`"));
  $i = $postsNumber[0];
  while ($i >= 1) {
  $post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$i."'"));

  if (strripos($post['tags'],$page)) {

  if (strlen($post['name']) > 77) {
    $postname=substr($post['name'], 0, 77)."...";
  } else {
      $postname = $post['name'];
  }

  echo '<a href="/'.$_SESSION['id'].'/'.$i.'" class="postname" title="'.$post['name'].'" >'.$postname.'</a> / Комментариев - '.$post['comments'];
  echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";}
  $i--;
  };

  $i=0;


  //Поиск в таблицах сообществ
  $commNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities`"));
  $j = $commNumber[0];
  while ($j >= 1) {
  $community = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `communities` WHERE `id` = '".$j."'"));

  $CommpostsNumber = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT COUNT(*) FROM `".$community['url']."Articles`"));
  $i = $CommpostsNumber[0];
  while ($i >= 1) {
  $post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$community['url']."Articles` WHERE `id` = '".$i."'"));

  if (strripos($post['tags'],$page)) {

  if (strlen($post['name']) > 77) {
    $postname=substr($post['name'], 0, 77)."...";
  } else {
      $postname = $post['name'];
  }

  echo '<a href="/'.$community['url'].'/'.$i.'" class="postname" title="'.$post['name'].'" >'.$postname.'</a> / Комментариев - '.$post['comments'];
  echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";}
  $i--;
  };
  $j--;
};
}

 include 'blocks/content.php'; ?>
