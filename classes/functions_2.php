<?php



class frontclass2

{

  

    function __construct() 

    {

    }

    

public function addVendorVivek($tdata)

    {

        $my_DBH = new DatabaseHandler();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = false;

		

		try {

			$sql = "INSERT INTO `tblvendors` (`cat_id`,`vendor_username`,`vendor_password`,`vendor_email`,`vendor_name`,`vendor_parent_cat_id`,`vendor_cat_id`,`vendor_status`,`vendor_add_date`,`added_by_admin`) 

					VALUES (:cat_id,:vendor_username,:vendor_password,:vendor_email,:vendor_name,:vendor_parent_cat_id,:vendor_cat_id,:vendor_status,:vendor_add_date,:added_by_admin)";

			$STH = $DBH->prepare($sql);

            $STH->execute(array(

				':cat_id' => addslashes($tdata['cat_id']),

                                ':vendor_username' => addslashes($tdata['vendor_username']),

				':vendor_password' => md5($tdata['vendor_password']),

				':vendor_email' => addslashes($tdata['vendor_email']),

				':vendor_name' => addslashes($tdata['vendor_name']),

				':vendor_parent_cat_id' => addslashes($tdata['vendor_parent_cat_id']),

				':vendor_cat_id' => addslashes($tdata['vendor_cat_id']),

				':vendor_status' => addslashes($tdata['vendor_status']),

				':vendor_add_date' => date('Y-m-d H:i:s'),

				':added_by_admin' =>$tdata['admin_id']

			));

			$vendor_id = $DBH->lastInsertId();

			$DBH->commit();

			

			if($vendor_id > 0)

			{

				$return = true;

				if(count($tdata['vloc_parent_cat_id']) > 0)

				{

					for($i=0;$i<count($tdata['vloc_parent_cat_id']);$i++)

					{

						$tdata_vloc = array();

						$tdata_vloc['vendor_id'] = $vendor_id;

						$tdata_vloc['contact_person'] = $tdata['contact_person'][$i];

						$tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];

						$tdata_vloc['contact_email'] = $tdata['contact_email'][$i];

						$tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];

						$tdata_vloc['contact_number'] = $tdata['contact_number'][$i];

						$tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];

						$tdata_vloc['country_id'] = $tdata['country_id'][$i];

						$tdata_vloc['state_id'] = $tdata['state_id'][$i];

						$tdata_vloc['city_id'] = $tdata['city_id'][$i];

						$tdata_vloc['area_id'] = $tdata['area_id'][$i];

						$tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];

						$tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];

