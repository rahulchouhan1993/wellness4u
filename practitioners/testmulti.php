<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['submit']))
{
   echo '<pre>';
   print_r($_POST);
   echo '</pre>';
   die();
}
?>
<!DOCTYPE html>
<html>
<body>

    <form method="post">
  First name:<br>
  <input type="text" name="firstname">
  <br>
  Last name:<br>
  <input type="text" name="lastname">
  
  <select name="multi[]" id="multi" multiple="multiple">
      <option value="one" >one</option>
      <option value="two" >two</option>
     <option value="three" >three</option>
      <option value="four" >four</option>
       <option value="five" >five</option> 
       <option value="six" >six</option>
          
       
  </select>
  <input type="submit" name="submit">
</form>

<p>Note that the form itself is not visible.</p>

<p>Also note that the default width of a text input field is 20 characters.</p>

</body>
</html>
