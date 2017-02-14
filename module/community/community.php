<?php
$query = "SELECT * FROM `communities` WHERE (`url` = '".$module."')";
$result = mysqli_query($CONNECT, $query);
$project = mysqli_fetch_array($result);
$title=$project['name']; include 'blocks/header.php';


//Ищем логотип:
$CommunityLogo = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$module."Images` WHERE `status` = 'logo'"));
//Выгружаем все данные о Сообществе:
$community = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT * FROM `communities` WHERE `url` = '".$module."'"));
//Ищем логотип:
$UserPosition = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$module."Followers` WHERE `userid` = '".$_SESSION['id']."'"));


?>

  <div class="description">
    <?php echo $project['description']; ?>
  </div><br>



  <form class="" action="#" method="post" style="display:inline-block;">
    <input type="text" name="search"  placeholder="Search">
    <button type="button" name="find">Find</button>
  </form>
  <?php if ($UserPosition['status'] == 'creator') { ?>
  <a href="/<?php echo $module ?>/addarticle" style="float:right;display:inline-block;"><div class="abutton">
    <span class="insideabutton">Add</span>
  </div></a> <?php }; ?>
  <hr>


  <?php

  $postsNumber = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT COUNT(*) FROM `".$module."Articles`"));
  $i = $postsNumber[0];
  while ($i >= 1) {
  $post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Articles` WHERE `id` = '".$i."'"));
  $author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$post['author']."'"));
  if ($post['status'] == "verified") {

  /*  if (strlen($post['name']) > 75) {
      $postname=substr($post['name'], 0, 70)."...";
    } else {*/
        $postname = $post['name'];
  //  }


  echo '<a href="'.$module.'/'.$i.'" class="postname" title="'.$post['name'].'" >'.$postname.'</a>';
  echo "<span class='date'>".$post['date']."</span>";
  echo '<br><span class="date" style="font-size:10px;color:#656565">'.$author['name'].' '.$author['lastname'].'</span>';
  echo "<hr style=\"height:1px;\" >";}
  $i--;
  };
   ?>

<?php include 'blocks/content.php';include 'blocks/sidebars/community.php'; ?>
