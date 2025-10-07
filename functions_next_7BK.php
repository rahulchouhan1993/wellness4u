<?php
function deleteUserBPS($user_id,$user_bps_id)
{
    global $link;
    $return = false;
    
    $sql = "UPDATE `tblusersbps` SET `bps_old_data` = '1' WHERE `user_bps_id` = '".$user_bps_id."' AND `user_id` = '".$user_id."'";
    $result = mysql_query($sql,$link);
    if($result)
    {
            $return = true;	
    }
    
    return $return;
}
function getCommaSepratedBMS($bms_id)
{
	global $link;
	
        $output = '';
		 
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` IN (".$bms_id.") AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while($row = mysql_fetch_array($result))
            {
                $output .= $row['bms_name'].', ';
            }
            $output = substr($output,0,-2);
            $output = str_replace(',', '<br>', $output);
	}
	
        return $output;
}

function getCommaSepratedBMSScale($scale)
{
	global $link;
	
        $output = str_replace(',', '<br>', $scale);
	
        return $output;
}

function getCommaSepratedBMSScaleImage($scale)
{
	global $link;
        
        $scale_image_str = '';
        $arr_temp = explode(',',$scale);
        for($i=0;$i<count($arr_temp);$i++)
        {
            $scale_image_str .= $arr_temp[$i].'<br><img src="'.SITE_URL.'/images/'.getScaleImage($arr_temp[$i]).'" width="240" border="0" />,';
        }
	
        $output = str_replace(',', '<br>', $scale_image_str);
	
        return $output;
}

function getUserBPSDetails($user_id,$bps_date)
{
    global $link;
    $arr_records = array();
    
    $sql = "SELECT * FROM `tblusersbps` WHERE `user_id` = '".$user_id."' AND `bps_date` = '".$bps_date."' AND `bps_old_data` = '0' ORDER BY `bps_add_date` DESC";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        while($row = mysql_fetch_array($result))
        {
            $arr_records[] = $row; 
        } 
    }
    return $arr_records; 
}

function getUserBPSBox($user_id,$bps_date)
{
    global $link;
    $output = '';
    
    $sql = "SELECT * FROM `tblusersbps` WHERE `user_id` = '".$user_id."' AND `bps_date` = '".$bps_date."' AND `bps_old_data` = '0' ORDER BY `bps_add_date` DESC";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $output .= '<table width="580" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                        <tr>
                            <td width="10%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>
                            <td width="50%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Body Part</strong></td>
                            <td width="20%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Symptoms</strong></td>
                            <td width="10%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>Scale</strong></td>
                            <td width="10%"  align="left" valign="middle" bgcolor="#FFFFFF"><strong>&nbsp;</strong></td>
                        </tr>';
        $i = 1;
        while($row = mysql_fetch_array($result))
        {
            $output .= '<tr>
                            <td align="left" valign="middle" bgcolor="#FFFFFF">'.$i.'</td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF">'.getUserBodyPartImageBoxSaved($row['bp_id'],$row['spotx'],$row['spoty'],$row['bps_image']).'</td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF">'.getCommaSepratedBMS($row['bms_id']).'</td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF">'.getCommaSepratedBMSScale($row['scale']).'</td>
                            <td align="left" valign="middle" bgcolor="#FFFFFF"><input type="button" name="btnDel" id="btnDel" value="Delete" onclick="deleteUserBPS(\''.$row['user_bps_id'].'\')" /></td>
                        </tr>';
            $i++;
        } 
        $output .= '</table><p>&nbsp;</p>'; 
        
    }
    
    
    
    return $output; 
}

function addUsersBPS($user_id,$bps_date,$bp_id,$spotx,$spoty,$bms_id,$scale,$bps_image)
{
	global $link;
	$return = false;
        
        
        $sql = "INSERT INTO `tblusersbps` (`user_id`,`bps_date`,`bp_id`,`spotx`,`spoty`,`bms_id`,`scale`,`bps_image`) "
                . "VALUES ('".$user_id."','".$bps_date."','".$bp_id."','".$spotx."','".$spoty."','".$bms_id."','".$scale."','".$bps_image."')";
        //echo"<br>".$sql;
        $result = mysql_query($sql,$link);
        if($result)
        {
                $return = true;	
        }
	return $return;
}

function getAllBodyParts($bp_sex,$bp_side)
{
	global $link;
	
	$arr_bp_id = array(); 
        $arr_bp_name = array();
        $arr_bp_image = array();
		 
	$sql = "SELECT * FROM `tblbodyparts` WHERE `bp_side` = '".$bp_side."' AND `bp_sex` = '".$bp_sex."' AND `bp_status` = '1' AND `bp_deleted` = '0' ORDER BY `bp_id` ";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while($row = mysql_fetch_array($result))
            {
                array_push($arr_bp_id , $row['bp_id']);
                array_push($arr_bp_name , $row['bp_name']);
                array_push($arr_bp_image , $row['bp_image']);
            }	
	}
	
        return array($arr_bp_id,$arr_bp_name,$arr_bp_image);
}

function getUserBodySymptomsOptionsMulti($arr_bms_id,$bmst_id)
{
    global $link;
    $output = '';
    
    
    $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '".$bmst_id."' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY bms_name";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        while($row = mysql_fetch_array($result))
        {
            if(in_array($row['bms_id'],$arr_bms_id))
            {
                    $sel = ' selected ';
            }
            else
            {
                    $sel = '';
            }		
            $output .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($row['bms_name']).'</option>';
        }
    }
    
    
    
    return $output; 
}

function getUserBodyPartImageBoxSaved($bp_id,$spotx,$spoty,$bps_image)
{
    global $link;
    $output = '';
    
    $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."' AND `bp_status` = '1' AND `bp_deleted` = '0' ";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $bp_name = $row['bp_name'];
        $bp_image = $row['bp_image'];
        
        if(strtolower($bp_name) == 'mouth')
        {
            $body_image = 'mouth.jpg';
            
            $bp_image_x1 = 0;
            $bp_image_x2 = 174;
            $bp_image_y1 = 0;
            $bp_image_y2 = 215;
            $bp_image_w = 174;
            $bp_image_h = 215;

            $top = $bp_image_y1;
            $right = $bp_image_x2;
            $bottom = $bp_image_y2;
            $left = $bp_image_x1;

            $body_image = SITE_URL.'/uploads/'.$body_image;
            
            $arr_temp_image2 = explode(',',$bps_image);

            $bps_image_x1 = $arr_temp_image2[0];
            $bps_image_x2 = $arr_temp_image2[1];
            $bps_image_y1 = $arr_temp_image2[2];
            $bps_image_y2 = $arr_temp_image2[3];
            $bps_image_w = $arr_temp_image2[4];
            $bps_image_h = $arr_temp_image2[5];

            $bps_top = $bp_image_h - $bps_image_y1;
            $bps_left = $bps_image_x1;
            
            $output .= '<div style="float:left;text-align:center;width:100%;"><span class="Header_brown">'.$row['bp_name'].'</span></div>';
            $output .= '<div style="clear:both; height:10px;"></div>';
            $output .= '<div style="display: block;position:absoulute; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;">';    
            $output .= '<div style="display: block; position:relative; z-index:100; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; ">&nbsp</div>';
            //$output .= '<div style="display: block; background:-moz-radial-gradient('.$spotx.'px '.$spoty.'px 45deg, circle, rgba(255,0,0,0.2) 5%, rgba(255,255,255,0.4) 10px); margin-top:-'.$bp_image_h.'px; z-index:1000;   position:relative;width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;  ">&nbsp</div>';
            $output .= '<div style="display: block; background: rgba(0,0,255,0.50); width: '.$bps_image_w.'px;height: '.$bps_image_h.'px; margin-top:-'.$bps_top.'px; margin-left:'.$bps_left.'px; z-index:1000;   position:relative;  ">&nbsp</div>';        
            $output .= '</div>';
        }
        else
        {

            if($row['bp_sex'] == '1')
            {
                $list_bp_sex = 'Male';

                if($row['bp_side'] == '1')
                {
                    //$body_image = 'male_body_front_big.png';
                    $body_image = 'male_body_front_medium.png';
                }
                else
                {
                    //$body_image = 'male_body_back_big.png';
                    $body_image = 'male_body_back_medium.png';
                }
            }
            else
            {
                $list_bp_sex = 'Female';

                if($row['bp_side'] == '1')
                {
                    //$body_image = 'female_body_front_big.png';
                    $body_image = 'female_body_front_medium.png';
                }
                else
                {
                    //$body_image = 'female_body_back_big.png';
                    $body_image = 'female_body_back_medium.png';
                }
            }

            $arr_temp_image = explode(',',$row['bp_image']);

            /*
            $bp_image_x1 = $arr_temp_image[0] * 5;
            $bp_image_x2 = $arr_temp_image[1] * 5;
            $bp_image_y1 = $arr_temp_image[2] * 5;
            $bp_image_y2 = $arr_temp_image[3] * 5;
            $bp_image_w = $arr_temp_image[4] * 5;
            $bp_image_h = $arr_temp_image[5] * 5;

            $top = $bp_image_y1;
            $right = $bp_image_x2;
            $bottom = $bp_image_y2;
            $left = $bp_image_x1;

            $body_image = SITE_URL.'/uploads/'.$body_image;
            //echo '<br>'.$bps_image.'<br>';
            $arr_temp_image2 = explode(',',$bps_image);

            $bps_image_x1 = $arr_temp_image2[0];
            $bps_image_x2 = $arr_temp_image2[1];
            $bps_image_y1 = $arr_temp_image2[2];
            $bps_image_y2 = $arr_temp_image2[3];
            $bps_image_w = $arr_temp_image2[4];
            $bps_image_h = $arr_temp_image2[5];

            $bps_top = $bp_image_h - $bps_image_y1;
            $bps_left = $bps_image_x1;

             * 
             */      

            /*
            $bp_image_x1 = $arr_temp_image[0] * 5;
            $bp_image_x2 = $arr_temp_image[1] * 5;
            $bp_image_y1 = $arr_temp_image[2] * 5;
            $bp_image_y2 = $arr_temp_image[3] * 5;
            $bp_image_w = $arr_temp_image[4] * 5;
            $bp_image_h = $arr_temp_image[5] * 5;
             * 
             */

            $bp_image_x1 = $arr_temp_image[0] * 3;
            $bp_image_x2 = $arr_temp_image[1] * 3;
            $bp_image_y1 = $arr_temp_image[2] * 3;
            $bp_image_y2 = $arr_temp_image[3] * 3;
            $bp_image_w = $arr_temp_image[4] * 3;
            $bp_image_h = $arr_temp_image[5] * 3;

            $top = $bp_image_y1;
            $right = $bp_image_x2;
            $bottom = $bp_image_y2;
            $left = $bp_image_x1;

            $body_image = SITE_URL.'/uploads/'.$body_image;
            //echo '<br>'.$bps_image.'<br>';
            $arr_temp_image2 = explode(',',$bps_image);

            $bps_image_x1 = $arr_temp_image2[0];
            $bps_image_x2 = $arr_temp_image2[1];
            $bps_image_y1 = $arr_temp_image2[2];
            $bps_image_y2 = $arr_temp_image2[3];
            $bps_image_w = $arr_temp_image2[4];
            $bps_image_h = $arr_temp_image2[5];

            $bps_top = $bp_image_h - $bps_image_y1;
            $bps_left = $bps_image_x1;







            /*
            $output .= '<div style="float:left;text-align:center;width:100%;"><span class="Header_brown">'.$row['bp_name'].'</span></div>';
            $output .= '<div style="clear:both; height:10px;"></div>';
            $output .= '<div style="display: block;position:absoulute;">';    
            $output .= '<div style="display: block; position:relative; z-index:100; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; ">&nbsp</div>';
            $output .= '<div style="display: block; background: rgb(255,0,0);  opacity:0.4; top: -'.$spoty.'px; left: '.$spotx.'px; z-index:1000;position:relative;width: 10px;height: 10px;  ">&nbsp</div>';
            $output .= '</div>';    
            */

            $output .= '<div style="float:left;text-align:center;width:100%;"><span class="Header_brown">'.$row['bp_name'].'</span></div>';
            $output .= '<div style="clear:both; height:10px;"></div>';
            $output .= '<div style="display: block;position:absoulute; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;">';    
            $output .= '<div style="display: block; position:relative; z-index:100; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; ">&nbsp</div>';
            //$output .= '<div style="display: block; background:-moz-radial-gradient('.$spotx.'px '.$spoty.'px 45deg, circle, rgba(255,0,0,0.2) 5%, rgba(255,255,255,0.4) 10px); margin-top:-'.$bp_image_h.'px; z-index:1000;   position:relative;width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;  ">&nbsp</div>';
            $output .= '<div style="display: block; background: rgba(0,0,255,0.50); width: '.$bps_image_w.'px;height: '.$bps_image_h.'px; margin-top:-'.$bps_top.'px; margin-left:'.$bps_left.'px; z-index:1000;   position:relative;  ">&nbsp</div>';        
            $output .= '</div>';    
        }    
    }
    
    
    
    return $output; 
}

function getUserBodyPartImageBox($bp_id)
{
    global $link;
    $output = '';
    
    $sql = "SELECT * FROM `tblbodyparts` WHERE `bp_id` = '".$bp_id."' AND `bp_status` = '1' AND `bp_deleted` = '0' ";
    //echo '<br>'.$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $bp_name = $row['bp_name'];
        $bp_image = $row['bp_image'];
        
        
        if(strtolower($bp_name) == 'mouth')
        {
            $body_image = 'mouth.jpg';
            
            $bp_image_x1 = 0;
            $bp_image_x2 = 174;
            $bp_image_y1 = 0;
            $bp_image_y2 = 215;
            $bp_image_w = 174;
            $bp_image_h = 215;

            $top = $bp_image_y1;
            $right = $bp_image_x2;
            $bottom = $bp_image_y2;
            $left = $bp_image_x1;

            $body_image = SITE_URL.'/uploads/'.$body_image;
            
            $output .= '<div style="float:left;text-align:center;width:100%;"><span class="Header_brown">'.$row['bp_name'].'</span></div>';
            $output .= '<div style="clear:both; height:10px;"></div>';
            $output .= '<div   style="overflow:scroll;display: block;position:absoulute;width: 230px;height: 170px; ">';    
            $output .= '<div id="target" alt="[Jcrop Example]" style="display: block; position:relative; z-index:100; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; ">&nbsp</div>';
            //$output .= '<img style="position:absoulute; clip: rect('.$top.'px, '.$right.'px, '.$bottom.'px, '.$left.'px );"  src="'.$body_image.'" border="0">';
            //$output .= '<div id="playpen"  style="display: block; background: rgb(255,255,255);  opacity:0.2; margin-top:-'.$bp_image_h.'px; z-index:1000;   position:relative;width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;  ">&nbsp</div>';
            $output .= '</div>';    
            //$output = '<div style="display: block;position:relative;width: 250px;height: 250px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -800px -100px; ">&nbsp</div>';
            //$output = '<div style="display: block;position:relative;width: 250px;height: 250px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; background-size:100% 100%; ">&nbsp</div>';
        }
        else
        {
            if($row['bp_sex'] == '1')
            {
                $list_bp_sex = 'Male';

                if($row['bp_side'] == '1')
                {
                    //$body_image = 'male_body_front_big.png';
                    $body_image = 'male_body_front_medium.png';
                }
                else
                {
                    //$body_image = 'male_body_back_big.png';
                    $body_image = 'male_body_back_medium.png';
                }
            }
            else
            {
                $list_bp_sex = 'Female';

                if($row['bp_side'] == '1')
                {
                    //$body_image = 'female_body_front_big.png';
                    $body_image = 'female_body_front_medium.png';
                }
                else
                {
                    //$body_image = 'female_body_back_big.png';
                    $body_image = 'female_body_back_medium.png';
                }
            }

            $arr_temp_image = explode(',',$row['bp_image']);

            /*
            $bp_image_x1 = $arr_temp_image[0] * 5;
            $bp_image_x2 = $arr_temp_image[1] * 5;
            $bp_image_y1 = $arr_temp_image[2] * 5;
            $bp_image_y2 = $arr_temp_image[3] * 5;
            $bp_image_w = $arr_temp_image[4] * 5;
            $bp_image_h = $arr_temp_image[5] * 5;
             * 
             */

            $bp_image_x1 = $arr_temp_image[0] * 3;
            $bp_image_x2 = $arr_temp_image[1] * 3;
            $bp_image_y1 = $arr_temp_image[2] * 3;
            $bp_image_y2 = $arr_temp_image[3] * 3;
            $bp_image_w = $arr_temp_image[4] * 3;
            $bp_image_h = $arr_temp_image[5] * 3;

            $top = $bp_image_y1;
            $right = $bp_image_x2;
            $bottom = $bp_image_y2;
            $left = $bp_image_x1;

            $body_image = SITE_URL.'/uploads/'.$body_image;
            
            $output .= '<div style="float:left;text-align:center;width:100%;"><span class="Header_brown">'.$row['bp_name'].'</span></div>';
            $output .= '<div style="clear:both; height:10px;"></div>';
            $output .= '<div   style="overflow:scroll;display: block;position:absoulute;width: 230px;height: 170px; ">';    
            $output .= '<div id="target" alt="[Jcrop Example]" style="display: block; position:relative; z-index:100; width: '.$bp_image_w.'px;height: '.$bp_image_h.'px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; ">&nbsp</div>';
            //$output .= '<img style="position:absoulute; clip: rect('.$top.'px, '.$right.'px, '.$bottom.'px, '.$left.'px );"  src="'.$body_image.'" border="0">';
            //$output .= '<div id="playpen"  style="display: block; background: rgb(255,255,255);  opacity:0.2; margin-top:-'.$bp_image_h.'px; z-index:1000;   position:relative;width: '.$bp_image_w.'px;height: '.$bp_image_h.'px;  ">&nbsp</div>';
            $output .= '</div>';    
            //$output = '<div style="display: block;position:relative;width: 250px;height: 250px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -800px -100px; ">&nbsp</div>';
            //$output = '<div style="display: block;position:relative;width: 250px;height: 250px; background-image: url('.$body_image.');background-repeat: no-repeat;background-position: -'.$bp_image_x1.'px -'.$bp_image_y1.'px; background-size:100% 100%; ">&nbsp</div>';
        }    

        
        
    }
    
    
    
    return $output; 
}

function getUserFullBodyImageBox($user_id,$bp_side)
{
    global $link;
    $output = '';
    
    if($bp_side == '')
    {
        $bp_side = '1';
    }
    
    $sex = getUserSex($user_id);
    if($sex == 'Female')
    {
        $bp_sex = '0';
        if($bp_side == '0')
        {
            $body_image = 'female_body_back.png';
        }
        else
        {
            $body_image = 'female_body_front.png';
        }
    }
    else 
    {
        $bp_sex = '1';
        if($bp_side == '0')
        {
            $body_image = 'male_body_back.png';
        }
        else
        {
            $body_image = 'male_body_front.png';
        }
    }
    /*
    $output .= '<img src="images/empty.gif" width="211" height="546" border="0" usemap="#location-map" id="emptygif" />
                <div id="overlayr1">&nbsp;</div>
                <div id="overlayr2">&nbsp;</div>
                <img src="'.SITE_URL.'/uploads/'.$body_image.'" width="211" height="546" border="0" />
                <map name="location-map" id="location-map">
                  <area shape="rect" coords="0,0,211,160" href="#" id="r1" />
                  <area shape="rect" coords="0,161,211,350" href="#" id="r2"/>
                </map>';
     * 
     */
    
    list($arr_bp_id,$arr_bp_name,$arr_bp_image) = getAllBodyParts($bp_sex,$bp_side);
    $str_overlay = '';
    $str_area = '';
    for($i = 0;$i<count($arr_bp_id); $i++)
    {
        $arr_temp_image = explode(',',$arr_bp_image[$i]);
        $bp_image_x1 = $arr_temp_image[0];
        $bp_image_x2 = $arr_temp_image[1];
        $bp_image_y1 = $arr_temp_image[2];
        $bp_image_y2 = $arr_temp_image[3];
        $bp_image_w = $arr_temp_image[4];
        $bp_image_h = $arr_temp_image[5];
        
        $str_style = ' width:'.$bp_image_w.'px; height:'.$bp_image_h.'px; ';
        if($bp_image_x1 > 0)
        {
            //$str_style .= ' left:'.$bp_image_x1.'px; ';
            $str_style .= ' left:'.$bp_image_x1.'px; ';
        }
        
        if($bp_image_y1 > 0)
        {
            //$str_style .= ' top:'.$bp_image_y1.'px; ';
            $str_style .= ' top:'.$bp_image_y1.'px; ';
        }
        
        $str_overlay .= '<div title="'.$arr_bp_name[$i].'" id="overlayr'.$arr_bp_id[$i].'" class="overlayr" style="'.$str_style.'">&nbsp;</div>'; 
        $str_area .= '<area title="'.$arr_bp_name[$i].'" shape="rect" coords="'.$bp_image_x1.','.$bp_image_y1.','.$bp_image_x2.','.$bp_image_y2.'" href="javascript:void();" id="r'.$arr_bp_id[$i].'" />'; 
    }
    
    $output .= '<img src="images/empty.gif" width="211" height="546" border="0" usemap="#location-map" id="emptygif" />
                '.$str_overlay.'
                <img src="'.SITE_URL.'/uploads/'.$body_image.'" width="211" height="546" border="0" />
                <map name="location-map" id="location-map">'.$str_area.'</map>';
    
    return $output; 
}

function gethomeImage($page_id,$position)
{
	global $link;
	$banner = '';
	
	$sql = "SELECT * FROM `tblbanners` WHERE  `page_id` = '".$page_id."' AND `position` = '".$position."' AND `status` = '1' ORDER BY RAND() limit 1";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		
		$position = $row['position'];
		$width = $row['width'];
		$height= $row['height'];
		$url = $row['url'];
		$banner_type = $row['banner_type'];
		$page 	 = $row['page'];
		$banner 	 = $row['banner'];
	}
	return array($position,$width,$height,$url,$banner_type,$page,$banner);
}

function get_max_banner_id($position_id,$page_id)
{
	global $link;
	$max_banner_id = '';
	
	$sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '".$position_id."' AND `page_id` = '".$page_id."' AND status = '1' ORDER BY banner_id DESC limit 1";
	//echo $sql.'</br>';
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$max_banner_id = $row['banner_id'];
	}
	return $max_banner_id;
}

function get_min_banner_id($position_id,$page_id)
{
	global $link;
	$min_banner_id = '';
	
	$sql = "SELECT * FROM `tblbanners` WHERE  `position_id` = '".$position_id."' AND `page_id` = '".$page_id."' AND status = '1' ORDER BY banner_id ASC limit 1";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$min_banner_id = $row['banner_id'];
	}
	return $min_banner_id;
}


function getbanners($page_id,$side)
{
	global $link;
	
	$arr_banner_id = array(); 
	$arr_page_id = array(); 
	$arr_page = array(); 
	$arr_position_id = array();
	$arr_banner = array();
	$arr_url  = array(); 
	$arr_banner_type = array(); 
	$arr_position = array(); 
	$arr_side = array();
	$arr_width = array();
	$arr_height = array();
	$arr_sequence_banner_id = array();
	 
	$sql = "SELECT * FROM `tblposition` WHERE `side` = '".mysql_escape_string($side)."' ORDER BY `position` ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$position_id = $row['position_id'];
			$max_banner_id =  get_max_banner_id($position_id,$page_id);
			$min_banner_id = get_min_banner_id($position_id,$page_id);
			//$_SESSION['ref_banner_id_'.$position_id] = '';
			//echo'</br>Session ID BS['.$position_id.'] -'.$_SESSION['ref_banner_id_'.$position_id];
			if( ($_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] == '' ) || ($_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] == $max_banner_id))
			{
				$sql2 =  "SELECT * FROM `tblbanners` AS TA
						  LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id
						  WHERE TA.position_id = '".$position_id."' AND TA.page_id = '".$page_id."' AND TA.status = '1' ORDER BY  `banner_id` LIMIT 1";
			}
			else
			{	
				$sql2 =  "SELECT * FROM `tblbanners` AS TA
						  LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id
						  WHERE TA.position_id = '".$position_id."' AND TA.page_id = '".$page_id."' AND TA.status = '1'  AND TA.banner_id > '".$_SESSION['ref_banner_id_'.$position_id.'_'.$page_id]."' ORDER BY TA.banner_id LIMIT 1";
			}
			//echo $sql2.'</br>';
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				while($row2 = mysql_fetch_array($result2))
				{
					 //echo'</br>max banner id['.$position_id.'] -'.$max_banner_id;
					 //echo'</br>min banner id['.$position_id.'] -'.$min_banner_id;
					//echo'</br> banner id['.$position_id.'] -'.$row2['banner_id'];
					$_SESSION['ref_banner_id_'.$position_id.'_'.$page_id] = $row2['banner_id'];
					//echo'</br>Session ID['.$position_id.'] -'.$_SESSION['ref_banner_id_'.$position_id].'<br>';
					array_push($arr_banner_id , $row2['banner_id']);
					array_push($arr_page_id , stripslashes($row2['page_id']));
					array_push($arr_page , stripslashes($row2['page']));
					array_push($arr_position_id , $row2['position_id']);
					array_push($arr_banner , stripslashes($row2['banner']));
					array_push($arr_url , stripslashes($row2['url']));
					array_push($arr_banner_type , stripslashes($row2['banner_type']));
					array_push($arr_position , $row2['position']);
					array_push($arr_side , stripslashes($row2['side']));
					array_push($arr_width , stripslashes($row2['width']));
					array_push($arr_height , $row2['height']);
				}
			}
		}	
	}
	//echo $row2['banner'];
	return array($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height);
}

function GetTopBanner()
{
	global $link;
	$banner = '';
	$position = '';
	$height = '';
	$width = '';
	
	$sql = "SELECT * FROM `tbltopbanner` ORDER BY RAND() limit 1";
	
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$banner = stripslashes($row['banner']);
		$position = stripslashes($row['position']);
		$height = stripslashes($row['height']);
		$width = stripslashes($row['width']);
	}	
	return array($banner,$position,$height,$weight);
}
/* amol function End */

function clean($str)
{
	// Only remove slashes if it's already been slashed by PHP
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}
	// Let MySQL remove nasty characters.
	$str = mysql_real_escape_string($str);
	return $str;
}

function chkValidUserId($user_id)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function isLoggedIn()
{
	global $link;
	$return = false;
	if( isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0) && ($_SESSION['user_id'] != '') )
	{
		$return = chkValidUserId($_SESSION['user_id']);	
	}
	return $return;
}

function chkEmailExists($email)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function doUpdateOnline($user_id)
{
	global $link;
	$now = time();
	$return = false;
	
	if($user_id > 0)
	{
		$sql = "UPDATE `tblusers` SET `online_timestamp` = '".$now."' WHERE `user_id` = '".$user_id."'";
		$result = mysql_query($sql,$link);
		if($result)
		{
			$return = true;	
		}
	}	
	return $return;
}

function getMonthOptions($month,$start_month='1',$end_month='12')
{
	$arr_month = array (
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
	
	$start_month = intval($start_month);
	$end_month = intval($end_month);
	$month = intval($month);

	$option_str = '';
	//echo '<br>start_month = '.$start_month.' , end_month = '.$end_month.' , month = '.$month;
	if($start_month == 12 && $end_month == 1)
	{
		if($month == 12)
		{
			$selected = ' selected ';
		}
		else
		{
			$selected = '';
		}
		$option_str .= '<option value="12" '.$selected.' >December</option>';
		
		if($month == 1)
		{
			$selected = ' selected ';
		}
		else
		{
			$selected = '';
		}
		$option_str .= '<option value="1" '.$selected.' >January</option>';
	}
	else
	{
		foreach($arr_month as $k => $v )
		{
			//echo '<br>k = '.$k.' , start_month = '.$start_month.' , end_month = '.$end_month.' , month = '.$month;
			if( ( $k >= $start_month ) && ( $k <= $end_month ) )
			{
				if($k == $month)
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';
			}	
		}	
	}	
	return $option_str;
}

function genrateUserUniqueId($user_id)
{
	$unique_id = '';
	
	$strlen_user_id = strlen($user_id);
	
	if($strlen_user_id == 1)
	{
		$unique_id = 'CW10000000'.$user_id;
	} 
	elseif($strlen_user_id == 2)
	{
		$unique_id = 'CW1000000'.$user_id;
	}
	elseif($strlen_user_id == 3)
	{
		$unique_id = 'CW100000'.$user_id;
	}
	elseif($strlen_user_id == 4)
	{
		$unique_id = 'CW10000'.$user_id;
	}
	elseif($strlen_user_id == 5)
	{
		$unique_id = 'CW1000'.$user_id;
	}
	elseif($strlen_user_id == 6)
	{
		$unique_id = 'CW100'.$user_id;
	}
	elseif($strlen_user_id == 7)
	{
		$unique_id = 'CW10'.$user_id;
	}
	else
	{
		$unique_id = 'CW1'.$user_id;
	}
	 
	return $unique_id;	
}

function signUpUser($name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$password,$country_id)
{
	global $link;
	$return = 0;
	$now = time();
	
	$sql = "INSERT INTO `tblusers` (`name`,`email`,`password`,`dob`,`height`,`weight`,`sex`,`mobile`,`state_id`,`city_id`,`place_id`,`food_veg_nonveg`,`beef`,`pork`,`status`,`user_add_date`,food_chart,`my_activity_calories_chart`,`my_activity_calories_pi_chart`,`activity_analysis_chart`,`meal_chart`,`dpwd_chart`,`mwt_report`,`datewise_emotions_report`,`statementwise_emotions_report`,`statementwise_emotions_pi_report`,`angervent_intensity_report`,`stressbuster_intensity_report`,`each_meal_per_day_chart`,`country_id`) VALUES ('".addslashes($name)."','".$email."','".md5($password)."','".$dob."','".$height."','".$weight."','".$sex."','".addslashes($mobile)."','".$state_id."','".$city_id."','".$place_id."','".addslashes($food_veg_nonveg)."','".addslashes($beef)."','".addslashes($pork)."','0','".$now."','1','1','1','1','1','1','1','1','1','1','1','1','1','".$country_id."')";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$user_id = mysql_insert_id($link);
		$unique_id = genrateUserUniqueId($user_id);
		$sql2 = "UPDATE `tblusers` SET `unique_id` = '".$unique_id."' WHERE `user_id` = '".$user_id."'";
		$result2 = mysql_query($sql2,$link);
		if($result2)
		{	
			$return = true;
		}
	}
	return $return;
}

function doValiadteUser($email)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblusers` SET `status` = '1' WHERE `email` = '".$email."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function chkValidLogin($email,$password)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `password` = '".md5($password)."' AND `status` = '1' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function doLogin($email)
{
	global $link;
	$return = false;
	
	$user_id = getUserId($email);
	$name = getUserFullNameById($user_id);
	$email = getUserEmailById($user_id);
	
	if($user_id > 0)
	{
		$return = true;	
		$_SESSION['user_id'] = $user_id;
		$_SESSION['name'] = $name;
		$_SESSION['email'] = $email;
	}	
	return $return;
}

function getUserId($email)
{
	global $link;
	$user_id = 0;
	
	$sql = "SELECT * FROM `tblusers` WHERE `email` = '".$email."' AND `status` = '1'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$user_id = $row['user_id'];
	}
	return $user_id;
}

