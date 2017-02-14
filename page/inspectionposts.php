<?php

if ($_SESSION['position'] != 'admin') {MessageSend(1,"Вы не можете просматривать эту страницу","/");};
$title="Статьи на проверку"; include 'blocks/header.php';
?>
<div class="description">
<p>Статьи на проверку</p>
</div>
<hr>
 <?php
$postsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles`"));
$i = $postsNumber[0];
while ($i >= 1) {
$post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$i."'"));
if ($post['status'] == "inspection") {
echo '<a href="'.$i.'" class="postname" >'.$post['name'].'</a> / '.$post['category'];
echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";}
$i--;
};

 include 'blocks/content.php';

 ?>
