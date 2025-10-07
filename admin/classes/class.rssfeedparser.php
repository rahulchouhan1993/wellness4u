<?php



include_once("class.paging.php");



include_once("class.admin.php");







class FeedParser  extends Admin



{



	private $xmlData; //XML data Read from the Feed Url



	private $curlHandler; // Curl Object //



	private $feedUrl; // Feed Url , Url from which data scrapped



	private $parserData; //Xml Components frpm XML parser



	private $feedResults; // Final Results in Array format //



	



	



	/*



	* FeedParser Construct



	* @Param as the Feed Url



	* Init settings



	*/







	function __construct()



	{



		//$this->feedUrl = $url;



		$this->feedUrl = '';



		$this->parserData = null;



		$this->xmlData = null;



		$this->feedResults = array();



	}



	



	/*



	* Read Feed Content from Remote Url



	* Fetch XML Content Using CURL



	*/



	



	function readXml()



	{



		//echo $this->feedUrl;



		if(isset($this->feedUrl))



		{



			try



			{



				// $this->curlHandler = curl_init($this->feedUrl);

				// curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, true);

				// curl_setopt($this->curlHandler, CURLOPT_HEADER, 0);

				// $this->xmlData = curl_exec($this->curlHandler);

				// curl_close($this->curlHandler);


				//new code by ample 30-07-20

				// $content = file_get_contents($this->feedUrl); // this could be done with cURL

    // 			 $xml = new SimpleXmlElement($content); 

    			//new code 01-08-20

    			$curl = curl_init($this->feedUrl);

				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

				$data = curl_exec($curl);

				$xml = simplexml_load_string($data);



    			if(!empty($xml))

    			{

    				$this->xmlData=$xml;

    				return true;

    			}

    			else

    			{	

    				$this->xmlData='';

    				return false;

    			}





			}



			catch(Exception $c)



			{



				return false;



			}



		}



		else



		{



			return false;



		}



	}



	



	



	/*



	* Entry Point for Parsing from XML DATA



	* Data will be parsed from Rss Or Atom Feeds.



	*/



	



	function parseXmlData()



	{


		// $docElim = new SimpleXmlElement($this->xmlData, LIBXML_NOCDATA);



		// $this->parserData = $docElim;

		//update 01-08-20
		$docElim = $this->xmlData;
		$this->parserData = $this->xmlData;
	

		if(isset($docElim->channel))



		{



			$this->parseFromRSS(); //RSS Feed



		}



		else if(isset($docElim->entry))



		{



			$this->parseFromATOM(); //Atom Feed



		}



		return $this->feedResults;



	}



	



	



	/*



	* Parser now creates the Feed Results From Rss Feeds/



	* Rss Feedas are popular feeds for news and podcast



	* only comman items are added to results



	*/



	



	function parseFromRSS()



	{



		/*



		* Retrieve Header Information



		* Get Common Header Items



		*/



		$this->feedResults["headInfo"]["feedType"] = "RSS";



		$this->feedResults["headInfo"]["title"] = (string)$this->parserData->channel->title;



		$this->feedResults["headInfo"]["description"] = (string)$this->parserData->channel->description;



		$this->feedResults["headInfo"]["link"] = (string)$this->parserData->channel->link;



		$this->feedResults["headInfo"]["category"] = (string)$this->parserData->channel->category;



		$this->feedResults["headInfo"]["docs"] = (string)$this->parserData->channel->docs;



		$this->feedResults["headInfo"]["copyright"] = (string)$this->parserData->channel->copyright;



		$this->feedResults["headInfo"]["pubDate"] = (string)$this->parserData->channel->pubDate;



		$this->feedResults["headInfo"]["language"] = (string)$this->parserData->channel->language; //add by ample 31-07-20



		$this->feedResults["headInfo"]["webMaster"] = (string)$this->parserData->channel->webMaster;



		$this->feedResults["headInfo"]["imageUrl"] = (string)$this->parserData->channel->image->url;



		$this->feedResults["headInfo"]["imageWidth"] = (string)$this->parserData->channel->image->width;



		$this->feedResults["headInfo"]["imageHeight"] = (string)$this->parserData->channel->image->height;



		$this->feedResults["headInfo"]["imageLink"] = (string)$this->parserData->channel->image->link;



		$this->feedResults["headInfo"]["imageTitle"] = (string)$this->parserData->channel->image->title;



		



		/*



		* Rss Feed Items



		* Items and common fields only



		*/



		$rec = 0;



		foreach($this->parserData->channel->item as $key=>$val)



		{



			$this->feedResults["items"][$rec]["title"] = (string)$val->title;



			$this->feedResults["items"][$rec]["description"] = (string)$val->description;



			$this->feedResults["items"][$rec]["link"] = (string)$val->link;



			$this->feedResults["items"][$rec]["author"] = (string)$val->author; //add by ample 31-07-20



			$this->feedResults["items"][$rec]["comments"] = (string)$val->comments;



			$this->feedResults["items"][$rec]["category"] = (string)$val->category;



			$this->feedResults["items"][$rec]["pubDate"] = (string)$val->pubDate;



			$rec++;



		}



		$this->feedResults["headInfo"]["countRecords"] = $rec;



	



	}



	