						$tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];

						$tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];

						$tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];

						if($i == 0)

						{

							$tdata_vloc['vloc_default'] = 1;	

						}

						else

						{

							$tdata_vloc['vloc_default'] = 0;	

						}

						$tdata_vloc['vloc_status'] = 1;

						$tdata_vloc['admin_id'] = $tdata['admin_id'];

						

						$vloc_id = $this->addVendorLocation($tdata_vloc);		

						if($vloc_id > 0)

						{

							for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)

							{

								$tdata_vc = array();

								$tdata_vc['vendor_id'] = $vendor_id;

								$tdata_vc['vloc_id'] = $vloc_id;

								$tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];

								$tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];

								$tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];

								$tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];

								$tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];

								$tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];

								$tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];

								$tdata_vc['vc_cert_status'] = 1;

								$tdata_vc['admin_id'] = $tdata['admin_id'];

								$vc_cert_id = $this->addVendorCerification($tdata_vc);		

							}			

						}

					}

				}

			}

			

		} catch (Exception $e) {

			$stringData = '[addVendor] Catch Error:'.$e->getMessage().', sql:'.$sql;

			$this->debuglog($stringData);

            return false;

        }

        return $return;

    }

    

    public function addVendorLocation($tdata)

    {

		

        $my_DBH = new DatabaseHandler();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = 0;

		

		try {

			$sql = "INSERT INTO `tblvendorlocations` (`vendor_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_designation`,`contact_number`,`contact_remark`,`country_id`,`state_id`,`city_id`,`area_id`,`vloc_parent_cat_id`,`vloc_cat_id`,`vloc_speciality_offered`,`vloc_doc_file`,`vloc_menu_file`,`vloc_default`,`vloc_status`,`added_by_admin`,`vloc_add_date`) 

					VALUES (:vendor_id,:contact_person,:contact_person_title,:contact_email,:contact_designation,:contact_number,:contact_remark,:country_id,:state_id,:city_id,:area_id,:vloc_parent_cat_id,:vloc_cat_id,:vloc_speciality_offered,:vloc_doc_file,:vloc_menu_file,:vloc_default,:vloc_status,:added_by_admin,:vloc_add_date)";

			$STH = $DBH->prepare($sql);

            $STH->execute(array(

				':vendor_id' => $tdata['vendor_id'],

				':contact_person' => addslashes($tdata['contact_person']),

				':contact_person_title' => addslashes($tdata['contact_person_title']),

				':contact_email' => addslashes($tdata['contact_email']),

				':contact_designation' => addslashes($tdata['contact_designation']),

				':contact_number' => addslashes($tdata['contact_number']),

				':contact_remark' => addslashes($tdata['contact_remark']),

				':country_id' => addslashes($tdata['country_id']),

				':state_id' => addslashes($tdata['state_id']),

				':city_id' => addslashes($tdata['city_id']),

				':area_id' => addslashes($tdata['area_id']),

				':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']),

				':vloc_cat_id' => addslashes($tdata['vloc_cat_id']),

				':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']),

				':vloc_doc_file' => addslashes($tdata['vloc_doc_file']),

				':vloc_menu_file' => addslashes($tdata['vloc_menu_file']),

				':vloc_default' => addslashes($tdata['vloc_default']),

				':vloc_status' => '1',

				':added_by_admin' => $tdata['admin_id'],

				':vloc_add_date' => date('Y-m-d H:i:s')

				

            ));

			$return = $DBH->lastInsertId();

			$DBH->commit();

		} catch (Exception $e) {

			$stringData = '[addVendorLocation] Catch Error:'.$e->getMessage().', sql:'.$sql;

			$this->debuglog($stringData);

            return 0;

        }

        return $return;

    }

	

   public function addVendorCerification($tdata)

    {

		

        $my_DBH = new DatabaseHandler();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();

        $return = 0;

		

		try {

			$sql = "INSERT INTO `tblvendorcertifications` (`vendor_id`,`vloc_id`,`vc_cert_type_id`,`vc_cert_name`,`vc_cert_no`,`vc_cert_reg_date`,`vc_cert_validity_date`,`vc_cert_issued_by`,`vc_cert_scan_file`,`vc_cert_status`,`added_by_admin`,`vc_cert_add_date`) 

					VALUES (:vendor_id,:vloc_id,:vc_cert_type_id,:vc_cert_name,:vc_cert_no,:vc_cert_reg_date,:vc_cert_validity_date,:vc_cert_issued_by,:vc_cert_scan_file,:vc_cert_status,:added_by_admin,:vc_cert_add_date)";

			$STH = $DBH->prepare($sql);

            $STH->execute(array(

				':vendor_id' => $tdata['vendor_id'],

				':vloc_id' => addslashes($tdata['vloc_id']),

				':vc_cert_type_id' => addslashes($tdata['vc_cert_type_id']),

				':vc_cert_name' => addslashes($tdata['vc_cert_name']),

				':vc_cert_no' => addslashes($tdata['vc_cert_no']),

				':vc_cert_reg_date' => addslashes($tdata['vc_cert_reg_date']),

				':vc_cert_validity_date' => addslashes($tdata['vc_cert_validity_date']),

				':vc_cert_issued_by' => addslashes($tdata['vc_cert_issued_by']),

				':vc_cert_scan_file' => addslashes($tdata['vc_cert_scan_file']),

				':vc_cert_status' => $tdata['vc_cert_status'],

				':added_by_admin' => $tdata['admin_id'],

				':vc_cert_add_date' => date('Y-m-d H:i:s')

				

            ));

			$return = $DBH->lastInsertId();

			$DBH->commit();

		} catch (Exception $e) {

			$stringData = '[addVendorCerification] Catch Error:'.$e->getMessage().', sql:'.$sql;

			$this->debuglog($stringData);

            return 0;

        }

        return $return;

    }

    

    

    public function chkValidLoginVivek($vendor_username,$password)



     {

	$DBH = new DatabaseHandler();

	$return = false;

	$sql = "SELECT * FROM `tblvendors` WHERE (`vendor_username` = '".$vendor_username."' || `vendor_email` = '".$vendor_username."') AND `vendor_password` = '".md5($password)."' AND `status` = '1' ";



	$STH = $DBH->query($sql);



	if($STH->rowCount() > 0)

        {

            $return = true;

        }



	return $return;



     }



