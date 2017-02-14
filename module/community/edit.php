<?php
$query = "SELECT * FROM `communities` WHERE (`url` = '".$module."')";
$result = mysqli_query($CONNECT, $query);
$community = mysqli_fetch_array($result);

 $title="Редактировать ".$community['name']; include 'blocks/header.php'; ?>

<h1 align="center">Редатктировать</h1>

<form method="POST" action="query/edit" enctype="multipart/form-data">
<br><input type="text" name="name" value="<?php echo $community['name'] ?>" placeholder="Название" style="width:100%;" pattern="[A-Za-z-0-9-А-Яа-яЁё]{4,10}" title="Не менее 4 и неболее 10 латынских символов или цифр." ><br>
<br><textarea type="text" name="description" placeholder="Описание" cols="60" rows="10" style="width:100%;padding:5px;" ><?php echo $community['description'] ?></textarea><br>
<hr><label>Avatar : <input type="file" value="" name="avatar"></label><br>
<input type="text" name="avaname" placeholder="Название Изображения" style="width:40%;">
<br><textarea type="text" name="avadescription" placeholder="Описание Изображения" cols="60" rows="5" style="width:100%;padding:5px;"></textarea><br>
<br><input type="hidden" name="url" value="<?php echo $module; ?>">
<input type="submit" name="enter" value="Сохранить">
</form>


<?php include 'blocks/content.php'; ?>