	/*



	* Parse Data From Atom Content



	* Atom Feeds vary from RSS in elements



	* Here the data is scrapped from Atom Feed.



	*/



	



	function parseFromATOM()



	{



		/*



		* Retrieve Header Information



		* Get Common Header Items



		*/



		$this->feedResults["headInfo"]["feedType"] = "ATOM";



		$this->feedResults["headInfo"]["authorName"] = (string)$this->parserData->author->name;



		$this->feedResults["headInfo"]["authorEmail"] = (string)$this->parserData->author->email;



		$this->feedResults["headInfo"]["copyright"] = (string)$this->parserData->author->copyright;



		$this->feedResults["headInfo"]["modified"] = (string)$this->parserData->author->modified;



		



		/*



		* ATOM Feed Items



		* Items and common fields only



		*/



		$rec= 0;



		foreach($this->parserData->entry as $key=>$val)



		{



			$this->feedResults["items"][$rec]["title"] = (string)$val->title;



			$this->feedResults["items"][$rec]["linkUrl"] = (string)$val->link{"href"};



			$this->feedResults["items"][$rec]["linkType"] = (string)$val->link->{"type"};



			$this->feedResults["items"][$rec]["issued"] = (string)$val->issued;



			$this->feedResults["items"][$rec]["id"] = (string)$val->id;



			$this->feedResults["items"][$rec]["modified"] = (string)$val->modified;



			$this->feedResults["items"][$rec]["content"] = (string)$val->content;



			$rec++;



		}



		$this->feedResults["headInfo"]["countRecords"] = $rec;



		



	}



	



	



	/*



	* Method is the entry to FeedParser



	* Function Called from invoking object



	* @ No parameters



	* Returns the Feed Results in array



	*/



	



	



	function parseFeed($url)



	{



		$this->feedUrl = $url;



		if($this->readXml())



		{	




			if(empty($this->xmlData)) 



			{



				die ("Nothing to parse this time");



				return null;



			}



			else



			{



				if(class_exists("SimpleXmlElement"))



				{



					$results = $this->parseXmlData();



					return $results;



				}



				else



				{



					die("LIB XML Not installed");



					return null;



				}



			}



		}



		else



		{



			die( "Sorry , Cannot read xml data from source");



			return null;



		}



	}



	



	public function addRssFeedUrl($rss_feed_url,$content)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$rss_feed_url_id = 0;



		



		$rss_feed_url_headinfo = json_encode($content);



		$rss_feed_url_title = $content['title'];



		$rss_feed_type = $content['feedType'];



		



		$ins_sql = "INSERT INTO `tblrssfeedurl`(`rss_feed_url`,`rss_feed_type`,`rss_feed_url_title`,`rss_feed_url_headinfo`,`rss_feed_status`,`rss_feed_copyright`,`rss_feed_category`,`rss_feed_language`) VALUES ('".addslashes($rss_feed_url)."','".addslashes($rss_feed_type)."','".addslashes($rss_feed_url_title)."','".addslashes($rss_feed_url_headinfo)."','1','".addslashes($content['copyright'])."','".addslashes($content['category'])."','".addslashes($content['language'])."')";



		//echo '<br>ins_sql = '.$ins_sql;



		 $STH = $DBH->prepare($ins_sql);



                 $STH->execute();



		//if($STH->result)

         if($STH->rowCount()  > 0) //update ample 12-06-20

		{



			//$rss_feed_url_id = $this->getInsertID(); //old



			$rss_feed_url_id=$DBH->lastInsertId(); //update ample 12-06-20



		}



