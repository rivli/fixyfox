<?php

if ($_SESSION['status'] == 'login') {
$query = "SELECT * FROM `users` WHERE (`id` = '".$module."')";
$result = mysqli_query($CONNECT, $query);
$user = mysqli_fetch_array($result);


if ($user != 0) {

    $title=$user['name']." ".$user['lastname']; include 'blocks/header.php';
if ($user['acc_verification'] == 0 and $user['id'] == $_SESSION['id']) MessageSend(1,"Подтвердите ваш аккаунт по почте ".$user['email']);
?>

<div>
	<span style="font-size: 25px;display:inline-block;"><?php echo $user['name']." ".$user['lastname'] ?></span>

	<div style="float:right;display:inline-block;">
<?php	if ($module == $_SESSION['id']) { ?>
		<a href="/<?php echo $module; ?>/edit" style="text-decoration:none" >
          <div class="abutton">
              <span class="insideabutton">Edit profile</span>
            </div>
        </a>
				<a href="/users/query/logout" style="text-decoration:none" >
				      <div class="abutton">
				          <span class="insideabutton">Exit</span>
				        </div>
				</a>
	<?php }; ?>


</div>
<br>
  <br>E-mail: <?php echo $user['email'] ?>
	<?php if ($user['birthday'] != "0000-00-00") { ?><br>Дата рождения: <?php echo $user['birthday']; }; ?>
	<br>Дата регистрации: <?php echo $user['regdate'] ?>
	<?php if ($user['about']) { ?><br>О себе: <?php echo $user['about']; }; ?>
</div>
<hr>
<span>Cтатьи:</span>
<?php if ($module == $_SESSION['id']) { ?>
<a href="/<?php echo $_SESSION['id'] ?>/add" style="float:right;display:inline-block;position:relative;bottom:4px;"><div class="abutton">
  <span class="insideabutton">Add</span>
</div></a><?php ;}; ?>
<hr>
<?php
$UserPostsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles` WHERE `author` = '".$module."'"));
if ($UserPostsNumber[0] == 0) {
if ($module==$_SESSION['id']) {
 ?>
  <div class="description">
    Здесь вы можете добавить статью на свою страницу,которая будет выведена на главной странице у ваших подписчиков.
 </div>
 <br>
<?php ;} else { ?>
  <div class="description">
    У пользователя нет статей.
  </div>
<?php ;};} else {
$postsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles`"));
$i = $postsNumber[0];
while ($i >= 1) {
$post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$i."'"));
if ($post['author'] == $module and $post['status'] == "verified") {

if (strlen($post['name']) > 77) {
  $postname=substr($post['name'], 0, 77)."...";
} else {
    $postname = $post['name'];
}

echo '<a href="/'.$_SESSION['id'].'/'.$i.'" class="postname" title="'.$post['name'].'" >'.$postname.'</a> / Комментариев - '.$post['comments'];
echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";}
$i--;
};
};
} else {
$title="Пользователь не найден"; include 'blocks/header.php';
echo "Пользователь с id = ".$module." не найден";} ?>

<?php include 'blocks/content.php';include 'blocks/sidebars/userprofile.php';
} else MessageSend(1,"Зарегестрируйтесь или авторизуйтесь ","/");
?>
