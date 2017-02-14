<?php

$query = "SELECT * FROM `communities` WHERE (`url` = '".$_POST['url']."')";
$result = mysqli_query($CONNECT, $query);
$community = mysqli_fetch_array($result);


if ($_POST['name']) {
	$_POST['name'] = FormChars($_POST['name']);
	mysqli_query($CONNECT , "UPDATE `communities` SET `name` = '".$_POST['name']."' WHERE `url` = '".$_POST['url']."'");
};



if ($_POST['description']) {
	$_POST['description'] = FormChars($_POST['description']);
	mysqli_query($CONNECT , "UPDATE `communities` SET `description` = '".$_POST['description']."' WHERE `url` = '".$_POST['url']."'");
};

if (!file_exists("resources/communities/".$_POST['url'])) {mkdir("resources/communities/".$_POST['url'],0777);};


//if ($user['avatar']) {unlink(substr($user['avatar'],24));};

    $errorSubmit = false; // контейнер для ошибок
        if(isset($_FILES['avatar']) && $_FILES['avatar'] !=""){ // передали ли нам вообще файл или нет
            $whitelist = array(".gif", ".jpeg", ".png", ".jpg", ".bmp"); // список расширений, доступных для нашей аватарки
            // проверяем расширение файла
            //===>>>
            $error = true; //флаг, отвечающий за ошибку в расширении файла
            foreach  ($whitelist as  $item) {
                if(preg_match("/$item\$/i",$_FILES['avatar']['name'])) $error = false;
            }
            //<<<===
            if($error){
                // если формат не корректный, заполняем контейнер для ошибок
                $errorSubmit = 'Не верный формат картинки!';
            }else{
                // если формат корректный, то сохраняем файл
                // и все остальную информацию о пользователе
                // Файл сохранится в папку /files/
                move_uploaded_file($_FILES["avatar"]["tmp_name"], "resources/communities/".$_POST['url']."/".$_FILES["avatar"]["name"]);
                $path_file = "http://fixyfox.ru/resources/communities/".$_POST['url']."/".$_FILES["avatar"]["name"];
								mysqli_query($COMMUNITYBD , "UPDATE `".$_POST['url']."Images` SET `status` = 'waslogo' WHERE `status` = 'logo'");
								mysqli_query($COMMUNITYBD , "INSERT INTO `".$_POST['url']."Images`  VALUES ('', '".$_POST['avaname']."', 'logo','".$path_file."','".$_POST['avadescription']."','0','0','0')");
            }
        }

MessageSend(3, 'обновлена', "../../".$_POST['url']);

?>
