<?php

//Ищем логотип:
$CommunityLogo = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$module."Images` WHERE `status` = 'logo'"));


$post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Articles` WHERE `id` = '".$page."'"));
if ($post['status'] == 'deleted') {MessageSend(1,"Извините но статья ".$post['name']." удалена","/".$module);};

$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$post['author']."'"));
$post['visits']+= 1;
mysqli_query($COMMUNITYBD , "UPDATE `".$module."Articles` SET `visits` = '".$post['visits']."' WHERE `id` = '".$page."'");




if ($post['status'] == "inspection") {//UCLASS("admin");
  if ($_SESSION['position'] != 'admin' and $post['author'] != $_SESSION['id']) {MessageSend(1,"Вы не можете просматривать эту страницу","/");};
};
 $title=$post['name']; include 'blocks/header.php';

echo '<a href="javascript:history.back();" style="display:inline-block;" >Назад</a>';
echo "<span style=\"float:right;display:inline-block;\">"./*$author['name']." ".$author['lastname']."  ".*/$post['date']."</span>";
echo "<hr><span style=\"font-size:27px;font-weight: 600;display:inline-block;\" >".$post['name']."</span>";
if ($_SESSION['id'] == $post['author'] or $_SESSION['position'] == 'admin') {
echo '<br><a href="'.$page.'/edit" class="smalla" >Edit</a> ';
echo '<a href="'.$page.'/delete" class="smalla" >Delete</a> ';};
if ($_SESSION['position'] == 'admin' and $post['status'] == 'inspection' ) {
echo '<a href="'.$page.'/verify" class="smalla" >Verify</a> ';
};
echo "<br><div class='article' >".$post['text'];
echo '<hr style="height:1px;">Теги:';

$Tags=explode(",",$post['tags']);
foreach ($Tags as $tag) {
    echo '<a href="/searching/'.$tag.'">'.$tag.'</a>,';
};

echo '</div>';
echo "<br><br>Просмотров - ".$post['visits']."<span style=\"float:right;\">Author - <a href=\"/".$post['author']."\" class=\"postname\" >".$author['name']." ".$author['lastname']."</a></span><br>";

$commentsNumber = mysqli_fetch_array(mysqli_query($COMMENTBD , "SELECT COUNT(*) FROM `".$module.$page."`"));
mysqli_query($CONNECT , "UPDATE `uarticles` SET `comments` = '".$commentsNumber[0]."' WHERE `id` = '".$page."'");

$i = $commentsNumber[0];
$MainCommentsNumber = mysqli_fetch_array(mysqli_query($COMMENTBD , "SELECT COUNT(*) FROM `".$module.$page."` WHERE `mainid`=0 "));

echo '<center>Комментарии('.$MainCommentsNumber[0].')</center>';
echo '<div style="display:inline-block;width:100%;">';
while ($i >= 1) {
$comment = mysqli_fetch_array(mysqli_query($COMMENTBD, "SELECT * FROM `".$module.$page."` WHERE `id` = '".$i."'"));
if ($comment['mainid']=="0") {
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$comment['user']."'"));

echo '
<div class="comments" ><a href="/'.$comment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;">  '.$comment['date'].' '.$comment['time'].'</span><br>'.$comment['text'];
if ($_SESSION['status']=='login' and $comment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$comment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';
}
$daughterCommentsCount = mysqli_fetch_array(mysqli_query($COMMENTBD, "SELECT COUNT(*) FROM `".$module.$page."` WHERE (`mainid` = '".$comment['id']."')"));
if ($daughterCommentsCount[0]) {
$daughterCommentResult = mysqli_query($COMMENTBD, "SELECT * FROM `".$module.$page."` WHERE (`mainid` = '".$comment['id']."') ORDER BY id ASC, date DESC LIMIT $daughterCommentsCount[0]");
while($daughterComment = mysqli_fetch_array($daughterCommentResult)) {
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$daughterComment['user']."'"));

echo '
<div class="comments2" ><a href="/'.$daughterComment['user'].'" class="postname" >'.$author['name'].' '.$author['lastname'].'</a><span style="font-size:10px;float:right;"> '.$daughterComment['date']." ".$daughterComment['time']."</span><br>".$daughterComment['text'];
if ($_SESSION['status']=='login' and $daughterComment['user']!=$_SESSION['id']) echo '<br><div  class="AnsweringButton" id="'.$daughterComment['id'].'"  style="display:inline-block;"  value="'.$author['name'].'"  id="AnsweringButton">Ответить</div>';
echo '</div>';
;};};
$i--;
};
echo '</div>';
if ($_SESSION['status']=='login') {
 ?>



<br><br>
<form class="" action="/users/article/query/commentadd" method="post">
  <input type="hidden" name="id" value="<?php echo '/'.$module.'/'.$page; ?>" >
    <input type="hidden" id="mainid" name="mainid" value="0" >
  <input type="hidden" name="tablename" value="<?php echo $module.$page; ?>" >
  <div style="display:inline-block;width:90.1%;">
    <textarea type="text" id="textarea" name="text" placeholder="Text" required></textarea>
  </div><br>
    <div class="addButton" style="display:inline-block;width:30px;" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить видео" id="addvideo">В</div>


  <input style="float:right;position:relative;top:15px;" type="submit" name="add" value="Отправить">
</form>
<? }; include 'blocks/content.php';include 'blocks/sidebars/community.php';
 ?>
