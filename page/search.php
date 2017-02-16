<?php $title="Поиск ".$page; include 'blocks/header.php'; ?>
<form class="" action="/p/query-search" method="post">
  <input type="text" name="tags" placeholder="Найти" style="width:60%;" value="<?php echo $page; ?>">
  <input type="submit" name="enter" value="Найти">
</form>
<br>
<?php




if ($page) {
  $search=explode(' ',$page);//Получаем слова из поиска
  $s=count($search);

  //Поиск в таблицах юзеров
  $postsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `uarticles`"));


  $i=1;//номер предложения

  $vivod=array();


  //Проверяем превый массив предложений
  while ($i<=$postsNumber[0]) {
    $post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$i."'"));
    $post['text'] = "0".$post['text'];//заменяем 0вой элемент на 0
    $j=0;
    $d=0;//количество сопадений слов из поиска в iом предложении
    while($j<$s) {
              if (strripos($post['text'],$search[$j])) {//Ищем совпадение слова в предложениее
                $d++;;//если совпадает то прибавляем 1 к входящим словам
              }
          $j++;
    }
    if ($d) array_push($vivod, array($i,"uarticles",$d));
    $i++;

    /*
    $vivod[1] - Статья
    $vivod[1][0] - id сатьти в указанной базе данных
    $vivod[1][1] - база данных в которой находится статья
    $vivod[1][2] - количество совпадений
    */
  }







  //Поиск в таблицах сообществ
  $commNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities`"));
  $z = $commNumber[0];
  while ($z >= 1) {
      $community = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `communities` WHERE `id` = '".$z."'"));
      $CommpostsNumber = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT COUNT(*) FROM `".$community['url']."Articles`"));
      $i = 1;

      while ($i <= $CommpostsNumber[0]) {
          $post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$community['url']."Articles` WHERE `id` = '".$i."'"));
          $post['text'] = "0".$post['text'];//заменяем 0вой элемент на 0
          $j=0;
          $d=0;//количество сопадений слов из поиска в iом предложении
          while($j<$s) {
                    if (strripos($post['text'],$search[$j])) {//Ищем совпадение слова в предложениее
                      $d++;;//если совпадает то прибавляем 1 к входящим словам
                    }
                $j++;
          }
          if ($d) array_push($vivod, array($i,$community['url']."Articles",$d));
          $i++;
        };
      $z--;
    };



//---------------------------------------------------

$size = count($vivod)-1;
for ($i = $size; $i>=0; $i--) {
    for ($j = 0; $j<=($i-1); $j++)
    if ($vivod[$j][2]<$vivod[$j+1][2]) {
        $puzir=$vivod[$j];
        $vivod[$j]=$vivod[$j+1];
        $vivod[$j+1]=$puzir;
    }
};
$vc = count($vivod);
/*
 echo "<pre>";
  print_r($vivod);
  echo "</pre>";
*/

$x=0;
while ($x<$vc) {

    if ($vivod[$x][1] != 'uarticles') {
        $post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$vivod[$x][1]."` WHERE `id` = '".$vivod[$x][0]."'"));
        $community = substr($vivod[$x][1], 0, -8);
        echo '<a href="/'.$community.'/'.$vivod[$x][0].'" class="postname" title="'.$post['name'].'" >'.$post['name'].'</a> / Комментариев - '.$post['comments'];
        echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";
    } else {
        $post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$vivod[$x][0]."'"));
        echo '<a href="/'.$post['author'].'/'.$vivod[$x][0].'" class="postname" title="'.$post['name'].'" >'.$post['name'].'</a> / Комментариев - '.$post['comments'];
        echo "<span class='date'>".$post['date']."</span><hr style=\"height:1px;\" >";
    }
  $x++;
}

if (!$vc) {
  echo 'Статей "'.$page.'" не найдено.';
}

}



 include 'blocks/content.php';include 'blocks/sidebars/indexsb.php'; ?>
