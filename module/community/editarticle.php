<?php
$post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Articles` WHERE `id` = '".$page."'"));
if ($_SESSION['position'] != 'admin' and $post['author'] != $_SESSION['id']) {MessageSend(1,"Вы не можете просматривать эту страницу","/bloff/".$page);} else {
  $title="Edit ".$post['name']; include 'blocks/header.php';

?>

<div class="description">
<p>После сохранения изменений запись будет отправлена на проверку.Пожалуйста не нарушайте правила.</p>
</div>
<br>
<form class="" action="/community/query/editarticle" method="post">
  <label >Name : </label><input type="text" name="name" value="<?php echo $post['name']; ?>" required><hr>
  <label >Теги : </label>
<input type="text" name="tags" placeholder="Теги" style="width:80%;" value="<?php echo $post['tags']; ?>" required><br>
  <label for="commacces">Разрешить комментарии? :
    <input type="radio" name="commacces" value="1" required>Да
    <input type="radio" name="commacces" value="2" required>Нет
  </label>
  <hr>
  <div style="display:inline-block;width:90.1%;">
    <textarea type="text" id="textarea" name="text" cols="90" rows="5" style="height:330px;min-height:160px; max-width: 97%; min-width: 97%;padding:10px;" required><?php echo $post['text']; ?></textarea>
  </div>
  <div style="display:inline-block;width:9%;position:relative;bottom:13px;">
    <div class="addButton" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" title="Вставить изображение">И</div>
      <div class="addButton" title="Вставить аудиозапись">А</div>
      <div class="addButton" title="Вставить видео">В</div>
  </div>
  <input type="hidden" name="postid" value="<?php echo $page ?>">
  <input type="hidden" name="communityname" value="<?php echo $module ?>">
  <input type="hidden" name="post" value="<?php echo '/'.$module.'/'.$page ?>">
  <input type="submit" name="edit" value="Save">
</form>

<?php include 'blocks/content.php'; } ?>