		return $rss_feed_url_id;



	}



	



	public function addRssFeedItem($rss_feed_url_id,$content)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$return = false;


		$exclusion = $this->getExclusionAllNameData('Menu','42');//add by ample 28-08-20

		$status='1';

		foreach($content as $key => $val)


		{	
			$status='1';

 			foreach ($exclusion as  $row) 
 			{
                //if ( strstr($val['title'], $row  ) ) { //chnage by ample 25-08-20
                if ( preg_match(  '/\b('.$row.')\b/i',$val['title'] ) ) {
                 $status='0';
                } 
            }

            foreach ($exclusion as  $row) 
 			{
                //if ( strstr($val['description'], $row  ) ) { //chnage by ample 25-08-20
                if ( preg_match(  '/\b('.$row.')\b/i',$val['description'] ) ) {
                 $status='0';
                } 
            }

            foreach ($exclusion as  $row) 
 			{
                //if ( strstr($val['category'], $row  ) ) { //chnage by ample 25-08-20
                if ( preg_match(  '/\b('.$row.')\b/i',$val['category'] ) ) {
                 $status='0';
                } 
            }

			$rss_feed_item_json = json_encode($val);



			$rss_feed_item_title = $val['title'];



			$rss_feed_item_desc = $val['description'];



			$rss_feed_item_link = $val['link'];



			$ins_sql = "INSERT INTO `tblrssfeeditems`(`rss_feed_url_id`,`rss_feed_item_title`,`rss_feed_item_desc`,`rss_feed_item_link`,`rss_feed_item_json`,`rss_feed_item_status`,`rss_feed_item_pubDate`,`rss_feed_item_category`,`rss_feed_item_author`) VALUES ('".$rss_feed_url_id."','".addslashes($rss_feed_item_title)."','".addslashes($rss_feed_item_desc)."','".addslashes($rss_feed_item_link)."','".addslashes($rss_feed_item_json)."','".$status."','".addslashes($val['pubDate'])."','".addslashes($val['category'])."','".addslashes($val['author'])."')";



			 $STH = $DBH->prepare($ins_sql); 



                         $STH->execute();





                        if($STH->rowCount() > 0)



						{	





                        //$rss_feed_url_id = $this->getInsertID();//old code



                        //$rss_feed_url_id=$DBH->lastInsertId(); //update ample 12-06-20



                        //$this->AddRssDataInSolutionTable($rss_feed_url_id,$rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link); //code comment 12-06-20



							$return = true;



						}



		}	



		



		



		return $return;



	}



	



	public function AddRssFeed($url)



	{



		$return = false;



		$content = $this->parseFeed($url);



		if(is_array($content) && count($content) > 0)



		{



			// echo '<br><pre>';



			// print_r($content); 



			// echo '<br></pre>';  die('--');



			



			if(isset($content['headInfo']) && (count($content['headInfo']) > 0 ) && isset($content['items'])  && (count($content['items']) > 0 ) )



			{



				$rss_feed_url_id = $this->addRssFeedUrl($url,$content['headInfo']);



				//die('------123asdsd');



				if($rss_feed_url_id > 0)



				{



					$return = true;	



					$this->addRssFeedItem($rss_feed_url_id,$content['items']);



				}	



			}



		}



		return $return;



	}



	



	public function GetAllRssFeedUrlList($search)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$admin_id = $_SESSION['admin_id'];



		$edit_action_id = '168';



		$delete_action_id = '169';



		



		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);



		



		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);



		//update by ample 30-07-20



		if($search == '')



			{



				$sql = "SELECT * FROM `tblrssfeedurl` ORDER BY `rss_feed_add_date` DESC ";



			}



		else



			{



			    $sql = "SELECT * FROM `tblrssfeedurl` WHERE `rss_feed_url` LIKE '%".$search."%' OR `rss_feed_url_title` LIKE '%".$search."%' ORDER BY `rss_feed_add_date` DESC";



			}



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



		$total_records=$STH->rowCount();



		$record_per_page=100;



		$scroll=5;



		$page=new Page(); 



    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);



		$page->set_link_parameter("Class = paging");



		$page->set_qry_string($str="mode=rss_feeds");



	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));



                $STH2->execute();



		$output = '';		



		if($STH2->rowCount() > 0)



		{



			$i = 1;



			while($row = $STH2->fetch(PDO::FETCH_ASSOC))



			{



				if($row['rss_feed_status'] == '1')



				{



					$status = 'Active';



				}



				else



				{



					$status = 'Inactive';



				}



				



				$output .= '<tr class="manage-row">';



				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';


				$output .= '<td height="30" align="center">'.$status.'</td>';



				$output .= '<td height="30" align="center" nowrap="nowrap">';



						if($edit) {



				$output .= '<a href="index.php?mode=edit_rss_feed&id='.$row['rss_feed_url_id'].'" ><img src = "images/edit.gif" border="0"></a>';



							}



				$output .= '</td>';



				$output .= '<td height="30" align="center" nowrap="nowrap">';



						if($delete) {



				$output .= '<a href=\'javascript:fn_confirmdelete("Rss Feed url","sql/delrssfeedurl.php?id='.$row['rss_feed_url_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';



								}



				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';



							if($row['rss_feed_type']=='HTML')

							{

								$output .= '<a href="javascript:void(0)" onclick="showw_rss_html('.$row['rss_feed_url_id'].')" >View RSS HTML</a>';

							}

							else

							{

								$output .= '<a href="index.php?mode=view_rss_feed_items&id='.$row['rss_feed_url_id'].'" >View Rss Feeds</a>';

							}



				$output .= '</td>';

				$output .= '<td height="30" align="center">'.date('d-m-Y', strtotime($row['rss_feed_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_url_title']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_url']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_language']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_copyright']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_category']).'</td>';



				$output .= '<td height="30" align="center"> <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal'.$i.'">Vew Encoded Data</a>



							<div id="myModal'.$i.'" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Encode Data</h4>
							      </div>
							      <div class="modal-body">
							      	<div classs="container-fluid" style="overflow-wrap: break-word;">
							      	'.stripslashes($row['rss_feed_url_headinfo']).'
							      	 </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>

							  </div>
							</div>



							</td>';


				$output .= '</tr>';



				$i++;



			}



		}



		else



		{



			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';



		}



		



		$page->get_page_nav();



		return $output;



	}



	



	public function deleteRssFeedUrl($id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$return=false;



		$del_sql = "DELETE FROM `tblrssfeedurl` WHERE `rss_feed_url_id` = '".$id."'"; 



		 $STH = $DBH->prepare($del_sql);    



                 $STH->execute();



		if($STH->result)



		{



			$del_sql = "DELETE FROM `tblrssfeeditems` WHERE `rss_feed_url_id` = '".$id."'"; 



			 $STH = $DBH->prepare($del_sql);  



                         $STH->execute();



		}	



		



		if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	}



	



	public function updateRssFeedUrl($rss_feed_url_id,$rss_feed_status)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



                $return=false;



		$upd_sql = "UPDATE `tblrssfeedurl` SET `rss_feed_status` = '".addslashes($rss_feed_status)."' WHERE `rss_feed_url_id` = '".$rss_feed_url_id."'";



		$STH = $DBH->prepare($upd_sql);



                $STH->execute();



		if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	}



	



	public function getRssFeedUrlDetails($rss_feed_url_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$rss_feed_url = '';



		$rss_feed_status = '0';



				



		$sql = "SELECT * FROM `tblrssfeedurl` WHERE `rss_feed_url_id` = '".$rss_feed_url_id."' ";



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$row = $STH->fetch(PDO::FETCH_ASSOC);



			$rss_feed_url = stripslashes($row['rss_feed_url']);



			$rss_feed_status = stripslashes($row['rss_feed_status']);



		}



		return array($rss_feed_url,$rss_feed_status);



	}



	



	public function GetAllRssFeedItemList($rss_feed_url_id,$search)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$admin_id = $_SESSION['admin_id'];



		$edit_action_id = '168';



		$delete_action_id = '169';



		



		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);



		



		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);





		if($search == '')



			{



				$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_url_id` = '".$rss_feed_url_id."' ORDER BY `rss_feed_item_add_date` DESC ";



			}



		else



			{



			    //$sql = "SELECT * FROM `tblrssfeedurl` WHERE `rss_feed_url_id` = '".$rss_feed_url_id."' AND `rss_feed_url` LIKE '%".$search."%' ORDER BY `rss_feed_item_add_date` DESC";

			    //update by ample 30-07-20

				 $sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_url_id` = '".$rss_feed_url_id."' AND (`rss_feed_item_title` LIKE '%".$search."%' OR `rss_feed_item_desc` LIKE '%".$search."%') ORDER BY `rss_feed_item_add_date` DESC";

			}



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



		$total_records=$STH->rowCount();



		$record_per_page=100;



		$scroll=5;



		$page=new Page(); 



    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);



		$page->set_link_parameter("Class = paging");



		$page->set_qry_string($str="mode=view_rss_feed_items&id=".$rss_feed_url_id);



	 	$STH2 = $DBH->prepare($page->get_limit_query($sql)); 



                $STH2->execute();



		$output = '';		



		if($STH2->rowCount() > 0)



		{



			$i = 1;



			while($row = $STH2->fetch(PDO::FETCH_ASSOC))



			{



				if($row['rss_feed_item_status'] == '1')



				{



					$status = 'Active';



				}



				else



				{



					$status = 'Inactive';



				}



				



				$output .= '<tr class="manage-row">';



				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';



				$output .= '<td height="30" align="center" nowrap="nowrap">';



						if($edit) {



				$output .= '<a href="index.php?mode=edit_rss_feed_item&id='.$row['rss_feed_item_id'].'&rfuid='.$row['rss_feed_url_id'].'" ><img src = "images/edit.gif" border="0"></a>';



							}



				$output .= '</td>';



				$output .= '<td height="30" align="center" nowrap="nowrap">';



						if($delete) {



				$output .= '<a href=\'javascript:fn_confirmdelete("Rss Feed item","sql/delrssfeeditem.php?id='.$row['rss_feed_item_id'].'&rfuid='.$row['rss_feed_url_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';



								}



				$output .= '</td>';


				$output .= '<td height="30" align="center">'.date('d-m-Y', strtotime($row['rss_feed_item_add_date'])).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_item_title']).'</td>';



				$output .= '<td height="30" align="center" class="RSS-feed-img">'.stripslashes($row['rss_feed_item_desc']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_item_link']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_item_pubDate']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_item_author']).'</td>';



				$output .= '<td height="30" align="center">'.stripslashes($row['rss_feed_item_category']).'</td>';


				$output .= '<td height="30" align="center"> <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal'.$i.'">Vew Encoded Data</a>



							<div id="myModal'.$i.'" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Encode Data</h4>
							      </div>
							      <div class="modal-body">
							      	<div classs="container-fluid" style="overflow-wrap: break-word;">
							      	'.stripslashes($row['rss_feed_item_json']).'
							      	 </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>

							  </div>
							</div>



							</td>';


				$output .= '</tr>';



				$i++;



			}



		}



		else



		{



			$output = '<tr class="manage-row" height="20"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';



		}



		



		$page->get_page_nav();



		return $output;



	}



	



	public function deleteRssFeedItem($id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$return=false;



		$del_sql = "DELETE FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$id."'"; 



		 $STH = $DBH->prepare($del_sql);   



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	}



	



	public function updateRssFeedItem($rss_feed_item_id,$rss_feed_item_status,$is_featured)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$upd_sql = "UPDATE `tblrssfeeditems` SET `rss_feed_item_status` = '".addslashes($rss_feed_item_status)."',`is_featured` = '".addslashes($is_featured)."' WHERE `rss_feed_item_id` = '".$rss_feed_item_id."'";



		 $STH = $DBH->prepare($upd_sql);   



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	}



	

	//update by ample 23-10-20

	public function getRssFeedItemDetails($rss_feed_item_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$rss_feed_item_title = '';



		$rss_feed_item_status = '0';



		$is_featured=0;



		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$rss_feed_item_id."' ";



		 $STH = $DBH->prepare($sql);



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$row = $STH->fetch(PDO::FETCH_ASSOC);



			$rss_feed_item_title = stripslashes($row['rss_feed_item_title']);



			$rss_feed_item_status = stripslashes($row['rss_feed_item_status']);
 
			$rss_feed_url_id = stripslashes($row['rss_feed_url_id']); //add by ample 22-10-20

			$is_featured= stripslashes($row['is_featured']); //add by ample 23-10-20


		}

		//update by ample 22-10-20,23-10-20

		return array($rss_feed_item_title,$rss_feed_item_status,$rss_feed_url_id,$is_featured);



	}



        



        



        public function AddRssDataInSolutionTable($rss_feed_url_id,$rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$return = false;



		



		$sql = "INSERT INTO `tblsolutionitems` (`rss_feed_item_id`,`sol_box_title`,`sol_box_desc`,`sol_credit_line_url`,`sol_item_status`,`sol_item_cat_id`) VALUES ('".addslashes($rss_feed_url_id)."','".addslashes($rss_feed_item_title)."','".addslashes($rss_feed_item_desc)."','".addslashes($rss_feed_item_link)."','1','24')";



		//echo"<br>Testkk: sql = ".$sql;



		 $STH = $DBH->prepare($sql);



                 $STH->execute();



                $sol_item_id = $this->getInsertID();



                



                $page_name_data = 'wellness_solution_items';



                $rss_feed_item_data = $this->getRssTitleNameById($rss_feed_url_id);



                $alldata=$rss_feed_item_desc.' '.$rss_feed_item_data;



                $box_desc_data_explode = explode(' ',$alldata);



                $exclusion_name = $this->getExclusionAllName($page_name_data);



                for($i=0;$i<count($box_desc_data_explode);$i++)



                {



                  if(!in_array($box_desc_data_explode[$i],$exclusion_name)) 



                    {



                    $box_desc_data_explode_data[]=$box_desc_data_explode[$i];



                    }



                }



                $tdata = $this->chkDescriptionNameInTable($box_desc_data_explode_data,$sol_item_id);



               



		if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	}



        



        public function getRssTitleNameById($cs_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$cs_value = '';



				



		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$cs_id."' ";



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$row = $STH->fetch(PDO::FETCH_ASSOC);



			$cs_value = stripslashes($row['rss_feed_item_title']);



		}



		return $cs_value;



	}



         public function getExclusionAllName($page_name)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$cs_value = array();



				



		$sql = "SELECT * FROM `tbl_exclusion` where `page_name` = '".$page_name."'";



	         $STH = $DBH->prepare($sql); 



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			while($row = $STH->fetch(PDO::FETCH_ASSOC))



                        {



			$cs_value[] = stripslashes($row['exl_name']);



                        }



		}



		return $cs_value;



	}



        



         public function chkDescriptionNameInTable($box_desc_data_explode,$sol_item_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



//		$obj = new Scrolling_Windows();



		$cs_value = array();



		$cs_value_data=array();



                



                for($i=0;$i<count($box_desc_data_explode);$i++)



                {



                  if($box_desc_data_explode[$i]!='')  



                  { 



                      



                        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat` LIKE '%".$box_desc_data_explode[$i]."%'";



                         $STH = $DBH->prepare($sql); 



                         $STH->execute();



                        if($STH->rowCount() > 0)



                        {



                                while($row = $STH->fetch(PDO::FETCH_ASSOC))



                                {



                                $cs_value_data[] = stripslashes($row['fav_cat']);



                                }



                        }



                  }



                }



               



            for($i=0;$i<count($box_desc_data_explode);$i++)



                {



                  if($box_desc_data_explode[$i]!='')  



                  { 



                      



                        $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_item` LIKE '%".$box_desc_data_explode[$i]."%'";



                         $STH = $DBH->prepare($sql); 



                         $STH->execute();



                        if($STH->rowCount() > 0)



                        {



                                while($row = $STH->fetch(PDO::FETCH_ASSOC))



                                {



                                $cs_value_data[] = stripslashes($row['meal_item']);



                                $fav_id = $this->getfavCatIdFromDailyMealFavCat($row['meal_id']);



                                



                                foreach($fav_id as $rec)



                                {



                                $cs_value_data[] = $this->getFavSubCatnamebyidVivek($rec);



                                }



                                



                                $cs_value_data[] = $this->getFavSubCatnamebyidVivek($row['food_type']);



                                $cs_value_data[] = $this->getFavSubCatnamebyidVivek($row['food_veg_nonveg']);



                               



                                }



                        }



                    



                  } 



                }



            for($i=0;$i<count($box_desc_data_explode);$i++)



                {



                  if($box_desc_data_explode[$i]!='')  



                  { 



                      



                        $sql = "SELECT * FROM `tbldailyactivity` WHERE `activity` LIKE '%".$box_desc_data_explode[$i]."%'";



                         $STH = $DBH->prepare($sql);



                         $STH->execute();



                        if($STH->rowCount() > 0)



                        {



                                while($row = $STH->fetch(PDO::FETCH_ASSOC))



                                {



                                $cs_value_data[] = stripslashes($row['activity']);



                                $cs_value_data[] = $this->getFavSubCatnamebyidVivek($row['activity_level_code']);



                                $cs_value_data[] = $this->getFavSubCatnamebyidVivek($row['activity_category']);



                               



                                }



                        }



                    



                  } 



                }    



                



                $filtered = array_filter($cs_value_data);



                $cs_value = array_unique($filtered);



                $cs_value = array_values($cs_value);



                 



                $option = array();



                



                for($j=0;$j<count($cs_value); $j++)



                {



                    $option = $this->addSolutionItemKeywordData($cs_value[$j],$sol_item_id);



                }



		return $option;



//                return $cs_value;



	}



        



         public function addSolutionItemKeywordData($keyword_name,$sol_item_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		$return = false;



		



		$sql = "INSERT INTO `tbl_wellness_solution_item_keyword` (`keyword_name`,`selected_keyword`,`sol_item_id`,`page_name`) VALUES ('".addslashes($keyword_name)."','active','".addslashes($sol_item_id)."','wellness_solution_items')";



		//echo"<br>Testkk: sql = ".$sql;



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



              	if($STH->rowCount() > 0)



		{



			$return = true;



		}



		return $return;



	



        }



        



         public function getFavSubCatnamebyidVivek($fav_cat)



	{



            $my_DBH = new mysqlConnection();



            $DBH = $my_DBH->raw_handle();



            $DBH->beginTransaction();



            $return = '';



            



            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat."' ";



             $STH = $DBH->prepare($sql); 



             $STH->execute();



            if($STH->rowCount() > 0)



            {



                    $row = $STH->fetch(PDO::FETCH_ASSOC);



                    $return = $row['fav_cat'];



            }



            return $return;



	}



          public function getfavCatIdFromDailyMealFavCat($cs_id)



	{



		$my_DBH = new mysqlConnection();



                $DBH = $my_DBH->raw_handle();



                $DBH->beginTransaction();



		



		$cs_value = array();



				



		$sql = "SELECT * FROM `tbldailymealsfavcategory` WHERE `meal_id` = '".$cs_id."' ";



		 $STH = $DBH->prepare($sql);



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			while($row = $STH->fetch(PDO::FETCH_ASSOC))



                        {



			$cs_value[] = stripslashes($row['fav_cat_id']);



                        }



		}



		return $cs_value;



	}



	//add by ample 30-07-20

	public function AddRssFeedHTML($rss_feed_title,$rss_feed_html)



	{



		$my_DBH = new mysqlConnection();



        $DBH = $my_DBH->raw_handle();



        $DBH->beginTransaction();



		$return = false;

		

		$rss_feed_html = $rss_feed_html;



		$rss_feed_url_title = $rss_feed_title;



		$rss_feed_type = 'HTML';



		

		$ins_sql = "INSERT INTO `tblrssfeedurl`(`rss_feed_url`,`rss_feed_type`,`rss_feed_url_title`,`rss_feed_url_headinfo`,`rss_feed_status`,`rss_feed_html`) VALUES ('','".addslashes($rss_feed_type)."','".addslashes($rss_feed_url_title)."','','1','".addslashes($rss_feed_html)."')";



		$STH = $DBH->prepare($ins_sql);



        $STH->execute();



        if($STH->rowCount()  > 0) 

		{



			return true;



		}



		return $return;



	}



	//rss feed data 30-07-20

	public function get_rss_feed_data($rss_feed_url_id)

	{

		$my_DBH = new mysqlConnection();

        $DBH = $my_DBH->raw_handle();

        $DBH->beginTransaction();



        $data = array();

			



		$sql = "SELECT * FROM `tblrssfeedurl` WHERE `rss_feed_url_id` = '".$rss_feed_url_id."' ";



		 $STH = $DBH->prepare($sql); 



                 $STH->execute();



		if($STH->rowCount() > 0)



		{



			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$data=$row;



		}



		return $data;



	}


	public function getExclusionAllNameData($page_type="",$page_id="") {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $cs_value = array();
        if($page_id && $page_type)
        {
            $sql = "SELECT * FROM `tbl_exclusion` WHERE page_type='".$page_type."' AND page_id=".$page_id;
        }
        else
        {
            $sql = "SELECT * FROM `tbl_exclusion` where 1 ";
        }
        
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                $cs_value[] = strtolower($row['exl_name']);
            }
        }
        return $cs_value;
    }



}



?>