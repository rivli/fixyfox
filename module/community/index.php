<?php $title="Сообщества"; include 'blocks/header.php';

if ($module != "communities") {
  $projectsarray = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `arrays` WHERE `name` = 'communities'"));//Получаем список УРЛ проектов
  $projarray = explode("/",$projectsarray['array']);
  if (!in_array($module,$projarray)) { ?>
    <div class="description" style="text-align:center;">
      URL "<?php echo $module ?>" свободен.
    </div><br>
  <?php ;};}; ?>




  <div class="description">
    Популярные проекты
  </div>

<br>
    <?php
    $projectsNumber = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT COUNT(*) FROM `communities`"));
    $i = 1;
    if ($projectsNumber[0]>5) {$projectsNumber[0]=5;};
    $result = mysqli_query($CONNECT, "SELECT * FROM communities ORDER BY followers DESC LIMIT 0,".$projectsNumber[0]."");
    while ($community = mysqli_fetch_array($result)) {
    $CommunityLogo = mysqli_fetch_array(mysqli_query($COMMUNITYBD , "SELECT * FROM `".$community['url']."Images` WHERE `status` = 'logo'"));
    if (!$CommunityLogo) {
      $logo = "https://zakilven.bget.ru/resources/communities/communitylogo.jpg";
    } else {
      $logo = $CommunityLogo['url'];
    } ?>

<a href="/<?php echo $community['url'] ?>">
    <div class="example3"  style="width:32.8%;height:150px;"  >
        <img src="<?php echo $logo; ?>" class="example_beauty" style="width:100%;height:150px;" />
        <div class="example_text">
            <h6><?php echo $community['name']?></h6>
            <span class="shortdescription" ><?php echo substr($community['description'], 0, 35)."..."; ?></span>
        </div>
    </div>
</a>
<?php  }; ?>

<?php include 'blocks/content.php';include 'blocks/sidebars/communities.php'; ?>