public function doLoginVivek($email)



     {



	$return = false;

	$vendor_id = $this->getVendorId($email);

	$vendor_username = $this->getVendorFullNameById($vendor_id);

	$vendor_email = $this->getVendorEmailById($vendor_id);

	if($vendor_id > 0)



	{

		$return = true;	

		$_SESSION['vendor_id'] = $vendor_id;

		$_SESSION['vendor_username'] = $vendor_username;

		$_SESSION['vendor_email'] = $vendor_email;

	}	

	return $return;



     }

     

public function getVendorId($vendor_email)



{



	$DBH = new DatabaseHandler();

	$user_id = 0;

	$sql = "SELECT * FROM `tblvendors` WHERE (`vendor_email` = '".$vendor_email."' || `vendor_username` = '".$vendor_email."') AND `status` = '1' ";



	$STH = $DBH->query($sql);



        if($STH->rowCount() > 0)

            {

                $r = $STH->fetch(PDO::FETCH_ASSOC);

                $user_id = $r['vendor_id'];

            }

        

	return $user_id;



}



public function getVendorFullNameById($vendor_id)



{



	$DBH = new DatabaseHandler();

	$name = '';

	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' ";



	$STH = $DBH->query($sql);



         if($STH->rowCount() > 0)

            {

                $r = $STH->fetch(PDO::FETCH_ASSOC);

                $name = stripslashes($r['vendor_username']);

            }

        

	return $name;



}

    

public function getVendorEmailById($vendor_id)



