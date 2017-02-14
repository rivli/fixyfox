<?php
session_start();
include_once 'setting.php';
include_once 'php/UMC.php';

if ($_SESSION['position'] == 'admin') {
error_reporting(E_ALL);
ini_set('display_errors', 1);
};

$params = array();// Массив параметров из URI запроса.
$query_string = str_replace("q=","",trim($_SERVER['REQUEST_URI']));//получили строку
$query_string = urldecode($query_string);//получили строку
$query_params = explode("/",$query_string);// разбиваем на массив
foreach ($query_params as $query_param) // и проверяем
 if ($query_param != "")                // а вдруг в конец слеш не дописали
    $params[] =  $query_param;

$module = array_shift($params);
$page = array_shift($params);
$ident1 = array_shift($params);
$ident2 = array_shift($params);

/*
  if ($module == false ) {include "module/bloff/index.php";}
  else if ($page == false and intval($module) ) {include "module/users/profile.php" ;}
 else if ($page == false and file_exists("page/$module.php")) {include "page/$module.php" ;}
 else if (file_exists("module/$module") and ($page == false) ) { include "module/$module/index.php" ;}
 else if ($page == "query") { include "module/$module/$page/$ident1.php" ;}
 else if (intval($page) && !$ident1) { include "module/$module/post.php" ;}
 else if (intval($ident1) && $module == "users") {include "module/users/umessage.php" ;}
 else if ($ident1 == "edit" && file_exists("module/$module")) {include "module/$module/edit.php" ;}
 else if ($ident1 == "delete" && file_exists("module/$module")) {include "module/$module/query/delete.php" ;}
 else if ($ident1 == "verify" && file_exists("module/$module")) {include "module/$module/query/verify.php" ;}
 else if (file_exists("module/$module/$page.php")) { include "module/$module/$page.php" ;}
 else {header('HTTP/1.0 404 Not Found');exit(include("page/404.php"));};
*/
//new URL: (on developing)
//variant 2


//Добавить базу данных с УРЛ проектов и по ней проверять является ли данная страница страницей проекта
if ($module == false ) {include "page/index.php";}
  else {
    $projectsarray = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `arrays` WHERE `name` = 'communities'"));//Получаем список УРЛ проектов
    $projarray = explode("/",$projectsarray['array']);
    if (in_array($module,$projarray)) {
      //В сообществе
      if (!$page) {include 'module/community/community.php';} else {
         if (!$ident1) {
           if (intval($page)) {include 'module/community/article.php';} else {
             if (file_exists('module/community/'.$page.'.php')) include 'module/community/'.$page.'.php';
           };
         } else {
           if (intval($page)) {
             if ($ident1=='edit' or $ident1=='delete') {include 'module/community/'.$ident1.'article.php';}
           };
           if ($page == 'query' and file_exists('module/community/query/'.$ident1.'.php')) {include 'module/community/query/'.$ident1.'.php';}
         }
      };
    }
    else {
    if (ctype_digit($module)) {
      //user
      if ($page == false) {include "module/users/profile.php";} else {
        if ($ident1 == false) {//here may modernization.add edit and delete
          if (intval($page)) {include 'module/users/article/uarticle.php';} else {
            if ($page == 'edit') include 'module/users/'.$page.'.php';
            if ($page == 'add') include 'module/users/article/'.$page.'.php';
            if ($page == 'follow') include 'module/users/query/'.$page.'.php';
            if ($page == 'unfollow') include 'module/users/query/'.$page.'.php';
          }
        } else if ($ident2 == false) {
            if ($page == 'query' and $ident1 == 'editing') include 'module/users/query/'.$ident1.'.php';
          if ($ident1 == 'edit') include 'module/users/article/'.$ident1.'.php';
          if ($ident1 == 'delete') include 'module/users/article/query/'.$ident1.'.php';
        }
        }
      } else if ($module == 'reg') {include 'module/users/registration.php';}
        else if ($module == 'm') {
          if ($page == false) {include 'module/users/message.php';} else {
            if (intval($page)) include 'module/users/umessage.php';
          }
        }
        else if ($module == 'p') {
          if ($page == false) {include 'page/index.php';} else { include 'page/'.$page.'.php';
          }
        }
        else if ($module=='searching') {include 'page/searching.php';}
        else if ($page == 'query' and file_exists('module/'.$module.'/'.$page.'/'.$ident1.'.php')) {include 'module/'.$module.'/'.$page.'/'.$ident1.'.php';}
        else if ($ident1 == 'query' and file_exists('module/'.$module.'/'.$page.'/'.$ident1.'/'.$ident2.'.php')) {include 'module/'.$module.'/'.$page.'/'.$ident1.'/'.$ident2.'.php';}
        else if ($module=="communities") {
          if ($page == false) {include "module/community/index.php";} else {
            if ($ident1 == false) {
              if ($page == "add") {include 'module/community/add.php';}
              } else {
              if (file_exists('module/community/'.$ident1)) include 'module/community/'.$ident1;
            }
          }
        }
        else if ($module) {//Здесь творится космическая хрень и без нее сайт не работает
          if ($page == false) {include "module/community/index.php";} else {
            if ($ident1 == false) {include 'module/community/community.php';} else {
              if (file_exists('module/community/'.$ident1)) include 'module/community/'.$ident1;
            }
          }
        }
        else {header('HTTP/1.0 404 Not Found');exit(include("page/404.php"));};
    };};



?>
