<?php
$query = "SELECT * FROM `communities` WHERE (`url` = '".$module."')";
$result = mysqli_query($CONNECT, $query);
$project = mysqli_fetch_array($result);


//Ищем логотип:
$CommunityLogo = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$module."Images` WHERE `status` = 'logo'"));
//Выгружаем все данные о Сообществе:
$community = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT * FROM `communities` WHERE `url` = '".$module."'"));
//Ищем логотип:
$UserPosition = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$module."Followers` WHERE `userid` = '".$_SESSION['id']."'"));


 $title="Photo ".$project['name']; include 'blocks/header.php';
 $photosNumber = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT COUNT(*) FROM `".$module."Images`"));
 $result = mysqli_query($COMMUNITYBD, "SELECT * FROM ".$module."Images ORDER BY id DESC LIMIT 0,".$photosNumber[0]."");
 while ($photo = mysqli_fetch_array($result)) {

   echo '<div><img src="'.$photo['url'].'" width="65%" style="display:inline-block;">';
   echo '
   <div class="" style="display:inline-block;width:20%;float:rigth;height:100%;position:absolute;padding:5px;">
   ';
   echo '
   <div class="" style="display:inline-block;position:relative;">
    <b>Name:</b> '.$photo['name'] .'
   </div>
   <br>
   ';
   echo '
   <div class="" style="display:inline-block;position:relative;">
     <b>Description:</b> '.$photo['description'] .'
   </div>
   </div>
   </div>
   <hr>
   ';
};

 include 'blocks/content.php';include 'blocks/sidebars/community.php';  ?>