{



	$DBH = new DatabaseHandler();

	$email = '';

	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_id` = '".$vendor_id."' AND `status` = '1' ";



	$STH = $DBH->query($sql);



         if($STH->rowCount() > 0)

            {

                $r = $STH->fetch(PDO::FETCH_ASSOC);

                $email = $r['vendor_email'];

            }

        

	return $email;



}

     

public function chkValidEmailID($email)



{

	$DBH = new DatabaseHandler();

	$return = false;

	$sql = "SELECT * FROM `tblvendors` WHERE `vendor_email` = '".$email."' ";



	$STH = $DBH->query($sql);



	if($STH->rowCount() > 0)

	{



		$return = true;



	}



	return $return;



}



public function GetVendorName($email)



{



	$DBH = new DatabaseHandler();

	$name = '';

	$sql = "select * from `tblvendors` where vendor_email = '".$email."'";



	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)

	{



		$row = $STH->fetch(PDO::FETCH_ASSOC);



		$name = stripslashes($row['vendor_username']);



	}



	return $name;



}

public function getEmailAutoresponderDetails($email_action_id)



{

	$DBH = new DatabaseHandler();

        $data = array();

	$sql = "SELECT * FROM `tblautoresponders` WHERE `email_action_id` = '".$email_action_id."' AND `email_ar_status` = '1' AND `email_ar_deleted` = '0' ORDER BY `email_ar_add_date` DESC LIMIT 1 ";

	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)

	{

		$r = $STH->fetch(PDO::FETCH_ASSOC);

                $data = $r;



	}



	return $data;



}



public function getPageDetails($page_id)



{



	$DBH = new DatabaseHandler();

	$data = array();

	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";



	$STH = $DBH->query($sql);

	if($STH->rowCount() > 0)

	{

               while($row= $STH->fetch(PDO::FETCH_ASSOC))

		  {

		    $data[] = $row;

                  }



	}



	return $data;



}

// register start

public function getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,$vaf_am_id)

	{

		$DBH = new DatabaseHandler();

		$vaf_id = 0;

		

		$sql = "SELECT vaf_id FROM `tblvendoraccessforms` WHERE `va_id` = '".$va_id."' AND `vaf_am_id` = '".$vaf_am_id."' AND `vaf_deleted` = '0' ";	

		$STH = $DBH->query($sql);

		if( $STH->rowCount() > 0 )

        {

			$r = $STH->fetch(PDO::FETCH_ASSOC);

			$vaf_id = $r['vaf_id'];

		}

		

		return $vaf_id;

	}

public function getVendorAccessFormFieldsDetails($vaf_id)

	{

		$DBH = new DatabaseHandler();

		$arr_records = array();

		

		

		$sql2 = "SELECT * FROM `tblvendoraccessformfields` WHERE `vaf_id` = '".$vaf_id."' AND `vaff_deleted` = '0' ";	

		$STH2 = $DBH->query($sql2);

		if( $STH2->rowCount() > 0 )

		{

			while($r2 = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				$arr_records[] = $r2;	

			}

			

		}

				

		return $arr_records;

	}

	public function getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,$field_name)

	{

		$DBH = new DatabaseHandler();

		$output = '';

		

		if($vaf_id > 0)

		{

			$sql2 = "SELECT field_default_value FROM `tblvendoraccessformfields` WHERE `vaf_id` = '".$vaf_id."' AND `field_name` = '".addslashes($field_name)."' AND `vaff_deleted` = '0' ";	

			$STH2 = $DBH->query($sql2);

			if( $STH2->rowCount() > 0 )

			{

				$r2 = $STH2->fetch(PDO::FETCH_ASSOC);

				$output = stripslashes($r2['field_default_value']);

			}

		}

			

		return $output;

	}

    public function chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,$field_name)

	{

		$DBH = new DatabaseHandler();

		$output = false;

		

		if($vaf_id > 0)

		{

			$sql2 = "SELECT field_show FROM `tblvendoraccessformfields` WHERE `vaf_id` = '".$vaf_id."' AND `field_name` = '".addslashes($field_name)."' AND `vaff_deleted` = '0' ";	

			$STH2 = $DBH->query($sql2);

			if( $STH2->rowCount() > 0 )

			{

				$r2 = $STH2->fetch(PDO::FETCH_ASSOC);

				$show = stripslashes($r2['field_show']);

				if($show == '1')

				{

					$output = true;

				}

			}

		}

			

		return $output;

	}



    public function getMainProfileOption($cat_id,$type='1',$multiple='',$default_cat_ids='')

	{

		$DBH = new DatabaseHandler();

		$output = '';

		

		$sql_default_cat_id_str = "";

		if($default_cat_ids != '' && $default_cat_ids != '-1')

		{

			$sql_default_cat_id_str = " AND cat_id IN (".$default_cat_ids.") ";

		}

		

		if($type == '2')

		{

			if($multiple == '1')

			{

				if(is_array($cat_id) && count($cat_id) > 0 && in_array('-1',$cat_id))

				{

					$sel = ' selected ';	

				}

				else

				{

					$sel = '';	

				}

				$output .= '<option value="-1" '.$sel.' >All Main Profiles</option>';

			}

			else

			{

				$sel = '';

				$output .= '<option value="" '.$sel.' >All Main Profiles</option>';

			}

		}

		else

		{

			$output .= '<option value="" >Select Main Profile</option>';

		}

		

		try {

			$sql = "SELECT cat_id,cat_name FROM `tblcategories` WHERE `parent_cat_id` = '0' ".$sql_default_cat_id_str." AND `cat_deleted` = '0' ORDER BY cat_name ASC";	

			$this->debuglog('[getMainProfileOption] sql:'.$sql);

			$STH = $DBH->query($sql);

			if( $STH->rowCount() > 0 )

			{

				while($r= $STH->fetch(PDO::FETCH_ASSOC))

				{

					if($multiple == '1')

					{

						if(is_array($cat_id) && count($cat_id) > 0 && in_array($r['cat_id'],$cat_id))

						{

							$selected = ' selected ';	

						}

						else

						{

							$selected = '';	

						}

					}

					else

					{

						if($r['cat_id'] == $cat_id )

						{

							$selected = ' selected ';	

						}

						else

						{

							$selected = '';	

						}	

					}

					

					$output .= '<option value="'.$r['cat_id'].'" '.$selected.'>'.stripslashes($r['cat_name']).'</option>';

				}

			}

		} catch (Exception $e) {

			$stringData = '[getMainProfileOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

			$this->debuglog($stringData);

            return $output;

        }		

		return $output;

	}

	        

    public function getPersonTitleOption($person_title,$type='1',$multiple='')

	{

		$DBH = new DatabaseHandler();

		$output = '';

		

		if($type == '2')

		{

			if($multiple == '1')

			{

				if(in_array('-1', $person_title))

				{

					$selected = ' selected ';	

				}

				else

				{

					$selected = '';	

				}

				

			}

			else

			{

				$selected = '';	

			}

			$output .= '<option value="-1" '.$selected.' >All Gender</option>';

		}

		else

		{

			$output .= '<option value="" >Select Gender</option>';

		}

		

		$arr_record = array( 	"Female" => "Female",

							"Male" => "Male"

						);

		foreach($arr_record as $key => $val)

		{

			if($multiple == '1')

			{

				if(in_array($key, $person_title))

				{

					$selected = ' selected ';	

				}

				else

				{

					$selected = '';	

				}

			}

			else

			{

				if($key == $person_title )

				{

					$selected = ' selected ';	

				}

				else

				{

					$selected = '';	

				}

			}

			

			$output .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';

		}

			

		

		return $output;

	}

        

    public function getVendorSpecialityOfferedOption($vloc_speciality_offered,$type='1',$multiple='')

	{

		$DBH = new DatabaseHandler();

		$output = '';

		

		if($type == '2')

		{

			if($multiple == '1')

			{

				if(in_array('-1', $vloc_speciality_offered))

				{

					$selected = ' selected ';	

				}

				else

				{

					$selected = '';	

				}

				

			}

			else

			{

				$selected = '';	

			}

			$output .= '<option value="-1" '.$selected.' >All Speciality</option>';

		}

		else

		{

			$output .= '<option value="" >Select Speciality</option>';

		}

		

		try {

			$sql = "SELECT item_id,item_name FROM `tblitems` WHERE item_deleted = '0' ORDER BY item_name ASC ";

			$STH = $DBH->query($sql);

			if( $STH->rowCount() > 0 )

			{

				while($r= $STH->fetch(PDO::FETCH_ASSOC))

				{

					if($multiple == '1')

					{

						if(in_array($r['item_id'], $vloc_speciality_offered))

						{

							$selected = ' selected ';	

						}

						else

						{

							$selected = '';	

						}

					}

					else

					{

						if($r['item_id'] == $vloc_speciality_offered )

						{

							$selected = ' selected ';	

						}

						else

						{

							$selected = '';	

						}

					}

					

					$output .= '<option value="'.$r['item_id'].'" '.$selected.'>'.stripslashes($r['item_name']).'</option>';

				}

			}

		} catch (Exception $e) {

			$stringData = '[getVendorSpecialityOfferedOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

			$this->debuglog($stringData);

            return $output;

        }		

		return $output;

	}    

        

        

public function getAllmusic($music_id,$day)



{



	$DBH = new DatabaseHandler();

	$option_str = '';		

	$arr_days = array();

	$sql = "SELECT * FROM `tblmusic` WHERE status = '1' ORDER BY `music` ASC";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {



		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 



		{

			 $days = ($row['day']);

			 $arr_days = explode(",", $days);

                        if (in_array($day,$arr_days)) 

                                {	

                                    if($row['music_id'] == $music_id)

                                    {

                                            $sel = ' selected ';

                                    }

                                    else

                                    {

                                            $sel = '';

                                    }		



                                    $option_str .= '<option value="'.$row['music_id'].'" '.$sel.'>'.stripslashes($row['music']).'</option>';

                                }

		}

	}

	return $option_str;



}  


// add by ample 13-12-19
public function getAllmusicNew($music_id,$day,$page_id="")
{

	$DBH = new DatabaseHandler();
	$option_str = '';		
	$arr_days = array();
	    $single_date = date("Y-m-d", strtotime($day));
	    $all = date("d", strtotime($day));
	    $month_wise = date("m", strtotime($day));;
	    $days_of_week = date('w', strtotime($day));
	$sql = "SELECT * FROM `tblmindjumble` WHERE status = '1' AND box_type='Audio' ORDER BY `box_banner` ASC";
	$STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )

        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
		{	
			if(!empty($row['page_id']))
			{
				$array_page_id=explode(",",$row['page_id']);
                if(in_array($page_id, $array_page_id))
                {
                    if ($row['listing_date_type'] == 'single_date') {
                        if ($single_date == $row['single_date']) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'all') {
                        $all_arr = explode(',', $row['days_of_month']);
                        if (in_array($all, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'days_of_month') {
                        $all_arr = explode(',', $row['days_of_month']);
                        if (in_array($all, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'date_range') {
                        if (($row['start_date'] >= $single_date) && ($single_date <= $row['end_date'])) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'month_wise') {
                        $all_arr = explode(',', $row['months']);
                        if (in_array($month_wise, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'days_of_week') {
                        $all_arr = explode(',', $row['days_of_week']);
                        if (in_array($days_of_week, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    }
                }
			}
			else
			{
				if ($row['listing_date_type'] == 'single_date') {
                        if ($single_date == $row['single_date']) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'all') {
                        $all_arr = explode(',', $row['days_of_month']);
                        if (in_array($all, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'days_of_month') {
                        $all_arr = explode(',', $row['days_of_month']);
                        if (in_array($all, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'date_range') {
                        if (($row['start_date'] >= $single_date) && ($single_date <= $row['end_date'])) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'month_wise') {
                        $all_arr = explode(',', $row['months']);
                        if (in_array($month_wise, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    } elseif ($row['listing_date_type'] == 'days_of_week') {
                        $all_arr = explode(',', $row['days_of_week']);
                        if (in_array($days_of_week, $all_arr)) {
                            if($row['mind_jumble_box_id'] == $music_id) {
                                $sel = ' selected ';
                            } else {
                                $sel = '';
                            }
                            $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
                        }
                    }
			}
			

			 // $days = ($row['days_of_month']);
			 // $arr_days = explode(",", $days);
    //                     if (in_array($day,$arr_days)) 
    //                             {	
    //                                 if($row['mind_jumble_box_id'] == $music_id)
    //                                 {
    //                                         $sel = ' selected ';
    //                                 }
    //                                 else
    //                                 {
    //                                        $sel = '';
    //                                 }		
    //                                 $option_str .= '<option value="'.$row['mind_jumble_box_id'].'" '.$sel.'>'.stripslashes($row['box_banner']).'</option>';
    //                             }
		}
	}
	return $option_str;
} 



  public function getMusicNameByid($music_id)

{

        $DBH = new DatabaseHandler();

	$icon = '';

	// $sql = "SELECT * FROM `tblmusic` WHERE music_id = '".$music_id."'"; 
	//update by ample 07-02-20
	$sql = "SELECT * FROM `tblmindjumble` WHERE status = '1' AND box_type='Audio' AND mind_jumble_box_id = '".$music_id."'";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);
            //update by ample 07-02-20
            //$icon = $row['music'];
            $icon = $row['box_banner'];

	}

	return $icon;  

}    


//update  by ample 15-11-19
public function getAllAvatar($icons_id,$day_month_year,$page_id="")
{

	$DBH = new DatabaseHandler();

	$option_str = '';		

	$arr_days = array();

        $single_date = date("Y-m-d",strtotime($day_month_year));

        //echo '<br>';

        $all = date("d",strtotime($day_month_year));

        //echo '<br>';

        $month_wise = date("m",strtotime($day_month_year));

        //echo '<br>';

        $days_of_week = date('w', strtotime($day_month_year));
        
        //update  by ample 15-11-19
	// $sql = "SELECT * FROM `tbl_icons` WHERE status = '1' AND  icons_type_id !='357' ORDER BY `icons_name` ASC";
        //again update by 03-02-20
        $sql = "SELECT * FROM `tbl_icons` WHERE status = '1' AND  (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') ORDER BY `icons_name` ASC";


	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {

		while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

		{
				if(!empty($row['page_id']))
                {
                	$array_page_id=explode(",",$row['page_id']);
                    if(in_array($page_id, $array_page_id))
                    {
                    	if($row['listing_date_type'] == 'single_date')
                             {
                                if($single_date == $row['single_date']) 

                                {
                                     if($row['icons_id'] == $icons_id)
                                    {

                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }
                             }
                             elseif($row['listing_date_type'] == 'all')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                           $sel = ' selected ';
                                    }
                                    else
                                    {
                                           $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                } 
                             }
                             elseif($row['listing_date_type'] == 'days_of_month')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                    $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'date_range')
                             {
                               if(($row['start_date'] >=$single_date) && ($single_date<= $row['end_date']) ) 
                                {
                                    if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'month_wise')
                             {
                                $all_arr = explode(',', $row['months']);
                                if(in_array($month_wise, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {

                                           $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }    
                             }
                             elseif($row['listing_date_type'] == 'days_of_week')
                             {
                                $all_arr = explode(',', $row['days_of_week']);
                                if(in_array($days_of_week, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';

                                }    
                            }
                        
                    }
                }
                else
                {
                	if($row['listing_date_type'] == 'single_date')
                             {
                                if($single_date == $row['single_date']) 

                                {
                                     if($row['icons_id'] == $icons_id)
                                    {

                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                    $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }
                             }
                             elseif($row['listing_date_type'] == 'all')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                           $sel = ' selected ';
                                    }
                                    else
                                    {
                                           $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                } 
                             }
                             elseif($row['listing_date_type'] == 'days_of_month')
                             {
                                $all_arr = explode(',', $row['days_of_month']);
                                if(in_array($all, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                    $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'date_range')
                             {
                               if(($row['start_date'] >=$single_date) && ($single_date<= $row['end_date']) ) 
                                {
                                    if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }  
                             }
                             elseif($row['listing_date_type'] == 'month_wise')
                             {
                                $all_arr = explode(',', $row['months']);
                                if(in_array($month_wise, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {

                                           $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		

                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';
                                }    
                             }
                             elseif($row['listing_date_type'] == 'days_of_week')
                             {
                                $all_arr = explode(',', $row['days_of_week']);
                                if(in_array($days_of_week, $all_arr))
                                {
                                     if($row['icons_id'] == $icons_id)
                                    {
                                            $sel = ' selected ';
                                    }
                                    else
                                    {
                                            $sel = '';
                                    }		
                                   $option_str .= '<option value="'.$row['icons_id'].'" '.$sel.'>'.stripslashes($row['icons_name']).'</option>';

                                }    
                            }
                }
        }
	}
	return $option_str;
}

	

  public function getAvatarNameByid($icons_id)

{

        $DBH = new DatabaseHandler();

	$icon = '';

	// $sql = "SELECT * FROM `tbl_icons` WHERE icons_id = '".$icons_id."'";
	// update by ample 07-02-20
	$sql = "SELECT * FROM `tbl_icons` WHERE status = '1' AND  (icons_type_id ='355' OR icons_type_id ='360' OR icons_type_id ='361' OR icons_type_id ='362') AND icons_id = '".$icons_id."'";

	$STH = $DBH->query($sql);

        if( $STH->rowCount() > 0 )

        {

            $row = $STH->fetch(PDO::FETCH_ASSOC);

            $icon = $row['image'];

	}

	return $icon;  

}    



}





?>