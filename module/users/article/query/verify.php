<?php

if ($_SESSION['position'] != 'admin') {MessageSend(1,"Вы не можете просматривать эту страницу","/bloff/".$page);} else {

mysqli_query($CONNECT , "UPDATE `bloff` SET `status` = 'verified' WHERE `id` = '".$page."'") or die("Ошибка MySQL: " . mysql_error());

MessageSend(2, 'Запись Подтверждена', '/bloff/'.$page);
};

 ?>
