                     
 <table width="100%" cellspacing="5" cellpadding="10" border="0" class="footerBg" id="footer" >                                                    <tbody><tr>                                                        
                        <td width="70%" valign="middle" height="" align="left">
                        <div style="background-color:#5abd46; padding-left:15px;">
                        <span id="footer_pages" class="footerN" > <a class="footer_link" href="index.php">Home</a> | <a class="footer_link" href="about_us.php">About Us</a> | <a class="footer_link" href="contact_us.php">Contact Us</a> | <a class="footer_link" href="resources.php">Resources</a> | <a class="footer_link" href="disclaimer.php" >Disclaimer</a> | <a class="footer_link" href="terms_and_conditions.php" >Terms &amp; Conditions</a> | <a class="footer_link" href="privacy_policy.php">Privacy Policy</a> | </span><a href="#" class="footer_link" target="_blank">Blog</a></div> </td>                                                        <td width="30%" rowspan="2" align="right" valign="middle"><table width="30%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><a href="https://www.facebook.com/WellnessWay4U" target="_blank"><img src="../uploads/fb.jpg" width="32" height="32" alt="facebook" /></a></td>

    <td><a href="https://twitter.com/WellnessWay4U" target="_blank"><img src="../uploads/tw.jpg" width="32" height="32" alt="Twitter" /></a></td>

    <td><a href="#" target="_blank"><img src="../uploads/linkedin.jpg" width="32" height="32" alt="Linkedin" /></a></td>

    <td><a href="#" target="_blank"><img src="../uploads/youtube.jpg" width="32" height="32" alt="Youtube" /></a></td>

 <td><a target="_blank" href="#"><img width="32" height="32" alt="instagram" src="../uploads/instagram.jpg"></a></td>

  </tr>

</table></td>                                                    </tr>

 
</tbody>

</table>
                            
 <div style="font-size:12px;">&copy;2016 Chaitanya Wellness Research Institute, all rights reserved.</div>
<!--default footer end here-->
 
        
        <div class="feedback"><img src="images/feedback_button.png" width="35" height="127" /></div> 
<div class="QTPopup">    <div class="popupGrayBg"></div>    <div class="QTPopupCntnr">        <div class="gpBdrRight">            <div class="caption">                <div id="caption_text">Feedback and Suggestions</div>            </div>            <a href="#" class="closeBtn" title="Close"></a>            <div id="prwcontent">                <br />                <form id="frm_feedback" name="frm_feedback" method="post" action="#" enctype="multipart/form-data">                    <input type="hidden" name="main_page_id" id="main_page_id" value="<?php echo $main_page_id; ?>" />                    <input type="hidden" name="hdn_p_id" id="hdn_p_id" value="" />                    <?php $temp_page_id = getTemppageId($page_id);?>                    <table cellpadding="0" cellspacing="0" width="75%" align="center" border="0">                        <tr>                            <td width="60%" height="40" align="left" valign="top">Subject:</td>                            <td width="40%" height="40" align="left" valign="top">                                <select id="temp_page_id" name="temp_page_id">                                    <?php echo getFeeadBackPages($temp_page_id); ?>                                </select>                            </td>                        </tr>                        <?php                         if(isLoggedIn())                        {                            $user_id = $_SESSION['user_id'];                            $name = getUserFullNameById($user_id);                            $email = getUserEmailById($user_id);                            $readonly = ' readonly ';                        }                        else                        {                            $readonly = '';                        } ?>                        <tr>                            <td width="60%" height="40" align="left" valign="top">Name:</td>                            <td width="40%" height="40" align="left" valign="top">                                <input type="text" id="name" name="name" <?php  echo $readonly; ?> value="<?php echo $name; ?>"/>                            </td>                        </tr>                        <tr>                            <td width="60%" height="40" align="left" valign="top">Email:</td>                            <td width="40%" height="40" align="left" valign="top">                                <input type="text" id="email" name="email" <?php  echo $readonly; ?> value="<?php echo $email; ?>"/>                                                                         </td>                        </tr>                        <tr>                            <td width="60%" height="110" align="left" valign="top">Feedback and Suggestions:</td>                            <td width="40%" height="110" align="left" valign="top">                                    <textarea  cols="30" rows="5" type="text" id="feedback" name="feedback"><?php echo $textarea;?></textarea>                                                                         </td>                        </tr>                        <tr>                            <td width="60%" height="40" align="left" valign="middle">&nbsp;</td>                            <td width="40%" height="40" align="left" valign="middle">                                <input name="submit" type="button" class="button" id="submit" value="Submit"  onclick="GetFeedback()"/>                            </td>                        </tr>                       </table>                </form>            </div>        </div>    </div></div>