function getUserFullNameById($user_id)
{
	global $link;
	$return = false;
	$name = '';
	
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['name']);
	}
	return $name;
}

function getUserUniqueId($user_id)
{
	global $link;
	$unique_id = '';
	
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$unique_id = stripslashes($row['unique_id']);
	}
	return $unique_id;
}
function getProUserUniqueId($pro_user_id)
{
	global $link;
	$unique_id = '';
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$unique_id = stripslashes($row['pro_unique_id']);
	}
	return $unique_id;
}

function getVenderUserUniqueId($pro_user_id)
{
	global $link;
	$unique_id = '';
	
	$sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$unique_id = stripslashes($row['vender_unique_id']);
	}
	return $unique_id;
}

function getUserEmailById($user_id)
{
	global $link;
	$email = '';
	
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$email = $row['email'];
	}
	return $email;
}

function getProUserEmailById($pro_user_id)
{
	global $link;
	$email = '';
	
	$sql = "SELECT * FROM `tblprofusers` WHERE `pro_user_id` = '".$pro_user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$email = $row['email'];
	}
	return $email;
}

function doLogout()
{
	global $link;
	$return = true;	
	
	$sql = "UPDATE `tblusers` SET `online_timestamp` = '0' WHERE `user_id` = '".$_SESSION['user_id']."'";
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
		$_SESSION['user_id'] = '';
		$_SESSION['name'] = '';
		$_SESSION['email'] = '';
		unset($_SESSION['user_id']);
		unset($_SESSION['name']);
		unset($_SESSION['email']);
		session_destroy();
	}	
	return $return;
}

