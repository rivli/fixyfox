<?php $title="FixyFox"; include 'blocks/header.php';
$query = "SELECT * FROM `users` WHERE (`id` = '".$_SESSION['id']."')";
$result = mysqli_query($CONNECT, $query);
$user = mysqli_fetch_array($result);
$userFollows = explode("/",$user['follow']);
?>

<form class="" action="#" method="post" style="display:inline-block;">
  <input type="text" name="search"  placeholder="Search">
  <button type="button" name="find">Find</button>
</form>
<?php if ($_SESSION['status'] == 'login') { ?>
<a href="/<?php echo $_SESSION['id'] ?>/add" style="float:right;display:inline-block;"><div class="abutton">
  <span class="insideabutton">Add</span>
</div></a> <?php }; ?>
<hr>


<?php

$postsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles`"));
$i = $postsNumber[0];
while ($i >= 1) {
$post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$i."'"));
$author = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$post['author']."'"));
if ($post['status'] == "verified" and in_array($post['author'],$userFollows)) {

/*  if (strlen($post['name']) > 75) {
    $postname=substr($post['name'], 0, 70)."...";
  } else {*/
      $postname = $post['name'];
//  }


echo '<a href="'.$post['author'].'/'.$i.'" class="postname" title="'.$post['name'].'" >'.$postname.'</a> ';
echo "<span class='date'>".$post['date']."</span>";
echo '<br><span class="date" style="font-size:10px;color:#656565">'.$author['name'].' '.$author['lastname'].'</span>';
echo "<hr style=\"height:1px;\" >";}
$i--;
};
 ?>

<?php include 'blocks/content.php';include 'blocks/sidebars/indexsb.php'; ?>
