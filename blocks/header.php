<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="/blocks/style.css">
  <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
    <script type='text/javascript' src='/js/scrollup.js'></script>
    <script type='text/javascript' src='/js/popup_img.js'></script>
    <script type="text/javascript">
    setInterval(function(){
$("#newMessages").load("php/UMC.php #newMessages");
}, 5000);
    </script>

  </head>
  <body>
    <?php
    $inspection = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT COUNT(*) FROM `uarticles` WHERE `status` = 'inspection'"));
     if ($_SESSION['position']=='admin') { ?>
       <a href="/p/inspectionposts">
      <div class="inspection">
      <?php echo $inspection[0]; ?>
      </div>
    </a>
    <?php }; if ($_SESSION['status']=='login') {  ?>
    <a href="/m">
   <div class="inspection" style="top:100px;" id="newMessages" title="Непрочитанных сообщений">
   <?php
  echo $unreadMessagesSumm; ?>
   </div>
 </a>
 <?php ;}; ?>
    <div class="header" align="center">
        <a href="/" class="menua"><div class="menu">Главная</div></a>
        <a href="/communities" class="menua"><div class="menu">Сообщества</div></a>
        <a href="/<?php if ($_SESSION['id']) {echo $_SESSION['id'];} else echo 1; ?>" class="menua"><div class="menu">Профиль</div></a>
    </div>
    <div class="mainpart">
    <?php  if ($_SESSION['message']) MessageShow(); ?>
    <div class="content">