function getUserDetails($user_id)
{
	global $link;
	$return = false;
	$name = '';
	$email = '';
	$dob = '';
	$height = '';
	$weight = '';
	$sex = '';
	$mobile = '';
	$state_id = '';
	$city_id = '';
	$place_id = '';
	$food_veg_nonveg = '';
	$beef = '';
	$pork = '';
	$practitioner_id = '';
	$country_id = '';
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	//echo'<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$return = true;
		$name = stripslashes($row['name']);
		$email = $row['email'];
		$dob = $row['dob'];
		$height = stripslashes($row['height']);
		$weight = stripslashes($row['weight']);
		$sex = $row['sex'];
		$mobile = stripslashes($row['mobile']);
		$state_id = $row['state_id'];
		$city_id = $row['city_id'];
		$place_id = $row['place_id'];
		$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);
		$beef = $row['beef'];
		$pork = $row['pork'];
		$practitioner_id = stripslashes($row['practitioner_id']);
		$country_id = $row['country_id'];
	}
	return array($return,$name,$email,$dob,$height,$weight,$sex,$mobile,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$practitioner_id,$country_id);
}

function getUserSex($user_id)
{
	global $link;
	$sex = '';
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	//echo'<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$sex = $row['sex'];
	}
	return $sex;
}

function updateUser($name,$dob,$height,$weight,$sex,$mobile,$country_id,$state_id,$city_id,$place_id,$food_veg_nonveg,$beef,$pork,$user_id)
{
	global $link;
	$return = false;
	
	$sql = "UPDATE `tblusers` SET `name` = '".addslashes($name)."' , `dob` = '".$dob."' , `height` = '".addslashes($height)."' , `weight` = '".addslashes($weight)."' , `sex` = '".$sex."' , `mobile` = '".addslashes($mobile)."' , `country_id` = '".$country_id."' , `state_id` = '".$state_id."', `city_id` = '".$city_id."', `place_id` = '".$place_id."' , `food_veg_nonveg` = '".addslashes($food_veg_nonveg)."' , `beef` = '".addslashes($beef)."' , `pork` = '".addslashes($pork)."' WHERE `user_id` = '".$user_id."'";
	//echo"<br>Testkk: sql = ".$sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;
}

function getDailyActivityOptions($activity_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['activity_id'] == $activity_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			//$option_str .= '<option value="'.$row['activity_id'].'" '.$sel.'>'.stripslashes($row['activity']).'</option>';
			$option_str .= '<option value="'.$row['activity_id'].'" '.$sel.'>'.$row['activity'].'</option>';
		}
		
		if($activity_id == '0')
		{
			$sel = ' selected ';
		}
		else
		{
			$sel = '';
		}
		$option_str .= '<option value="0" '.$sel.'>Others</option>';
	}
	return $option_str;
}

function getMultipleFieldsValueByComma($str)
{
	$var = '';
	$var_rest = '';
	$var_add = '';
	$var_cnt = 0;
	$var_arr = array();
	$var_arr_rest = array();
	
	if(isset($_POST["$str"]) )
	{
		if( is_array($_POST["$str"]) && count($_POST["$str"]) > 0 )
		{
			foreach($_POST["$str"] as $key => $val)
			{
				$var .= trim($_POST["$str"][$key]).',';
				$var_cnt++;
				array_push($var_arr,trim($_POST["$str"][$key]));
			}
		}
	}	
	
	$var = substr($var,0,-1);
	$var_add = $var;
	if($var_cnt > 1)
	{
		$temp_arr = explode(',',$var,2);
		$var = $temp_arr[0];
		$var_rest = $temp_arr[1];
		$pos2 = strpos($var_rest, ',');
		if ($pos2 !== false)
		{
			$var_arr_rest = explode(",",$var_rest);
		}
		else
		{
			array_push($var_arr_rest,$var_rest);	
		}	
	}
	return array($var,$var_add,$var_rest,$var_cnt,$var_arr_rest,$var_arr);
}

function getMultipleFieldsValueBy($str)
{
	$var = '';
	$var_rest = '';
	$var_add = '';
	$var_cnt = 0;
	$var_arr = array();
	$var_arr_rest = array();
	
	if(isset($_POST["$str"]) )
	{
		if( is_array($_POST["$str"]) && count($_POST["$str"]) > 0 )
		{
			foreach($_POST["$str"] as $key => $val)
			{
				$var .= trim($_POST["$str"][$key]).'::';
				$var_cnt++;
				array_push($var_arr,trim($_POST["$str"][$key]));
			}
		}
	}	
	
	$var = substr($var,0,-2);
	$var_add = $var;
	if($var_cnt > 1)
	{
		$temp_arr = explode('::',$var,2);
		$var = $temp_arr[0];
		$var_rest = $temp_arr[1];
		$pos2 = strpos($var_rest, '::');
		if ($pos2 !== false)
		{
			$var_arr_rest = explode("::",$var_rest);
		}
		else
		{
			array_push($var_arr_rest,$var_rest);	
		}	
	}
	return array($var,$var_add,$var_rest,$var_cnt,$var_arr_rest,$var_arr);
}

function addUsersDailyActivity($user_id,$activity_date,$activity_id_arr,$other_activity_arr,$activity_time_arr,$mins_arr,$proper_guidance_arr,$precaution_arr,$yesterday_sleep_time,$today_wakeup_time)
{
	global $link;
	$return = false;
	
	$sql = "DELETE FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND  `activity_date` = '".$activity_date."'";
	$result = mysql_query($sql,$link);
		
	for($i=0;$i<count($activity_id_arr);$i++)
	{
		if( ($activity_id_arr[$i] != '') && ($activity_id_arr[$i] != '0') && ($mins_arr[$i] != '') && ($mins_arr[$i] != '0') )
		{ 
			$sql = "INSERT INTO `tblusersdailyactivity` (`user_id`,`activity_date`,`activity_id`,`other_activity`,`activity_time`,`mins`,`proper_guidance`,`precaution`,`yesterday_sleep_time`,`today_wakeup_time`) VALUES ('".$user_id."','".$activity_date."','".$activity_id_arr[$i]."','".addslashes($other_activity_arr[$i])."','".$activity_time_arr[$i]."','".$mins_arr[$i]."','".$proper_guidance_arr[$i]."','".addslashes($precaution_arr[$i])."','".addslashes($yesterday_sleep_time)."','".addslashes($today_wakeup_time)."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function getMealQuantityOptions($breakfast_quantity)
{
	global $link;
	$option_str = '';		
	
	if($breakfast_quantity == '1')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}	
	$option_str .= '<option value="1" '.$sel.'>1</option>';
	
	
	if($breakfast_quantity == '1/4')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="1/4" '.$sel.'>1/4</option>';
	
	if($breakfast_quantity == '1/3')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="1/3" '.$sel.'>1/3</option>';
	
	if($breakfast_quantity == '1/2')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="1/2" '.$sel.'>1/2</option>';													
	
	if($breakfast_quantity == '2')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="2" '.$sel.'>2</option>';
	
	if($breakfast_quantity == '2/3')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="2/3" '.$sel.'>2/3</option>';
														
													
	for($j=3;$j<=1000;$j++) 
	{
		if($breakfast_quantity == $j)
		{
			$sel = ' selected ';
		}
		else
		{
			$sel = '';
		}		
		$option_str .= '<option value="'.$j.'" '.$sel.'>'.$j.'</option>';
	}
	return $option_str;
}

function getMealLikeOptions($breakfast_meal_like)
{
	global $link;
	$arr_food_like = array('Like','Dislike','Favourite','Allergic');
	$option_str = '';		
		
	for($i=0;$i<count($arr_food_like);$i++)
	{
		if($breakfast_meal_like == $arr_food_like[$i])
		{
			$sel = ' selected ';
		}
		else
		{
			$sel = '';
		}		
		$option_str .= '<option value="'.$arr_food_like[$i].'" '.$sel.'>'.$arr_food_like[$i].'</option>';
	}

	if($breakfast_meal_like == '')
	{
		$sel = ' selected ';
	}
	else
	{
		$sel = '';
	}
	$option_str .= '<option value="" '.$sel.'>None</option>';
	return $option_str;
}

function getMealLikeIcon($meal_like)
{
	global $link;
	$icon = '';		
		
	if($meal_like == 'Like')
	{
		$icon = '<img border="0" src="'.SITE_URL.'/images/like_icon.jpg" width="18" height="18">';
	}
	elseif($meal_like == 'Dislike')
	{
		$icon = '<img border="0" src="'.SITE_URL.'/images/dislike_icon.jpg" width="18" height="18">';
	}
	elseif($meal_like == 'Favourite')
	{
		$icon = '<img border="0" src="'.SITE_URL.'/images/favorite_icon.jpg" width="18" height="18">';
	}
	elseif($meal_like == 'Allergic')
	{
		$icon = '<img border="0" src="'.SITE_URL.'/images/allergies_icon.jpg" width="18" height="18">';
	}
	else
	{
		$icon = '';
	}
	return $icon;
}


function chkFoodItemExists($meal_id)
{
	global $link;
	$return = false;
	
	if($meal_id == '9999999999')
	{
		$return = true;
	}
	else
	{
		$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
		}
	}	
	return $return;
}

function chkBMSExists($bms_id,$type="")
{
	global $link;
	$return = false;
	
        
        if($type == 'adct')
        {
            $sql = "SELECT * FROM `tbladdictions` WHERE `adct_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'sleep')
        {
            $sql = "SELECT * FROM `tblsleeps` WHERE `sleep_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'gs')
        {
            $sql = "SELECT * FROM `tblgeneralstressors` WHERE `gs_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'wae')
        {
            $sql = "SELECT * FROM `tblworkandenvironments` WHERE `wae_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'mc')
        {
            $sql = "SELECT * FROM `tblmycommunications` WHERE `mc_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'mr')
        {
            $sql = "SELECT * FROM `tblmyrelations` WHERE `mr_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        elseif($type == 'mle')
        {
            $sql = "SELECT * FROM `tblmajorlifeevents` WHERE `mle_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        else 
        {
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bms_id."' ";
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                    $return = true;
            }
        }
        //echo '<br>'.$sql;
        
	
        
		
	return $return;
}

function chkActivityItemExists($activity_id)
{
	global $link;
	$return = false;
	
	if($activity_id == '9999999999')
	{
		$return = true;
	}
	else
	{
		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."' ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$return = true;
		}
	}	
	return $return;
}

function getFoodVegNonVegOfUser($user_id)
{
	global $link;
	$food_veg_nonveg = '';
	$beef = '0';
	$pork = '0';
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$food_veg_nonveg = stripslashes($row['food_veg_nonveg']);
		$beef = stripslashes($row['beef']);
		$pork = stripslashes($row['pork']);
	}
	return array($food_veg_nonveg,$beef,$pork);
}

function getMealsAutoList($user_id) 
{
	global $link;
	$data = array();
	
	$veg_str = '';
	list($food_veg_nonveg,$beef,$pork) = getFoodVegNonVegOfUser($user_id);
	if($food_veg_nonveg == 'V')
	{
		$veg_str = " WHERE `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'E' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";
	}
	elseif($food_veg_nonveg == 'VE')
	{
		$veg_str = " WHERE `food_veg_nonveg` != 'NV' AND `food_veg_nonveg` != 'B' AND `food_veg_nonveg` != 'P' ";
	}
	else
	{
		if($beef == '0')
		{

			$veg_str = " WHERE `food_veg_nonveg` != 'B' ";
			if($pork == '0')
			{
				$veg_str .= " AND `food_veg_nonveg` != 'P' ";
			}
		}
		else
		{
			if($pork == '0')
			{
				$veg_str = " WHERE `food_veg_nonveg` != 'P' ";
			}	
		}	
	}
	
	
	
	$sql = "SELECT * FROM `tbldailymeals` ".$veg_str." ORDER BY `meal_item` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$json = array();
			$json['value'] = $row['meal_id'];
			$json['name'] = stripslashes($row['meal_item']);
			$data[] = $json;
		}
		$json['value'] = '9999999999';
		$json['name'] = 'Others';
		$data[] = $json;
		return json_encode($data);
	}	
}

function getActivityAutoList() 
{
	global $link;
	$data = array();
	$sql = "SELECT * FROM `tbldailyactivity` ORDER BY `activity` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$json = array();
			$json['value'] = $row['activity_id'];
			$json['name'] = stripslashes($row['activity']);
			$data[] = $json;
		}
		$json['value'] = '9999999999';
		$json['name'] = 'Others';
		$data[] = $json;
		return json_encode($data);
	}	
}

function getBESAutoList() 
{
	global $link;
	$data = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bmst_id` = '2' AND `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$json = array();
			$json['value'] = $row['bms_id'];
			$json['name'] = stripslashes($row['bms_name']);
			$data[] = $json;
		}
		//$json['value'] = '9999999999';
		//$json['name'] = 'Others';
		$data[] = $json;
		return json_encode($data);
	}	
}

