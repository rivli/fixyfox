<?php $title="Registration"; include 'blocks/header.php'; ?>
<center>
<form class="" action="/users/query/registration" method="post">
  <input type="text" name="name" placeholder="Name" required>
  <input type="text" name="lastname" placeholder="Last Name" required><br><br>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <label for="sex">You :
    <input type="radio" name="sex" value="male" required>Male
    <input type="radio" name="sex" value="female" required>Female
  </label><br><br>
  <input type="submit" name="registration" value="Registration">
</form>
</center>

<?php include 'blocks/content.php'; ?>
