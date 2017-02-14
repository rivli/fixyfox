
<center>
<form method="POST" action="/users/query/login" >
  <br><input type="email" name="email" placeholder="E-Mail"  required><br>
  <input type="password" name="password" placeholder="Password" maxlength="15" pattern="[A-Za-z-0-9]{5,15}" title="Не менее 5 и неболее 15 латынских символов или цифр." required><br>
  <br><input type="submit"  name="enter" value="Enter">



  <a href="/reg" style="position:relative;left:10px;bottom:2px;">
      <div class="abutton">
          <span class="insideabutton">Registration</span>
        </div>
  </a>
</form>



</center>