function getAllBMSAutoList() 
{
	global $link;
	$data = array();
	$sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$json = array();
			$json['value'] = $row['bms_id'];
			$json['name'] = stripslashes($row['bms_name']);
			$data[] = $json;
		}
		//$json['value'] = '9999999999';
		//$json['name'] = 'Others';
		$data[] = $json;
		return json_encode($data);
	}	
}

function getAllBMSTriggersAutoList($user_id,$date) 
{
	global $link;
	$data = array();
	
        $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status` = '1' AND `bms_deleted` = '0' ORDER BY `bms_name` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                    $json = array();
                    $json['value'] = 'bms_'.$row['bms_id'];
                    $json['name'] = stripslashes($row['bms_name']);
                    $data[] = $json;
            }
            //$json['value'] = '9999999999';
            //$json['name'] = 'Others';
            //$data[] = $json;
            
	}
        
        if($date == '')
        {
            $date = date('Y-m-d');
        }
        
        $today_day = date('j',strtotime($date));
	$today_date = date('Y-m-d',strtotime($date));
        
        $str_pro_user_id = getUsersAcceptedAdviserIds($user_id);
        if($str_pro_user_id == '')
        {
            $sql_str_pro = " AND ( `practitioner_id` = '0' ) ";
        }
        else
        {
            $sql_str_pro = " AND ( `practitioner_id` IN('0,".$str_pro_user_id."') ) ";
        }
        
        $sql = "SELECT * FROM `tbladdictions` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'adct_'.$row['adct_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblsleeps` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'sleep_'.$row['sleep_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblgeneralstressors` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'gs_'.$row['gs_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblworkandenvironments` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'wae_'.$row['wae_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblmycommunications` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'mc_'.$row['mc_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblmyrelations` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'mr_'.$row['mr_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        $sql = "SELECT * FROM `tblmajorlifeevents` WHERE ( (`listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', days_of_month) ) OR (`listing_date_type` = 'single_date' AND `single_date` = '".$today_date."') OR (`listing_date_type` = 'date_range' AND `start_date` <= '".$today_date."' AND `end_date` >= '".$today_date."') ) AND ( `status` = '1' ) ".$sql_str_pro." ORDER BY `situation` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while ($row = mysql_fetch_assoc($result)) 
            {
                $json = array();
                $json['value'] = 'mle_'.$row['mle_id'];
                $json['name'] = stripslashes($row['situation']);
                $data[] = $json;
            }
        }
        
        return json_encode($data);
}

function getUsersBESDetails($user_id,$bes_date)
{
	global $link;
	
	$bms_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array();
        $bes_time_arr = array();
        $bes_duration_arr = array();
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        $sql = "SELECT * FROM `tblusersbes` WHERE `user_id` = '".$user_id."' AND `bes_date` = '".$bes_date."' AND `bes_old_data` = '0' ".$sql_str_pro." ORDER BY `user_bes_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($bms_id_arr , $row['bms_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($bes_time_arr , stripslashes($row['bes_time']));
                        array_push($bes_duration_arr , stripslashes($row['bes_duration']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($bms_id_arr,$scale_arr,$remarks_arr,$bes_time_arr,$bes_duration_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersMDTDetails($user_id,$mdt_date)
{
    global $link;

    $arr_records = array();

    $sql = "SELECT DISTINCT `mdt_time`, `mdt_duration` FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `mdt_date` = '".$mdt_date."' AND `mdt_old_data` = '0' ORDER BY `mdt_add_date` DESC";
    //echo "<br>Testkk sql = ".$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
            $mdt_time = stripslashes($row['mdt_time']);
            $mdt_duration = stripslashes($row['mdt_duration']);
            $mdt_time_duration = $mdt_time.'_'.$mdt_duration;
            $sql2 = "SELECT * FROM `tblusersmdt` WHERE `user_id` = '".$user_id."' AND `mdt_date` = '".$mdt_date."' AND `mdt_time` = '".$mdt_time."' AND `mdt_duration` = '".$mdt_duration."' AND `mdt_old_data` = '0' ORDER BY `mdt_add_date` DESC";
            //echo "<br>Testkk sql2 = ".$sql2;
            $result2 = mysql_query($sql2,$link);
            if( ($result2) && (mysql_num_rows($result2) > 0) )
            {
                $j = 0;
                while($row2 = mysql_fetch_array($result2))
                {
                    $arr_records[$i][$mdt_time_duration][$j]['user_mdt_id'] = stripslashes($row2['user_mdt_id']);
                    $arr_records[$i][$mdt_time_duration][$j]['bms_id'] = stripslashes($row2['bms_id']);
                    $arr_records[$i][$mdt_time_duration][$j]['bms_type'] = stripslashes($row2['bms_type']);
                    $arr_records[$i][$mdt_time_duration][$j]['bms_entry_type'] = stripslashes($row2['bms_entry_type']);
                    $arr_records[$i][$mdt_time_duration][$j]['scale'] = stripslashes($row2['scale']);
                    $arr_records[$i][$mdt_time_duration][$j]['remarks'] = stripslashes($row2['remarks']);
                    $j++;
                }
                $i++;
            }   
            
        }	
    }
    return $arr_records;

}

function getPreFillList($prefill_id) 
{
	if( ($prefill_id == '') || ($prefill_id == '{}') )
	{
		$output = '{}';
	}
	else
	{
		$output = $prefill_id;
	}
	return $output;
}

function getMealMeasure($meal_id)
{
	global $link;
	$meal_measure = '';
	
	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$meal_measure = $row['meal_measure'];
	}
	return $meal_measure;
}

function addUsersDailyMeal($user_id,$meal_date,$breakfast_time,$breakfast_item_id_arr,$breakfast_other_item_arr,$breakfast_meal_like_arr,$breakfast_quantity_arr,$breakfast_measure_arr,$breakfast_consultant_remark_arr,$brunch_time,$brunch_item_id_arr,$brunch_other_item_arr,$brunch_meal_like_arr,$brunch_quantity_arr,$brunch_measure_arr,$brunch_consultant_remark_arr,$lunch_time,$lunch_item_id_arr,$lunch_other_item_arr,$lunch_meal_like_arr,$lunch_quantity_arr,$lunch_measure_arr,$lunch_consultant_remark_arr,$snacks_time,$snacks_item_id_arr,$snacks_other_item_arr,$snacks_meal_like_arr,$snacks_quantity_arr,$snacks_measure_arr,$snacks_consultant_remark_arr,$dinner_time,$dinner_item_id_arr,$dinner_other_item_arr,$dinner_meal_like_arr,$dinner_quantity_arr,$dinner_measure_arr,$dinner_consultant_remark_arr)
{
	global $link;
	$return = false;
	
	
	$sql = "DELETE FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND  `meal_date` = '".$meal_date."'";
	$result = mysql_query($sql,$link);
		
	for($i=0;$i<count($breakfast_item_id_arr);$i++)
	{
		$meal_type = 'breakfast';
		if($breakfast_time != '')
		{
			$sql = "INSERT INTO `tblusersmeals` (`user_id`,`meal_date`,`meal_time`,`meal_id`,`meal_others`,`meal_like`,`meal_quantity`,`meal_measure`,`meal_consultant_remark`,`meal_type`) VALUES ('".$user_id."','".$meal_date."','".$breakfast_time."','".$breakfast_item_id_arr[$i]."','".addslashes($breakfast_other_item_arr[$i])."','".$breakfast_meal_like_arr[$i]."','".$breakfast_quantity_arr[$i]."','".$breakfast_measure_arr[$i]."','".addslashes($breakfast_consultant_remark_arr[$i])."','".$meal_type."')";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}
	
	for($i=0;$i<count($brunch_item_id_arr);$i++)
	{
		$meal_type = 'brunch';
		if($brunch_time != '')
		{
			$sql = "INSERT INTO `tblusersmeals` (`user_id`,`meal_date`,`meal_time`,`meal_id`,`meal_others`,`meal_like`,`meal_quantity`,`meal_measure`,`meal_consultant_remark`,`meal_type`) VALUES ('".$user_id."','".$meal_date."','".$brunch_time."','".$brunch_item_id_arr[$i]."','".addslashes($brunch_other_item_arr[$i])."','".$brunch_meal_like_arr[$i]."','".$brunch_quantity_arr[$i]."','".$brunch_measure_arr[$i]."','".addslashes($brunch_consultant_remark_arr[$i])."','".$meal_type."')";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}
	
	for($i=0;$i<count($lunch_item_id_arr);$i++)
	{
		$meal_type = 'lunch';
		if($lunch_time != '')
		{
			$sql = "INSERT INTO `tblusersmeals` (`user_id`,`meal_date`,`meal_time`,`meal_id`,`meal_others`,`meal_like`,`meal_quantity`,`meal_measure`,`meal_consultant_remark`,`meal_type`) VALUES ('".$user_id."','".$meal_date."','".$lunch_time."','".$lunch_item_id_arr[$i]."','".addslashes($lunch_other_item_arr[$i])."','".$lunch_meal_like_arr[$i]."','".$lunch_quantity_arr[$i]."','".$lunch_measure_arr[$i]."','".addslashes($lunch_consultant_remark_arr[$i])."','".$meal_type."')";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}
	
	for($i=0;$i<count($snacks_item_id_arr);$i++)
	{
		$meal_type = 'snacks';
		if($snacks_time != '')
		{
			$sql = "INSERT INTO `tblusersmeals` (`user_id`,`meal_date`,`meal_time`,`meal_id`,`meal_others`,`meal_like`,`meal_quantity`,`meal_measure`,`meal_consultant_remark`,`meal_type`) VALUES ('".$user_id."','".$meal_date."','".$snacks_time."','".$snacks_item_id_arr[$i]."','".addslashes($snacks_other_item_arr[$i])."','".$snacks_meal_like_arr[$i]."','".$snacks_quantity_arr[$i]."','".$snacks_measure_arr[$i]."','".addslashes($snacks_consultant_remark_arr[$i])."','".$meal_type."')";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}
	
	for($i=0;$i<count($dinner_item_id_arr);$i++)
	{
		$meal_type = 'dinner';
		if($dinner_time != '')
		{
			$sql = "INSERT INTO `tblusersmeals` (`user_id`,`meal_date`,`meal_time`,`meal_id`,`meal_others`,`meal_like`,`meal_quantity`,`meal_measure`,`meal_consultant_remark`,`meal_type`) VALUES ('".$user_id."','".$meal_date."','".$dinner_time."','".$dinner_item_id_arr[$i]."','".addslashes($dinner_other_item_arr[$i])."','".$dinner_meal_like_arr[$i]."','".$dinner_quantity_arr[$i]."','".$dinner_measure_arr[$i]."','".addslashes($dinner_consultant_remark_arr[$i])."','".$meal_type."')";
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}
	
	return $return;
}

function getBobyMainSymptomName($bms_id)
{
    global $link;
    $bms_name = '';

    $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bms_id."' ";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $bms_name = stripslashes($row['bms_name']);
    }

    return $bms_name;
}

function getBobyMainSymptomType($bms_id)
{
    global $link;
    $bmst_id = '';

    $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_id` = '".$bms_id."' ";
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $row = mysql_fetch_array($result);
        $bmst_id = stripslashes($row['bmst_id']);
    }

    return $bmst_id;
}

function getDailyActivityName($activity_id)
{
	global $link;
	$activity = '';
	
	if($activity_id == '9999999999')
	{
		$activity = 'Others';
	}
	else
	{		
		$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."' ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$activity = stripslashes($row['activity']);
		}
	}
	return $activity;
}

function getDailyMealName($meal_id)
{
	global $link;
	$meal_item = '';
	
	if($meal_id == '9999999999')
	{
		$meal_item = 'Others';
	}
	else
	{	
		$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			$row = mysql_fetch_array($result);
			$meal_item = stripslashes($row['meal_item']);
		}
	}	
	return $meal_item;
}

function getCalPerMinOfActivity($activity_id)
{
	global $link;
	$activity_cal_kg_min = 0;
		
	$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."' ";
	//echo "<br>Testkk: ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$activity_cal_kg_min = stripslashes($row['activity_cal_kg_min']);
	}
	return $activity_cal_kg_min;
}

function getWeightOfUser($user_id)
{
	global $link;
	$weight = 0;
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$weight = stripslashes($row['weight']);
	}
	return $weight;
}

function getHeightIdOfUser($user_id)
{
	global $link;
	$height = 0;
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";

	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$height = stripslashes($row['height']);
	}
	return $height;
}

function getHeightOfUser($user_id)
{
	global $link;
	$height = 0;
	$height_id = getHeightIdOfUser($user_id);
		
	$sql = "SELECT * FROM `tblheights` WHERE `height_id` = '".$height_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$height = stripslashes($row['height_cms']);
	}
	return $height;
}

function getHeightValueInCms($height_id)
{
	global $link;
	$height = 0;
		
	$sql = "SELECT * FROM `tblheights` WHERE `height_id` = '".$height_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$height = stripslashes($row['height_cms']);
	}
	return $height;
}


function getSexOfUser($user_id)
{
	global $link;
	$sex = 'Male';
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$sex = stripslashes($row['sex']);
	}
	return $sex;
}

function convertDobToAge($dob)
{
    // See http://php.net/date for what the first arguments mean.
    $iDiffYear  = date('Y') - date('Y', strtotime($dob));
    $iDiffMonth = date('n') - date('n', strtotime($dob));
    $iDiffDay   = date('j') - date('j', strtotime($dob));
    
    // If birthday has not happen yet for this year, subtract 1.
    if ($iDiffMonth < 0 || ($iDiffMonth == 0 && $iDiffDay < 0))
    {
        $iDiffYear--;
    }
        
    return $iDiffYear;
}  

function getDOBOfUser($user_id)
{
	global $link;
	$dob = '0000-00-00';
		
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$dob = stripslashes($row['dob']);
	}
	return $dob;
}


function getConsumedCalOfActivity($user_id,$mins,$activity_id)
{
	$cal_val = 0.00;
	
	$weight = getWeightOfUser($user_id);
	$activity_cal_kg_min = getCalPerMinOfActivity($activity_id);
	$cal_val = round($weight * $mins * $activity_cal_kg_min);
	
	return $cal_val;
}

function getCalorieOfMeal($meal_id)
{
	global $link;
	$cal = 0;
		
	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$cal = $row['calories'];
	}
	
	if($cal == '')
	{
		$cal = 0;
	}
	
	return $cal;
}

function getCalorieIntakeOfMeal($meal_id,$meal_quantity)
{
	$cal_intake_val = 0.00;
	
	$cal = getCalorieOfMeal($meal_id);
	
	$cal_intake_val = $meal_quantity * $cal;
	
	return $cal_intake_val;
}

function getWeightOfMeal($meal_id)
{
	global $link;
	$weight = 0;
		
	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$weight = $row['weight'];
	}
	
	if($weight == '')
	{
		$weight = 0;
	}
	
	return $weight;
}

function getTotalFieldValueOfMeal($meal_id,$meal_quantity,$field)
{
	global $link;
	$field_val = 0;
	$total = 0.00;
		
	$sql = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$meal_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$field_val = $row[$field];
	}
	
	if($field_val == '')
	{
		$field_val = 0;
	}
	
	$total = $meal_quantity * $field_val;
	
	return $total;
}

function getBMROfUser($user_id)
{
	global $link;
	$bmr = 0;
	
	$weight = getWeightOfUser($user_id);
	$height = getHeightOfUser($user_id);
	$sex = getSexOfUser($user_id);
	$dob = getDOBOfUser($user_id);
	$age = convertDobToAge($dob);
	
	if($sex == 'Female')
	{
		$bmr = 665 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
	}
	else
	{
		$bmr = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
	}
	
	return $bmr;
}

function getALCOfActivity($activity_id)
{
	global $link;
	$activity_level_code = 'SA';
		
	$sql = "SELECT * FROM `tbldailyactivity` WHERE `activity_id` = '".$activity_id."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$activity_level_code = $row['activity_level_code'];
	}
	
	return $activity_level_code;
}

function getALMValue($activity_level_code)
{
	global $link;
	$activity_level_multiplier = 1.2;
		
	$sql = "SELECT * FROM `tblactivitymultiplier` WHERE `activity_level_code` = '".$activity_level_code."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$activity_level_multiplier = $row['activity_level_multiplier'];
	}
	
	return $activity_level_multiplier;
}

function getALMOfUser($user_id,$activity_date)
{
	global $link;
	$activity_level_multiplier = 1.2;
	$total_la_cal_val = 0;
	$total_ma_cal_val = 0;
	$total_va_cal_val = 0;
	$total_sua_cal_val = 0;
	$total_sa_cal_val = 0;
	
	$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$activity_date."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$cal_val = 0;
			$activity_level_code = 'SA';
			$temp_activity_id = $row['activity_id'];
			$temp_mins = $row['mins'];
			if( ($temp_activity_id != '') && ($temp_activity_id != '0') && ($temp_activity_id != '9999999999') )
			{
				$cal_val = 0 + getConsumedCalOfActivity($user_id,$temp_mins,$temp_activity_id);
				$activity_level_code = getALCOfActivity($temp_activity_id);	
			}
			
			if($activity_level_code == 'LA')
			{
				$total_la_cal_val = $total_la_cal_val + $cal_val;
			}
			elseif($activity_level_code == 'MA')
			{
				$total_ma_cal_val = $total_ma_cal_val + $cal_val;
			}
			elseif($activity_level_code == 'VA')
			{
				$total_va_cal_val = $total_va_cal_val + $cal_val;
			}
			elseif($activity_level_code == 'SUA')
			{
				$total_sua_cal_val = $total_sua_cal_val + $cal_val;
			}
			else
			{
				$total_sa_cal_val = $total_sa_cal_val + $cal_val;
			}
		}
		
		$max_val = max($total_sa_cal_val,$total_la_cal_val,$total_ma_cal_val,$total_va_cal_val,$total_sua_cal_val);	
		
		if($max_val == $total_sa_cal_val)
		{
			$activity_level_code = 'SA';
		}
		elseif($max_val == $total_la_cal_val)
		{
			$activity_level_code = 'LA';
		}
		elseif($max_val == $total_ma_cal_val)
		{
			$activity_level_code = 'MA';
		}
		elseif($max_val == $total_va_cal_val)
		{
			$activity_level_code = 'VA';
		}
		else
		{
			$activity_level_code = 'SUA';
		}
		
		$activity_level_multiplier = getALMValue($activity_level_code);
	}
	
	return $activity_level_multiplier;
}

function getEstimatedCalorieRequired($user_id,$activity_date)
{
	global $link;
	$cal_req = 0;
		
	$bmr = getBMROfUser($user_id);
	$activity_level_multiplier = getALMOfUser($user_id,$activity_date);
	$cal_req = round($bmr * $activity_level_multiplier);
	
	return $cal_req;
}

function getIdealBodyWeightRange($user_id)
{
	global $link;
	$weight_kg = 0;
	
	$height = getHeightIdOfUser($user_id);
	$sex = getSexOfUser($user_id);
	
	$sql = "SELECT * FROM `tblheightweightratio` WHERE `sex` = '".$sex."' AND `height_id` = '".$height."' ";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$weight_kg = $row['weight_kg'];
	}
	
	return $weight_kg;
}

function getBMIOfUser($user_id)
{
	global $link;
	$bmi = 0;
	
	$height = getHeightOfUser($user_id);
	$weight = getWeightOfUser($user_id);
	$sex = getSexOfUser($user_id);
	
	$height_sqr = $height / 100;
	$height_sqr = $height_sqr * $height_sqr;
	$bmi = round($weight / $height_sqr,1) ;
		
	return $bmi;
}

function getMonthlyActivitiesCaloriesBurntChart($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$arr_date = array();
	$arr_activity_id = array();
	$arr_record_row = array();
	$arr_total_cal_val_by_date = array();

	$sql = "SELECT DISTINCT `activity_date`  FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."'  ORDER BY `activity_date` ASC LIMIT 10";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_array($result)) 
		{
			array_push($arr_date , $row['activity_date']);
		}
	}	
	
	if(count($arr_date) > 0)
	{
		$tmp_start_date = $arr_date[0];
		$tmp_end_date = $arr_date[count($arr_date) - 1];
			
			
		$sql = "SELECT DISTINCT `activity_id`  FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` >= '".$tmp_start_date."' AND `activity_date` <= '".$tmp_end_date."'  ORDER BY `activity_date` ASC ";
		$result = mysql_query($sql,$link);
		if( ($result) && (mysql_num_rows($result) > 0) )
		{
			while ($row = mysql_fetch_array($result)) 
			{
				array_push($arr_activity_id , $row['activity_id']);
			}
		}
		
		if(count($arr_activity_id) > 0)
		{
			for($i=0;$i<count($arr_activity_id);$i++)
			{
				$total_temp_consumed_cal_of_activity = 0;
				for($j=0;$j<count($arr_date);$j++)
				{
					$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_id` = '".$arr_activity_id[$i]."' AND `activity_date` = '".$arr_date[$j]."' ORDER BY `activity_date` ASC ";
					$result = mysql_query($sql,$link);
					if( ($result) && (mysql_num_rows($result) > 0) )
					{
						$return = true;
						$temp_consumed_cal_of_activity = 0;
						while ($row = mysql_fetch_array($result)) 
						{
							$temp_consumed_cal_of_activity += getConsumedCalOfActivity($user_id,$row['mins'],$arr_activity_id[$i]);
						}
						$arr_record_row[$arr_activity_id[$i]][$arr_date[$j]] = $temp_consumed_cal_of_activity;
						$total_temp_consumed_cal_of_activity += $temp_consumed_cal_of_activity;
					}
				}
				
				$arr_record_row[$arr_activity_id[$i]]['total_cal_val'] += $total_temp_consumed_cal_of_activity; 
			}
			
			for($i=0;$i<count($arr_date);$i++)
			{
				$total_temp_consumed_cal_of_activity = 0;
				$temp_consumed_cal_of_activity = 0;
				for($j=0;$j<count($arr_activity_id);$j++)
				{
					$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$arr_date[$i]."' AND `activity_id` = '".$arr_activity_id[$j]."' ORDER BY `activity_date` ASC ";
					$result = mysql_query($sql,$link);
					if( ($result) && (mysql_num_rows($result) > 0) )
					{
						while ($row = mysql_fetch_array($result)) 
						{
							$total_temp_consumed_cal_of_activity += getConsumedCalOfActivity($user_id,$row['mins'],$arr_activity_id[$j]);
						}
					}
				}
				$arr_total_cal_val_by_date[$arr_date[$i]] = $total_temp_consumed_cal_of_activity;	
			}
		}
		
		$temp_cnt = count($arr_date);
		if($temp_cnt < 10)
		{
			for($i=$temp_cnt;$i<10;$i++)
			{
				$arr_date[$i] = '';	
			}
		}
	}
	return array($return,$arr_date,$arr_record_row,$arr_total_cal_val_by_date);	
}

function getAgeOfUser($user_id)
{
	$dob = getDOBOfUser($user_id);
	$age = convertDobToAge($dob);
	return $age;
}

function getBMRObservationOfUser($user_id)
{
	global $link;
	$observation = '';
	$sex = getSexOfUser($user_id);
	$bmi = getBMIOfUser($user_id);
	
	$sql = "SELECT * FROM `tblbmrobservations` WHERE `sex` = '".$sex."' AND `bmr_from` <= '".$bmi."' AND `bmr_to` >= '".$bmi."'  ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$observation = stripslashes($row['weight_index']).' / '.stripslashes($row['risk_index']);
	}
	return $observation;
}

function getMonthlyCaloriesChart($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$arr_date = array();
	$arr_calorie_intake_date = array();
	$arr_calorie_intake = array();
	$arr_calorie_burned_date = array();
	$arr_calorie_burned = array();
	$arr_estimated_calorie_required = array();	
	$ideal_body_weight_range = getIdealBodyWeightRange($user_id);	
	$bmi = getBMIOfUser($user_id);
	$total_calorie_burned = 0;
	$total_calorie_intake = 0;
	$total_estimated_calorie_required = 0;
	$avg_workout = 0;
	
	$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ORDER BY `meal_date` ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_calorie_intake_date , $row['meal_date']);
			$temp_total_calorie_intake_one_day = 0.00;		
			
			$sql2 = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$row['meal_date']."' ORDER BY `user_meal_id` ASC ";
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				while ($row2 = mysql_fetch_assoc($result2)) 
				{
					$temp_meal_id = $row2['meal_id'];
					$temp_meal_quantity = $row2['meal_quantity'];
					$temp_total_calorie_intake_one_day += getCalorieIntakeOfMeal($temp_meal_id,$temp_meal_quantity);	
				}
			}
			$arr_calorie_intake[$row['meal_date']] = $temp_total_calorie_intake_one_day;	
			$total_calorie_intake = $total_calorie_intake + $temp_total_calorie_intake_one_day;	
		}
	}
	
	$sql3 = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ORDER BY `activity_date` ASC ";
	//echo "<br>".$sql3;
	$result3 = mysql_query($sql3,$link);
	if( ($result3) && (mysql_num_rows($result3) > 0) )
	{
		$return = true;
		while ($row3 = mysql_fetch_assoc($result3)) 
		{
			array_push($arr_calorie_burned_date , $row3['activity_date']);
			$temp_total_calorie_burned_one_day = 0.00;		
			
			$sql4 = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$row3['activity_date']."' ORDER BY `user_activity_id` ASC ";
			//echo "<br>".$sql4;
			$result4 = mysql_query($sql4,$link);
			if( ($result4) && (mysql_num_rows($result4) > 0) )
			{
				while ($row4 = mysql_fetch_assoc($result4)) 
				{
					$temp_activity_id = $row4['activity_id'];
					$temp_mins = $row4['mins'];
					$temp_total_calorie_burned_one_day += getConsumedCalOfActivity($user_id,$temp_mins,$temp_activity_id);	
				}
			}
			$arr_calorie_burned[$row3['activity_date']] = $temp_total_calorie_burned_one_day;
			$total_calorie_burned = $total_calorie_burned + $temp_total_calorie_burned_one_day;	
			
			$arr_estimated_calorie_required[$row3['activity_date']] = getEstimatedCalorieRequired($user_id,$row3['activity_date']);	
			$total_estimated_calorie_required = $total_estimated_calorie_required + $arr_estimated_calorie_required[$row3['activity_date']];	
		}
	}
	
	$arr_date = array_merge($arr_calorie_intake_date,$arr_calorie_burned_date);
	$arr_date = array_unique($arr_date);
	sort($arr_date);
	$arr_date = array_values($arr_date);
	$temp_cnt = count($arr_date);
	for($i=$temp_cnt;$i<10;$i++)
	{
		$arr_date[$i] = '';	
	}
	
	$avg_workout = round($total_calorie_burned / $temp_cnt);
	
	return array($return,$arr_date,$arr_calorie_intake_date,$arr_calorie_intake,$arr_calorie_burned_date,$arr_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$ideal_body_weight_range,$bmi,$total_calorie_intake,$total_calorie_burned,$total_estimated_calorie_required);	
}

function getDailyFoodConstituentsIntakeChart($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$arr_date = array();
	$arr_weight = array();
	$arr_water = array();
	$arr_calories = array();
	$arr_protein = array();
	$arr_total_fat = array();
	$arr_saturated = array();
	$arr_monounsaturated = array();
	$arr_polyunsaturated = array();
	$arr_cholesterol = array();
	$arr_carbohydrate = array();
	$arr_total_dietary_fiber = array();
	$arr_calcium = array();
	$arr_iron = array();
	$arr_potassium = array();
	$arr_sodium = array();
	$arr_thiamin = array();
	$arr_riboflavin = array();
	$arr_niacin = array();
	$arr_ascorbic_acid = array();
	$arr_sugar = array();
	
	$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ORDER BY `meal_date` ASC ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_date , $row['meal_date']);
			$temp_total_weight = 0.00;		
			$temp_total_calories = 0.00;	
			$temp_total_protein = 0.00;	
			$temp_total_total_fat = 0.00;	
			$temp_total_saturated = 0.00;	
			$temp_total_monounsaturated = 0.00;	
			$temp_total_polyunsaturated = 0.00;	
			$temp_total_cholesterol = 0.00;	
			$temp_total_carbohydrate = 0.00;	
			$temp_total_total_dietary_fiber = 0.00;	
			$temp_total_calcium = 0.00;	
			$temp_total_iron = 0.00;	
			$temp_total_potassium = 0.00;	
			$temp_total_sodium = 0.00;	
			$temp_total_thiamin = 0.00;	
			$temp_total_riboflavin = 0.00;	
			$temp_total_niacin = 0.00;	
			$temp_total_ascorbic_acid = 0.00;	
			$temp_total_sugar = 0.00;	
			
			$sql2 = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$row['meal_date']."' ORDER BY `user_meal_id` ASC ";
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				while ($row2 = mysql_fetch_assoc($result2)) 
				{
					$temp_meal_id = $row2['meal_id'];
					$temp_meal_quantity = $row2['meal_quantity'];
					
					$sql3 = "SELECT * FROM `tbldailymeals` WHERE `meal_id` = '".$temp_meal_id."' ";
					$result3 = mysql_query($sql3,$link);
					if( ($result3) && (mysql_num_rows($result3) > 0) )
					{
						$row3 = mysql_fetch_array($result3);
						$temp_total_weight += $temp_meal_quantity * ( ($row3['weight'] == '') ? 0 : $row3['weight']);
						$temp_total_calories += $temp_meal_quantity * ( ($row3['calories'] == '') ? 0 : $row3['calories']);
						$temp_total_protein += $temp_meal_quantity * ( ($row3['protein'] == '') ? 0 : $row3['protein']);
						$temp_total_total_fat += $temp_meal_quantity * ( ($row3['total_fat'] == '') ? 0 : $row3['total_fat']);
						$temp_total_saturated += $temp_meal_quantity * ( ($row3['saturated'] == '') ? 0 : $row3['saturated']);
						$temp_total_monounsaturated += $temp_meal_quantity * ( ($row3['monounsaturated'] == '') ? 0 : $row3['monounsaturated']);
						$temp_total_polyunsaturated += $temp_meal_quantity * ( ($row3['polyunsaturated'] == '') ? 0 : $row3['polyunsaturated']);
						$temp_total_cholesterol += $temp_meal_quantity * ( ($row3['cholesterol'] == '') ? 0 : $row3['cholesterol']);
						$temp_total_carbohydrate += $temp_meal_quantity * ( ($row3['carbohydrate'] == '') ? 0 : $row3['carbohydrate']);
						$temp_total_total_dietary_fiber += $temp_meal_quantity * ( ($row3['total_dietary_fiber'] == '') ? 0 : $row3['total_dietary_fiber']);
						$temp_total_calcium += $temp_meal_quantity * ( ($row3['calcium'] == '') ? 0 : $row3['calcium']);
						$temp_total_iron += $temp_meal_quantity * ( ($row3['iron'] == '') ? 0 : $row3['iron']);
						$temp_total_potassium += $temp_meal_quantity * ( ($row3['potassium'] == '') ? 0 : $row3['potassium']);
						$temp_total_sodium += $temp_meal_quantity * ( ($row3['sodium'] == '') ? 0 : $row3['sodium']);
						$temp_total_thiamin += $temp_meal_quantity * ( ($row3['thiamin'] == '') ? 0 : $row3['thiamin']);
						$temp_total_riboflavin += $temp_meal_quantity * ( ($row3['riboflavin'] == '') ? 0 : $row3['riboflavin']);
						$temp_total_niacin += $temp_meal_quantity * ( ($row3['niacin'] == '') ? 0 : $row3['niacin']);
						$temp_total_ascorbic_acid += $temp_meal_quantity * ( ($row3['ascorbic_acid'] == '') ? 0 : $row3['ascorbic_acid']);
						$temp_total_sugar += $temp_meal_quantity * ( ($row3['sugar'] == '') ? 0 : $row3['sugar']);
					}
				}
			}
			$arr_weight[$row['meal_date']] = $temp_total_weight;
			$arr_calories[$row['meal_date']] = $temp_total_calories;	
			$arr_protein[$row['meal_date']] = $temp_total_protein;	
			$arr_total_fat[$row['meal_date']] = $temp_total_total_fat;	
			$arr_saturated[$row['meal_date']] = $temp_total_saturated;	
			$arr_monounsaturated[$row['meal_date']] = $temp_total_monounsaturated;	
			$arr_polyunsaturated[$row['meal_date']] = $temp_total_polyunsaturated;	
			$arr_cholesterol[$row['meal_date']] = $temp_total_cholesterol;	
			$arr_carbohydrate[$row['meal_date']] = $temp_total_carbohydrate;	
			$arr_total_dietary_fiber[$row['meal_date']] = $temp_total_total_dietary_fiber;	
			$arr_calcium[$row['meal_date']] = $temp_total_calcium;	
			$arr_iron[$row['meal_date']] = $temp_total_iron;	
			$arr_potassium[$row['meal_date']] = $temp_total_potassium;	
			$arr_sodium[$row['meal_date']] = $temp_total_sodium;	
			$arr_thiamin[$row['meal_date']] = $temp_total_thiamin;	
			$arr_riboflavin[$row['meal_date']] = $temp_total_riboflavin;	
			$arr_niacin[$row['meal_date']] = $temp_total_niacin;	
			$arr_ascorbic_acid[$row['meal_date']] = $temp_total_ascorbic_acid;	
			$arr_sugar[$row['meal_date']] = $temp_total_sugar;	
		}
	}
		
	return array($return,$arr_date,$arr_weight,$arr_water,$arr_calories,$arr_protein,$arr_total_fat,$arr_saturated,$arr_monounsaturated,$arr_polyunsaturated,$arr_cholesterol,$arr_carbohydrate,$arr_total_dietary_fiber,$arr_calcium,$arr_iron,$arr_potassium,$arr_sodium,$arr_thiamin,$arr_riboflavin,$arr_niacin,$arr_ascorbic_acid,$arr_sugar);	
}

function getTotalNoOfActivityEntry($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0',$scale_range = '',$start_scale_value = '',$end_scale_value = '',$report_module = '',$module_keyword = '',$module_criteria = '',$criteria_scale_range = '',$start_criteria_scale_value = '',$end_criteria_scale_value = '') 
{
	global $link;
	$total_activity_entry = 0;
        
        if($module_keyword != '')
        {
            $sql_str_report_module = " AND `activity_id` = '".$module_keyword."' ";
        }
        else
        {
            $sql_str_report_module = '';
        }
        
        if($module_criteria == '4')
        {
            if($criteria_scale_range == '1')
            {
                $sql_str_report_module_criteria = " AND `activity_time` < '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '2')
            {
                $sql_str_report_module_criteria = " AND `activity_time` > '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '3')
            {
                $sql_str_report_module_criteria = " AND `activity_time` <= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '4')
            {
                $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '5')
            {
                $sql_str_report_module_criteria = " AND `activity_time` = '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '6')
            {
                $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' AND `activity_time` <= '".$end_criteria_scale_value."'";
            }
            else
            {
                $sql_str_report_module_criteria = "";
            }
        }
        elseif($module_criteria == '3')
        {
            if($criteria_scale_range == '1')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) < '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '2')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) > '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '3')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) <= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '4')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '5')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) = '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '6')
            {
                $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`mins` AS SIGNED) <= '".$end_criteria_scale_value."'";
            }
            else
            {
                $sql_str_report_module_criteria = "";
            }
        }
        elseif($module_criteria == '7')
        {
            if($criteria_scale_range == '5')
            {
                $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) = '".$start_criteria_scale_value."' ";
            }
            elseif($criteria_scale_range == '6')
            {
                $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(activity_date) <= '".$end_criteria_scale_value."' ";
            }
            else
            {
                $sql_str_report_module_criteria = "";
            }
        }
        else
        {
            $sql_str_report_module_criteria = "";
        }
	
	$sql = "SELECT count(user_activity_id) AS total FROM `tblusersdailyactivity` WHERE "
                . "`user_id` = '".$user_id."' AND "
                . "`activity_date` >= '".$start_date."' AND "
                . "`activity_date` <= '".$end_date."' AND "
                . "`activity_id` != '0' AND `activity_id` != '9999999999' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY `activity_date` ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_assoc($result); 
            $total_activity_entry = $row['total'];
	}
	
	return $total_activity_entry;
}

function getTotalNoOfMealEntry($user_id,$start_date,$end_date) 
{
	global $link;
	$total_meal_entry = 0;
	
	$sql = "SELECT count(user_meal_id) AS total FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ORDER BY `meal_date` ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result); 
		$total_meal_entry = $row['total'];
	}
	
	return $total_meal_entry;
}

function getAllNutrients()
{
	global $link;
	$arr_nid = array();
	$arr_food_constituents = array();
	$arr_meal_food_constituents = array();
	$sql = "SELECT * FROM `tblnutrients` ORDER BY nid ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_assoc($result))
		{
			array_push($arr_nid,$row['nid']);
			array_push($arr_food_constituents,stripslashes($row['food_constituent']));
			array_push($arr_meal_food_constituents,stripslashes($row['meal_food_constituents']));
		}
	}
	return array($arr_nid,$arr_food_constituents,$arr_meal_food_constituents);
}

function getNutrientKeyValue($sex,$age)
{
	$key = '';
	if($sex == 'Female')
	{
		if( ($age >= 1) && ($age <= 3) )
		{
			$key = 'childern_1_3_years';
		}
		elseif( ($age >= 4) && ($age <= 8) )
		{
			$key = 'childern_4_8_years';
		}
		elseif( ($age >= 9) && ($age <= 13) )
		{
			$key = 'female_9_13_years';
		}
		elseif( ($age >= 14) && ($age <= 18) )
		{
			$key = 'female_14_18_years';
		}
		elseif( ($age >= 19) && ($age <= 30) )
		{
			$key = 'female_19_30_years';
		}
		elseif( ($age >= 31) && ($age <= 50) )
		{
			$key = 'female_31_50_years';
		}
		elseif( ($age >= 51) && ($age <= 70) )
		{
			$key = 'female_51_70_years';
		}
		else
		{
			$key = 'female_71_100_years';
		}
	}
	else
	{
		if( ($age >= 1) && ($age <= 3) )
		{
			$key = 'childern_1_3_years';
		}
		elseif( ($age >= 4) && ($age <= 8) )
		{
			$key = 'childern_4_8_years';
		}
		elseif( ($age >= 9) && ($age <= 13) )
		{
			$key = 'males_9_13_years';
		}
		elseif( ($age >= 14) && ($age <= 18) )
		{
			$key = 'males_14_18_years';
		}
		elseif( ($age >= 19) && ($age <= 30) )
		{
			$key = 'males_19_30_years';
		}
		elseif( ($age >= 31) && ($age <= 50) )
		{
			$key = 'males_31_50_years';
		}
		elseif( ($age >= 51) && ($age <= 70) )
		{
			$key = 'males_51_70_years';
		}
		else
		{
			$key = 'males_71_100_years';
		}
	}
	return $key;
}

function getNSRValue($sex,$age,$nid)
{
	global $link;
	$ret_val = 0;	
	$key = getNutrientKeyValue($sex,$age);
		
	$sql = "SELECT * FROM `tblnutrientstdreq` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$ret_val = stripslashes($row[$key]);
		if( ($ret_val == '') || ($ret_val == 'ND') )
		{
			$ret_val = 0;
		}
	}
	return $ret_val;
}

function getNARValue($sex,$age,$nid)
{
	global $link;
	$ret_val = 0;		
	$key = getNutrientKeyValue($sex,$age);
	
	$sql = "SELECT * FROM `tblnutrientavgreq` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$ret_val = stripslashes($row[$key]);
		if( ($ret_val == '') || ($ret_val == 'ND') )
		{
			$ret_val = 0;
		}
	}
	return $ret_val;
}

function getNULValue($sex,$age,$nid)
{
	global $link;
	$ret_val = 0;		
	$key = getNutrientKeyValue($sex,$age);
	
	$sql = "SELECT * FROM `tblnutrientupperlimit` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$ret_val = stripslashes($row[$key]);
		if( ($ret_val == '') || ($ret_val == 'ND') )
		{
			$ret_val = 0;
		}
	}
	return $ret_val;
}

function getNutriObservations($def_exc_avg_consumed,$def_exc_rec_consumed,$nutrientupperlimit)
{
	global $link;
	$output = '';
	if($def_exc_avg_consumed >= 0)
	{
		if($def_exc_rec_consumed >= 0)
		{
			if($def_exc_rec_consumed < $nutrientupperlimit)
			{
				$output = 'Diet is OK. To take care <strong>not to exceed Upper Limit('.$nutrientupperlimit.' Values)</strong>';
			}
			else
			{
				$output = '<strong>EXCESS</strong>. Intake of related Foods has to be reduced &amp; appropriate therapy planned to get to the normal balance.';
			}	
		}
		else
		{
			$output = 'Diet is OK. Slight modifications required to maintain the balance &amp; healthy living';
		}
	}
	else
	{
		if($def_exc_rec_consumed < 0)
		{
			$output = 'It is case of <strong>DEFICIENCY</strong>. Intake of related Food has to be increased + Supplements accordingly';
		}
	
	}
	return $output;
}

function getNutriRecommend($nid)
{
	global $link;
	$output = '';		
			
	$sql = "SELECT * FROM `tblnutrients` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = $row = mysql_fetch_assoc($result);
		$output = stripslashes($row['recommend']);
	}
	return $output;
}

function getNutriGuideline($nid)
{
	global $link;
	$output = '';		
			
	$sql = "SELECT * FROM `tblnutrients` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = $row = mysql_fetch_assoc($result);
		$output = stripslashes($row['guideline']);
	}
	return $output;
}

function getNutriBenefits($nid)
{
	global $link;
	$output = '';		
			
	$sql = "SELECT * FROM `tblnutrients` WHERE `nid` = '".$nid."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = $row = mysql_fetch_assoc($result);
		$output = stripslashes($row['benefits']);
	}
	return $output;
}

function getFoodChart($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$arr_date = array();
	$arr_records = array();
	$total_meal_entry = getTotalNoOfMealEntry($user_id,$start_date,$end_date);
	
	list($arr_nid,$arr_food_constituents,$arr_meal_food_constituents) = getAllNutrients();
	
	for($i=0;$i<count($arr_meal_food_constituents);$i++)
	{
		$temp_str = 'temp_total_'.$arr_meal_food_constituents[$i];
		$$temp_str = 0.00;
	}	
		
	
			
	$sql = "SELECT * FROM `tblusersmeals` as tum LEFT JOIN `tbldailymeals` as tdm ON tum.meal_id = tdm.meal_id WHERE tum.user_id = '".$user_id."' AND tum.meal_date >= '".$start_date."' AND tum.meal_date <= '".$end_date."' AND tum.meal_id != '0' AND tum.meal_id != '9999999999' ORDER BY tum.user_meal_id ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_date , $row['meal_date']);
			for($i=0;$i<count($arr_meal_food_constituents);$i++)
			{
				$temp_str = 'temp_total_'.$arr_meal_food_constituents[$i];
				$$temp_str += $row['meal_quantity'] * ( ($row[$arr_meal_food_constituents[$i]] == '') ? 0 : $row[$arr_meal_food_constituents[$i]]);
			}	
		}
		
		$arr_date = array_unique($arr_date);
		$arr_date = array_values($arr_date);
		$count = count($arr_date);
		
		for($i=0;$i<count($arr_meal_food_constituents);$i++)
		{
			$temp_str = 'temp_total_'.$arr_meal_food_constituents[$i];
			$arr_records[$arr_food_constituents[$i]]['avg_qty_consumed'] = 0 + $$temp_str / $count ;
		}	
	}
	
	$sex = getSexOfUser($user_id);
	$age = getAgeOfUser($user_id);
	
	for($i=0;$i<count($arr_meal_food_constituents);$i++)
	{
		$nutrientstdreq = getNSRValue($sex,$age,$arr_nid[$i]); 
		$nutrientavgreq = getNARValue($sex,$age,$arr_nid[$i]); 
		$nutrientupperlimit = getNULValue($sex,$age,$arr_nid[$i]);
		$avg_qty_consumed = $arr_records[$arr_food_constituents[$i]]['avg_qty_consumed'];
		
		$def_exc_avg_consumed = $avg_qty_consumed - $nutrientavgreq;
		$def_exc_rec_consumed = $avg_qty_consumed - $nutrientstdreq;
		
		$arr_records[$arr_food_constituents[$i]]['nutrientstdreq'] =$nutrientstdreq; 
		$arr_records[$arr_food_constituents[$i]]['nutrientavgreq'] = $nutrientavgreq; 
		$arr_records[$arr_food_constituents[$i]]['nutrientupperlimit'] = $nutrientupperlimit;  
		$arr_records[$arr_food_constituents[$i]]['def_exc_avg_consumed'] = $def_exc_avg_consumed;
		$arr_records[$arr_food_constituents[$i]]['def_exc_rec_consumed'] = $def_exc_rec_consumed; 
		$arr_records[$arr_food_constituents[$i]]['observations'] = getNutriObservations($def_exc_avg_consumed,$def_exc_rec_consumed,$nutrientupperlimit);
		$arr_records[$arr_food_constituents[$i]]['recommend'] = getNutriRecommend($arr_nid[$i]);
		$arr_records[$arr_food_constituents[$i]]['guideline'] = getNutriGuideline($arr_nid[$i]);
		$arr_records[$arr_food_constituents[$i]]['benefits'] = getNutriBenefits($arr_nid[$i]);
	}
	return array($return,$arr_date,$arr_records,$total_meal_entry);	
}

function getFoodChartHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_records,$total_meal_entry) = getFoodChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Food Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong><strong>No of days</strong></strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.count($arr_date).'</td>
							<td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_meal_entry.'</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
		$output .= '<table width="1150" height="30" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
							<tr>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Food Constituents</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Recommended Dietary Allowance Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Average Requirement Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Upper Limit Per Day</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Average Quantity consumed per day for the Period</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Deficiency / Excess of Constituents Consumed on Average basis</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Deficiency / Excess of Constituents Consumed on Recommended values</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Observations</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Recommend</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Guideline</td>
								<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Benefits</td>
							</tr>';	
							$j=1;
							foreach($arr_records as $key => $val)
							{ 
		$output .= '		<tr>
								<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$j.'</td>
								<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$key.'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientstdreq'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientavgreq'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['nutrientupperlimit'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['avg_qty_consumed'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['def_exc_avg_consumed'].'</td>
								<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['def_exc_rec_consumed'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['observations'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['recommend'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['guideline'].'</td>
								<td height="30" align="left" valign="middle" bgcolor="#FFFFFF">'.$val['benefits'].'</td>';
							
								$j++;
							}
		$output .= '					</tr>
						</table>';
						
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';				
	}
	return $output;	
}

function getMyActivityCaloriesChart($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$arr_date = array();
	$arr_calorie_intake_date = array();
	$arr_calorie_intake = array();
	$arr_calorie_burned_date = array();
	$arr_calorie_burned = array();
	$arr_estimated_calorie_required = array();	
	$ideal_body_weight_range = getIdealBodyWeightRange($user_id);	
	$bmi = getBMIOfUser($user_id);
	$total_calorie_burned = 0;
	$total_calorie_intake = 0;
	$total_estimated_calorie_required = 0;
	$avg_workout = 0;
	$arr_activity_id = array();
	
	$total_activity_entry = getTotalNoOfActivityEntry($user_id,$start_date,$end_date);
	$total_meal_entry = getTotalNoOfMealEntry($user_id,$start_date,$end_date);
	
	$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' ORDER BY `meal_date` ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_calorie_intake_date , $row['meal_date']);
		}
	}
	
	$sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ORDER BY `activity_date` ASC ";
	//echo "<br>".$sql3;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_calorie_burned_date , $row['activity_date']);
		}
	}
	
	$sql = "SELECT DISTINCT tuda.activity_id FROM `tblusersdailyactivity` AS tuda LEFT JOIN `tbldailyactivity` AS tda ON tuda.activity_id = tda.activity_id WHERE tuda.user_id = '".$user_id."' AND tuda.activity_date >= '".$start_date."' AND tuda.activity_date <= '".$end_date."' ORDER BY tda.activity ASC ";
	//echo "<br>".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
		while ($row = mysql_fetch_assoc($result)) 
		{
			array_push($arr_activity_id , $row['activity_id']);
		}
	}
	
	$arr_date = array_merge($arr_calorie_intake_date,$arr_calorie_burned_date);
	if(count($arr_date) > 0)
	{
		$arr_date = array_unique($arr_date);
		sort($arr_date);
		
		for($i=0;$i<count($arr_date);$i++)
		{		
			$sql = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$arr_date[$i]."' ORDER BY `user_meal_id` ASC ";
			//echo "<br>".$sql;
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$temp_total_calorie_intake_one_day = 0.00;	
				while ($row = mysql_fetch_assoc($result))
				{
					$temp_total_calorie_intake_one_day += getCalorieIntakeOfMeal($row['meal_id'],$row['meal_quantity']);	
				}
				$arr_calorie_intake[$arr_date[$i]] = $temp_total_calorie_intake_one_day;	
				$total_calorie_intake += $temp_total_calorie_intake_one_day;
			}
			else
			{
				$arr_calorie_intake[$arr_date[$i]] = 'NA';	
			}
			
			
			$sql2 = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$arr_date[$i]."' ORDER BY `user_activity_id` ASC ";
			//echo "<br>".$sql2;
			$result2 = mysql_query($sql2,$link);
			if( ($result2) && (mysql_num_rows($result2) > 0) )
			{
				$temp_total_calorie_burned_one_day = 0.00;	
				while ($row2 = mysql_fetch_assoc($result2))
				{
					$temp_total_calorie_burned_one_day += getConsumedCalOfActivity($user_id,$row2['mins'],$row2['activity_id']);	
				}
				
				$arr_calorie_burned[$arr_date[$i]] = $temp_total_calorie_burned_one_day;
				$total_calorie_burned += $temp_total_calorie_burned_one_day;	
				
				$arr_estimated_calorie_required[$arr_date[$i]] = getEstimatedCalorieRequired($user_id,$arr_date[$i]);	
				$total_estimated_calorie_required = $total_estimated_calorie_required + $arr_estimated_calorie_required[$arr_date[$i]];	
			}
			else
			{
				$arr_calorie_burned[$arr_date[$i]] = 'NA';	
				$arr_estimated_calorie_required[$arr_date[$i]] = 'NA';
			}
		}
		
		if(count($arr_activity_id) > 0)
		{
			for($i=0;$i<count($arr_activity_id);$i++)
			{
				$total_temp_consumed_cal_of_activity = 0;
				for($j=0;$j<count($arr_date);$j++)
				{	
					$sql6 = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_id` = '".$arr_activity_id[$i]."' AND `activity_date` = '".$arr_date[$j]."' ORDER BY `activity_date` ASC ";
					$result6 = mysql_query($sql6,$link);
					if( ($result6) && (mysql_num_rows($result6) > 0) )
					{
						$temp_consumed_cal_of_activity = 0;
						while ($row6 = mysql_fetch_assoc($result6))
						{
							$temp_consumed_cal_of_activity += getConsumedCalOfActivity($user_id,$row6['mins'],$arr_activity_id[$i]);
						}
						$arr_record_row[$arr_activity_id[$i]][$arr_date[$j]] = $temp_consumed_cal_of_activity;
						$total_temp_consumed_cal_of_activity += $temp_consumed_cal_of_activity;
					}
				}					
				$arr_record_row[$arr_activity_id[$i]]['total_cal_val'] += $total_temp_consumed_cal_of_activity; 
			}
		}
					
		if(count($arr_calorie_burned_date) > 0)
		{
			$temp_cnt = count($arr_calorie_burned_date);
			$avg_workout = round($total_calorie_burned / $temp_cnt);
		}	
		
	}	
		
	return array($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry);	
}

function getMyActivityCaloriesChartHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_calorie_intake,$total_calorie_intake,$arr_calorie_burned,$total_calorie_burned,$avg_workout,$arr_estimated_calorie_required,$total_estimated_calorie_required,$arr_record_row,$arr_activity_id,$total_activity_entry,$total_meal_entry) = getMyActivityCaloriesChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">My Activity Calories Report</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong><strong>No of days</strong></strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.count($arr_date).'</td>
							<td height="30" align="left" valign="middle"><strong>Total Activities Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_activity_entry.'</td>
							<td height="30" align="left" valign="middle"><strong>Total Meals Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_meal_entry.'</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		$output .= '<table width="1150" height="30" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1">&nbsp;</td>';
							for($i=0;$i<count($arr_activity_id);$i++)
							{ 
		$output .= '		<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getDailyActivityName($arr_activity_id[$i]).'</td>';	
							}
		$output .= '		<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Total Calories Burnt</td>
							<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Total Calories Intake</td>
							<td height="50" align="left" valign="middle" bgcolor="#FFFFFF" style="color:#0000FF;">Estimated Calorie Required</td>
						</tr>';
					for($i=0,$k=1;$i<count($arr_date);$i++,$k++)
					{
		$output .= '	 <tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$k.'</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.date("d M Y",strtotime($arr_date[$i])).'<br />('.date("l",strtotime($arr_date[$i])).')</td>';
						for($j=0;$j<count($arr_activity_id);$j++)
						{
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_record_row[$arr_activity_id[$j]][$arr_date[$i]].'</td>';
						}	
						
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_calorie_burned[$arr_date[$i]].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_calorie_intake[$arr_date[$i]].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_estimated_calorie_required[$arr_date[$i]].'</td>
						</tr>';
					}
		$output .= '	<tr>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1">&nbsp;</td>
							<td height="50" align="center" valign="middle" bgcolor="#E1E1E1">Total</td>';
						for($i=0;$i<count($arr_activity_id);$i++)
						{
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$arr_record_row[$arr_activity_id[$i]]['total_cal_val'].'</td>';
						}	
						
		$output .= '		<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_calorie_burned.'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_calorie_intake.'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$total_estimated_calorie_required.'</td>
						</tr>                                    	
					</table>';
					
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';
	}
	return $output;	
}

function getActivityChart($user_id,$start_date,$end_date,$permission_type = '0',$pro_user_id = '0',$scale_range = '',$start_scale_value = '',$end_scale_value = '',$report_module = '',$module_keyword = '',$module_criteria = '',$criteria_scale_range = '',$start_criteria_scale_value = '',$end_criteria_scale_value = '') 
{
    global $link;

    $return = false;
    $arr_date = array();
    $arr_records = array();
    $arr_total_records = array();
    $total_cal_burned = 0;
    $total_activity_entry = getTotalNoOfActivityEntry($user_id,$start_date,$end_date,$permission_type,$pro_user_id,$scale_range,$start_scale_value,$end_scale_value,$report_module,$module_keyword,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value);

    if($module_keyword != '')
    {
        $sql_str_report_module = " AND `activity_id` = '".$module_keyword."' ";
        $sql_str_report_module2 = " AND tuda.activity_id = '".$module_keyword."' ";
    }
    else
    {
        $sql_str_report_module = '';
        $sql_str_report_module2 = '';
    }

    if($module_criteria == '4')
    {
        if($criteria_scale_range == '1')
        {
            $sql_str_report_module_criteria = " AND `activity_time` < '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time < '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '2')
        {
            $sql_str_report_module_criteria = " AND `activity_time` > '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time > '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '3')
        {
            $sql_str_report_module_criteria = " AND `activity_time` <= '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time <= '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '4')
        {
            $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time >= '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '5')
        {
            $sql_str_report_module_criteria = " AND `activity_time` = '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time = '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '6')
        {
            $sql_str_report_module_criteria = " AND `activity_time` >= '".$start_criteria_scale_value."' AND `activity_time` <= '".$end_criteria_scale_value."'";
            $sql_str_report_module_criteria2 = " AND tuda.activity_time >= '".$start_criteria_scale_value."' AND tuda.activity_time <= '".$end_criteria_scale_value."'";
        }
        else
        {
            $sql_str_report_module_criteria = "";
            $sql_str_report_module_criteria2 = "";
        }
    }
    elseif($module_criteria == '3')
    {
        if($criteria_scale_range == '1')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) < '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) < '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '2')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) > '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) > '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '3')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) <= '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) <= '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '4')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) >= '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '5')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) = '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) = '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '6')
        {
            $sql_str_report_module_criteria = " AND CAST(`mins` AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(`mins` AS SIGNED) <= '".$end_criteria_scale_value."'";
            $sql_str_report_module_criteria2 = " AND CAST(tuda.mins AS SIGNED) >= '".$start_criteria_scale_value."' AND CAST(tuda.mins AS SIGNED) <= '".$end_criteria_scale_value."'";
        }
        else
        {
            $sql_str_report_module_criteria = "";
            $sql_str_report_module_criteria2 = "";
        }
    }
    elseif($module_criteria == '7')
    {
        if($criteria_scale_range == '5')
        {
            $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) = '".$start_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuda.activity_date) = '".$start_criteria_scale_value."' ";
        }
        elseif($criteria_scale_range == '6')
        {
            $sql_str_report_module_criteria = " AND DAYOFWEEK(activity_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(activity_date) <= '".$end_criteria_scale_value."' ";
            $sql_str_report_module_criteria2 = " AND DAYOFWEEK(tuda.activity_date) >= '".$start_criteria_scale_value."' AND DAYOFWEEK(tuda.activity_date) <= '".$end_criteria_scale_value."' ";
        }
        else
        {
            $sql_str_report_module_criteria = "";
            $sql_str_report_module_criteria2 = "";
        }
    }
    else
    {
        $sql_str_report_module_criteria = "";
        $sql_str_report_module_criteria2 = "";
    }

    $sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE "
            . "`user_id` = '".$user_id."' AND "
            . "`activity_date` >= '".$start_date."' AND "
            . "`activity_date` <= '".$end_date."' AND "
            . "`activity_id` != '0' AND `activity_id` != '9999999999' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY activity_date DESC ";
    //echo "<br>".$sql;
    $result = mysql_query($sql,$link);
    if( ($result) && (mysql_num_rows($result) > 0) )
    {
        $return = true;
        while ($row = mysql_fetch_assoc($result)) 
        {
            array_push($arr_date , $row['activity_date']);
        }
    }

    if(count(arr_date) > 0)
    {
        $count = count($arr_date);
        for($i=0;$i<$count;$i++)
        {
            $total_sa_cal_burned_one_day = 0;
            $total_la_cal_burned_one_day = 0;
            $total_ma_cal_burned_one_day = 0;
            $total_va_cal_burned_one_day = 0;
            $total_sua_cal_burned_one_day = 0;
            
            
            $sql = "SELECT DISTINCT activity_id FROM `tblusersdailyactivity` WHERE "
                    . "user_id = '".$user_id."' AND "
                    . "activity_date = '".$arr_date[$i]."' AND "
                    . "activity_id != '0' AND activity_id != '9999999999' ".$sql_str_report_module." ".$sql_str_report_module_criteria." ORDER BY activity_time ASC ";
            //echo "<br><br>".$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $return = true;
                $j = 0;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $sql2 = "SELECT * FROM `tblusersdailyactivity` As tuda "
                            . "LEFT JOIN `tbldailyactivity` As tda ON tuda.activity_id = tda.activity_id "
                            . "WHERE tuda.user_id = '".$user_id."' AND "
                            . "tuda.activity_date = '".$arr_date[$i]."' AND "
                            . "tda.activity_id > '0' AND "
                            . "tuda.activity_id = '".$row['activity_id']."' ".$sql_str_report_module2." ".$sql_str_report_module_criteria2." ORDER BY tuda.activity_time ASC ";
                    //echo "<br>".$sql2;
                    $result2 = mysql_query($sql2,$link);
                    if( ($result2) && (mysql_num_rows($result2) > 0) )
                    {
                        $return = true;
                        $total_cal_burned = 0;
                        $time = '';
                        $duration = '';
                        while ($row2 = mysql_fetch_assoc($result2)) 
                        {
                            $total_cal_burned += getConsumedCalOfActivity($user_id,$row2['mins'],$row['activity_id']);
                            $alc = $row2['activity_level_code'];

                            $time = $row2['activity_time'];
                            $duration = $row2['mins'];
                            
                            $save_record = false;
                        
                            if($module_criteria == '8')
                            {
                                if($criteria_scale_range == '1')
                                {
                                    if($total_cal_burned < $start_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                elseif($criteria_scale_range == '2')
                                {
                                    if($total_cal_burned > $start_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                elseif($criteria_scale_range == '3')
                                {
                                    if($total_cal_burned <= $start_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                elseif($criteria_scale_range == '4')
                                {
                                    if($total_cal_burned >= $start_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                elseif($criteria_scale_range == '5')
                                {
                                    if($total_cal_burned = $start_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                elseif($criteria_scale_range == '6')
                                {
                                    if($total_cal_burned >= $start_criteria_scale_value && $total_cal_burned <= $end_criteria_scale_value)
                                    {
                                        $save_record = true;
                                    }
                                }
                                else
                                {
                                    $save_record = true;
                                }
                            }
                            else
                            {
                                $save_record = true;
                            }

                            if($save_record)
                            {
                                $arr_records[$arr_date[$i]]['records'][$j]['activity_id'] = $row['activity_id'] ;
                                $arr_records[$arr_date[$i]]['records'][$j]['time'] = $time ;
                                $arr_records[$arr_date[$i]]['records'][$j]['duration'] = $duration;

                                $duration_perc = ($duration / 1440) * 100;
                                $duration_perc = round($duration_perc,2);
                                $arr_records[$arr_date[$i]]['records'][$j]['duration_perc'] = $duration_perc;

                                $total_cal_burned = round($total_cal_burned);
                                if($alc == 'SUA')
                                {
                                    $arr_records[$arr_date[$i]]['records'][$j]['sua_cal_burned'] = $total_cal_burned;
                                    $arr_records[$arr_date[$i]]['records'][$j]['sa_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['la_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['ma_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['va_cal_burned'] = '';

                                    $total_sua_cal_burned_one_day += $total_cal_burned;
                                }
                                elseif($alc == 'LA')
                                {
                                    $arr_records[$arr_date[$i]]['records'][$j]['sua_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['sa_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['la_cal_burned'] = $total_cal_burned;
                                    $arr_records[$arr_date[$i]]['records'][$j]['ma_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['va_cal_burned'] = '';

                                    $total_la_cal_burned_one_day += $total_cal_burned;
                                }	
                                elseif($alc == 'MA')
                                {

                                    $arr_records[$arr_date[$i]]['records'][$j]['sua_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['sa_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['la_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['ma_cal_burned'] = $total_cal_burned;
                                    $arr_records[$arr_date[$i]]['records'][$j]['va_cal_burned'] = '';

                                    $total_ma_cal_burned_one_day += $total_cal_burned;
                                }
                                elseif($alc == 'VA')
                                {
                                    $arr_records[$arr_date[$i]]['records'][$j]['sua_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['sa_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['la_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['ma_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['va_cal_burned'] = $total_cal_burned;

                                    $total_va_cal_burned_one_day += $total_cal_burned;
                                }		
                                else
                                {
                                    $arr_records[$arr_date[$i]]['records'][$j]['sua_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['sa_cal_burned'] = $total_cal_burned;
                                    $arr_records[$arr_date[$i]]['records'][$j]['la_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['ma_cal_burned'] = '';
                                    $arr_records[$arr_date[$i]]['records'][$j]['va_cal_burned'] = '';

                                    $total_sa_cal_burned_one_day += $total_cal_burned;
                                }
                                $j++;
                            } 
                        }
                    }
                }
                
                $arr_records[$arr_date[$i]]['total_sua_cal_burned'] = $total_sua_cal_burned_one_day;
                $arr_records[$arr_date[$i]]['total_sa_cal_burned'] = $total_sa_cal_burned_one_day;
                $arr_records[$arr_date[$i]]['total_la_cal_burned'] = $total_la_cal_burned_one_day;
                $arr_records[$arr_date[$i]]['total_ma_cal_burned'] = $total_ma_cal_burned_one_day;
                $arr_records[$arr_date[$i]]['total_va_cal_burned'] = $total_va_cal_burned_one_day;
            }
        }	
    }	
    return array($return,$arr_records);	
}	

function getActivityChartHTML($user_id,$start_date,$end_date) 
{
	global $link;
	$return = false;
	$output = '';
	list($return,$arr_date,$arr_records,$total_activity_entry,$arr_total_records) = getActivityChart($user_id,$start_date,$end_date);
	if( ($return) && ( count($arr_date) > 0 ) )
	{
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td height="50" align="center" valign="middle" style="FONT-SIZE: 20px; color: #d9194c; FONT-STYLE: normal; FONT-FAMILY: Tahoma, Verdana, Arial; font-weight: bold;">Activity Analysis Chart</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td width="150" height="30" align="left" valign="middle"><strong>For the period from </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($start_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>to </strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>:</strong></td>
							<td width="200" height="30" align="left" valign="middle">'.date("d M Y",strtotime($end_date)).'</td>
							<td width="200" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="20" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td width="140" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Name</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserFullNameById($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getUserUniqueId($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>Age</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getAgeOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>Height</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getHeightOfUser($user_id). ' cms</td>
							<td height="30" align="left" valign="middle"><strong>Weight</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getWeightOfUser($user_id). ' Kgs</td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong>BMI</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMIOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>BMI Observations</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.getBMRObservationOfUser($user_id).'</td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
							<td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>
						</tr>
						<tr>	
							<td height="30" align="left" valign="middle"><strong><strong>No of days</strong></strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.count($arr_date).'</td>
							<td height="30" align="left" valign="middle"><strong>Total Activities Entry</strong></td>
							<td height="30" align="left" valign="middle"><strong>:</strong></td>
							<td height="30" align="left" valign="middle">'.$total_activity_entry.'</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
							<td height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>	
							<td colspan="9" height="30" align="left" valign="middle">&nbsp;</td>
						</tr>
					</tbody>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left"><strong>Important:</strong></td>
						</tr>
						<tr>	
							<td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>
						</tr>
					</tbody>
					</table>';
					
		for($i=0;$i<count($arr_date);$i++)
		{			
		$output .= '<table width="1150" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Date : '.date("d M Y",strtotime($arr_date[$i])).'('.date("l",strtotime($arr_date[$i])).')</td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sleep Time : '.getUserSleepTime($user_id,$arr_date[$i]).'</td>
						</tr>
						<tr>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Wake-up Time : '.getUserWakeUpTime($user_id,$arr_date[$i]).'</td>
						</tr>
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="20" align="left" valign="middle">&nbsp;</td>
						</tr>
					</table>
					<table width="1150" height="30" border="0" cellpadding="2" cellspacing="2" bgcolor="#999999" style="font-size:11px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: normal; color:#000000;">
						<tr>
							<td width="25" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">SNo</td>
							<td width="450" height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Activity</td>
							<td width="50" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Time</td>
							<td width="50" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Duration</td>
							<td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Sedentary Activity(SA)</td>
							<td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Light Activity(LA)</td>
							<td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Moderate Activity(MA)</td>
							<td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Vigorous Activity(VA)</td>
							<td width="125" height="50" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Super Active(SUA)</td>
						</tr>	';	
						$j=1;
						foreach($arr_records[$arr_date[$i]] as $key => $val)
						{
							
	$output .= '		<tr>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.$j.'</td>
							<td height="50" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">'.getDailyActivityName($key).'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['time'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['duration'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['sa_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['la_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['ma_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['va_cal_burned'].'</td>
							<td height="50" align="center" valign="middle" bgcolor="#FFFFFF">'.$val['sua_cal_burned'].'</td>
						</tr>';
							$j++;
						}
		$output .= '	<tr>
							<td height="30" align="center" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">&nbsp;</td>
							<td height="30" align="left" valign="middle" bgcolor="#E1E1E1" style="color:#0000FF;">Total</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_sa_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_la_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_ma_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_va_cal_burned'].'</td>
							<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="font-weight: bold;">'.$arr_total_records[$arr_date[$i]]['total_sua_cal_burned'].'</td>
						</tr>       
					</table>
					<table width="1150" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td height="20" align="left" valign="middle">&nbsp;</td>
						</tr>
					</table>';
		}			
					
		$output .= '<table width="1150" border="0" cellpadding="0" cellspacing="0">
					<tbody>	
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Users Note:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Things i would like to change:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" valign="bottom" style="font-size:14px;font-style: normal; font-family: Tahoma, Verdana, Arial; font-weight: bold; color:#000000;"><strong>Benefits  I noticed from the changes:</strong></td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>

						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
						<tr>	
							<td align="left" height="30" style="border-bottom:solid 1px #000000;">&nbsp;</td>
						</tr>
					</tbody>
					</table>';			
				
	}
	return $output;	
}
?>