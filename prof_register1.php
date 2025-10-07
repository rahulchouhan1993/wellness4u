<?php
require_once('admin/config/class.mysql.php');
require_once('admin/classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$view_action_id = '160';
$add_action_id = '158';

//if(!$obj->isAdminLoggedIn())
//{
//	header("Location: index.php?mode=login");
//	exit(0);
//}

//if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
//{	
//	header("Location: index.php?mode=invalid");
//	exit(0);
//}

if(isset($_POST['btnSubmit']))
{
    $search = strip_tags(trim($_POST['search']));
    $fav_cat_type_id = trim($_POST['fav_cat_type_id']);
    $fav_cat_id = trim($_POST['fav_cat_id']);
    $status = trim($_POST['status']);
}
else 
{
    $search = '';
    $fav_cat_type_id = '';
    $status = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Tastes Of States" />
<meta name="keywords" content="Tastes Of States" />
<meta name="title" content="wellness" />
<title>Tastes Of States</title>

<!--<link rel="icon" href="http://localhost/testesofstates/images/icon.png">-->
<!-- google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
<!-- google font -->
<link rel="stylesheet" href="wa/css/bootstrap.min.css">
<link rel="stylesheet" href="css/csswell/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="wa/css/animated.css" media="all">
<link rel="stylesheet" href="wa/css/slick.css" media="all">
<link rel="stylesheet" href="wa/css/jquery-ui.css" media="all">
<link rel="stylesheet" href="wa/css/style.css?v=1508748975">
<link rel="stylesheet" href="wa/css/responsive.css">
<link rel="stylesheet" href="wa/css/tokenize2.css" />
</head>
<body>
<!--<header>
	<nav>
		<div class="container">
			<div class="navbar-header">
				<button type="button"  class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="http://localhost/testesofstates" class="logo">
					<img src="images/logo.png" class="img-responsive" alt="logo.png">
				</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="navbar-right">
					<li>
						<a id="btnTopLocation" href="#animatedModalLocation"><img src="images/icon1.png" alt="icon1.png">Menu for</a>
						<span id="labeltoplocation">Mumbai</span><br><span class="small_label">(Click to change city/town)</span>
						<input type="hidden" name="hdntopcityid" name="hdntopcityid" value="8">
						<input type="hidden" name="hdntopareaid" name="hdntopareaid" value="">
					</li>
                    <li><a href=""><img src="images/icon2.png" alt="">Filter</a></li>
                    					<li><a href="javascript:void(0);" id="btnOpenCart" onclick="openCartPopup()" ><img src="images/icon3.png" alt="">Your Food Cart</a></li>
					                    <li><img src="images/icon4.png" alt="">8828033111</li>
                    <li>
											<a href="http://localhost/testesofstates/login.php">Login</a><span class="or">Or</span><a href="http://localhost/testesofstates/login.php">Sign Up</a>
											
						
					</li>
				</ul>
            </div>
			<div id="animatedModalLocation" style="display:none;">
				THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" 
				<div class="close_anim_model">
					<div class="close-animatedModalLocation">X</div>
				</div>
				<div class="modal-content-loc">
					<div class="modal-content-inner">	
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<h4 align="center">Select Your Location</h4>
							</div>
						</div>	
						<div class="row" style="margin-bottom:10px;">
							<div class="col-md-12 col-sm-12">
								<select name="select_your_city" id="select_your_city" onchange="getTopAreaOption()" multiple >
									<option value="" >Select Location</option><option value="68" >Adilabad, Andhra Pradesh, India</option><option value="710" >Agra, Uttar Pradesh, India</option><option value="266" >Ahmedabad, Gujarat, India</option><option value="27" >Ahmednagar, Maharashtra, India</option><option value="623" >Aizawal, Mizoram, India</option><option value="35" >Ajanta, Maharashtra, India</option><option value="665" >Ajmer, Punjab, India</option><option value="447" >Ajmer, Rajasthan, India</option><option value="6" >Akola, Maharashtra, India</option><option value="58" >Alibagh, Maharashtra, India</option><option value="704" >Aligarh, Uttar Pradesh, India</option><option value="50" >Alinagar, Maharashtra, India</option><option value="705" >Allahabad, Uttar Pradesh, India</option><option value="342" >Alleppey, Kerala, India</option><option value="870" >Alleppey, Tamil Nadu, India</option><option value="700" >Almora, Uttarakhand, India</option><option value="129" >Along, Arunachal Pradesh, India</option><option value="464" >Alwar, Rajasthan, India</option><option value="26" >Amaravati, Maharashtra, India</option><option value="541" >Ambala, Haryana, India</option><option value="381" >Ambikapur, Madhya Pradesh, India</option><option value="267" >Amreli, Gujarat, India</option><option value="668" >Amritsar, Punjab, India</option><option value="432" >Amroati, Madhya Pradesh, India</option><option value="69" >Ananthapur, Andhra Pradesh, India</option><option value="885" >Anantnag, Jammu & Kashmir, India</option><option value="66" >Andaman & Nicobar Islands, Andaman & Nicobar Islands, India</option><option value="148" >Anglong, Assam, India</option><option value="867" >Anna, Tamil Nadu, India</option><option value="220" >Arrah, Bihar, India</option><option value="186" >Aurangabad, Bihar, India</option><option value="18" >Aurangabad, Maharashtra, India</option><option value="691" >Azamgarh, Uttar Pradesh, India</option><option value="893" >Badgam, Jammu & Kashmir, India</option><option value="331" >Bagalkot, Karnataka, India</option><option value="483" >Bagaur, Rajasthan, India</option><option value="223" >Baghalpur, Bihar, India</option><option value="740" >Bahraich, Uttar Pradesh, India</option><option value="402" >Balaghat, Madhya Pradesh, India</option><option value="649" >Balangir, Orissa, India</option><option value="636" >Balasore, Orissa, India</option><option value="157" >Balbari, Assam, India</option><option value="744" >Ballia, Uttar Pradesh, India</option><option value="269" >Banas Kantha, Gujarat, India</option><option value="459" >Banaswara, Rajasthan, India</option><option value="733" >Banda, Uttar Pradesh, India</option><option value="321" >Bangalore, Karnataka, India</option><option value="819" >Bankura, West Bengal, India</option><option value="701" >Barabanki, Uttar Pradesh, India</option><option value="886" >Baramullah, Jammu & Kashmir, India</option><option value="270" >Bardoli, Gujarat, India</option><option value="724" >Bareilly, Uttar Pradesh, India</option><option value="472" >Barmer, Rajasthan, India</option><option value="141" >Barpeta, Assam, India</option><option value="908" >Bastar, Chhatisgarh, India</option><option value="735" >Basti, Uttar Pradesh, India</option><option value="25" >Beed, Maharashtra, India</option><option value="70" >Begusarai, Andhra Pradesh, India</option><option value="196" >Begusarai, Bihar, India</option><option value="308" >Belgaum, Karnataka, India</option><option value="362" >Belgaum, Kerala, India</option><option value="316" >Bellary, Karnataka, India</option><option value="197" >Bettiah, Bihar, India</option><option value="382" >Betul, Madhya Pradesh, India</option><option value="195" >Bhagalpur, Bihar, India</option><option value="2" >Bhandara, Maharashtra, India</option><option value="416" >Bharatpur, Madhya Pradesh, India</option><option value="455" >Bharatpur, Rajasthan, India</option><option value="271" >Bharuch, Gujarat, India</option><option value="560" >Bhatinda, Haryana, India</option><option value="671" >Bhatinda, Punjab, India</option><option value="471" >Bhatinda, Rajasthan, India</option><option value="272" >Bhavnagar, Gujarat, India</option><option value="456" >Bhilwara, Rajasthan, India</option><option value="369" >Bhind, Madhya Pradesh, India</option><option value="549" >Bhiwani, Haryana, India</option><option value="179" >Bhojpur, Bihar, India</option><option value="500" >Bholpur, Rajasthan, India</option><option value="404" >Bhopal, Madhya Pradesh, India</option><option value="274" >Bhuj, Gujarat, India</option><option value="324" >Bidar, Karnataka, India</option><option value="56" >Bidar, Maharashtra, India</option><option value="311" >Bijapur, Karnataka, India</option><option value="71" >Bijnore, Andhra Pradesh, India</option><option value="729" >Bijnore, Uttar Pradesh, India</option><option value="474" >Bikaner, Rajasthan, India</option><option value="572" >Bilaspur, Himachal Pradesh, India</option><option value="327" >Bilaspur, Karnataka, India</option><option value="371" >Bilaspur, Madhya Pradesh, India</option><option value="815" >Birbhum, West Bengal, India</option><option value="605" >Bishenpur, Manipur, India</option><option value="905" >Boonch, Jammu & Kashmir, India</option><option value="707" >Budaun, Uttar Pradesh, India</option><option value="715" >Buland Shahar, Uttar Pradesh, India</option><option value="390" >Buldhana, Madhya Pradesh, India</option><option value="32" >Buldhana, Maharashtra, India</option><option value="468" >Bundi, Rajasthan, India</option><option value="804" >Burdwan, West Bengal, India</option><option value="137" >Cachar, Assam, India</option><option value="778" >Cachar, Uttar Pradesh, India</option><option value="343" >Calicut, Kerala, India</option><option value="347" >Cannanore, Kerala, India</option><option value="569" >Chamba, Himachal Pradesh, India</option><option value="714" >Chamoli, Uttarakhand, India</option><option value="210" >Champaran West, Bihar, India</option><option value="606" >Chandel, Manipur, India</option><option value="250" >Chandigarh, Chandigarh, India</option><option value="412" >Chandrapur, Madhya Pradesh, India</option><option value="13" >Chandrapur, Maharashtra, India</option><option value="152" >Chapra, Assam, India</option><option value="191" >Chapra, Bihar, India</option><option value="849" >Chengai Anna, Tamil Nadu, India</option><option value="871" >Chengalpattu, Tamil Nadu, India</option><option value="863" >Chennai, Tamil Nadu, India</option><option value="415" >Chhatarpur, Madhya Pradesh, India</option><option value="626" >Chhimtuipui, Mizoram, India</option><option value="375" >Chhindwara, Madhya Pradesh, India</option><option value="323" >Chikmagalur, Karnataka, India</option><option value="608" >Chinachanopur, Manipur, India</option><option value="72" >Chitoor, Andhra Pradesh, India</option><option value="313" >Chitradurga, Karnataka, India</option><option value="678" >Chittorgarh, Punjab, India</option><option value="448" >Chittorgarh, Rajasthan, India</option><option value="610" >Churachandpur, Manipur, India</option><option value="475" >Churu, Rajasthan, India</option><option value="354" >Cochin, Kerala, India</option><option value="851" >Coimbatore, Tamil Nadu, India</option><option value="820" >Cooch Behar, West Bengal, India</option><option value="73" >Cuddapah, Andhra Pradesh, India</option><option value="638" >Cuttack, Orissa, India</option><option value="251" >Dadra Nagar Haveli, Dadra & Nagar Haveli, India</option><option value="254" >Dadra Nagar Haveli, Diu & Daman, India</option><option value="276" >Dadra Nagar Haveli, Gujarat, India</option><option value="845" >Dakshina Kannada, Karnataka, India</option><option value="255" >Daman, Diu & Daman, India</option><option value="398" >Damoh, Madhya Pradesh, India</option><option value="277" >Dangs, Gujarat, India</option><option value="200" >Darbhanga, Bihar, India</option><option value="786" >Darjeeling, Uttar Pradesh, India</option><option value="807" >Darjeeling, West Bengal, India</option><option value="139" >Darrang, Assam, India</option><option value="420" >Datia, Madhya Pradesh, India</option><option value="720" >Dehradun, Uttarakhand, India</option><option value="253" >Delhi, Delhi, India</option><option value="199" >Deoghar, Jharkhand, India</option><option value="841" >Deoghar, West Bengal, India</option><option value="743" >Deoria, Uttar Pradesh, India</option><option value="411" >Dewas, Madhya Pradesh, India</option><option value="782" >Dhahjahanpur, Uttar Pradesh, India</option><option value="172" >Dhanbad, Jharkhand, India</option><option value="383" >Dhar, Madhya Pradesh, India</option><option value="47" >Dhar, Maharashtra, India</option><option value="860" >Dharmapuri, Tamil Nadu, India</option><option value="309" >Dharwad, Karnataka, India</option><option value="436" >Dharwad, Madhya Pradesh, India</option><option value="644" >Dhenkanal, Orissa, India</option><option value="467" >Dholpur, Rajasthan, India</option><option value="134" >Dhubri, Assam, India</option><option value="33" >Dhule, Maharashtra, India</option><option value="126" >Dibang Valley, Arunachal Pradesh, India</option><option value="140" >Dibrugarh, Assam, India</option><option value="847" >Dindigul Quaid-E-Milleth, Tamil Nadu, India</option><option value="256" >Diu, Diu & Daman, India</option><option value="889" >Doda, Jammu & Kashmir, India</option><option value="189" >Dumka, Jharkhand, India</option><option value="450" >Dungarpur, Rajasthan, India</option><option value="386" >Durg, Chhatisgarh, India</option><option value="622" >East Garo Hills, Meghalaya, India</option><option value="74" >East Godavari, Andhra Pradesh, India</option><option value="127" >East Kameng, Arunachal Pradesh, India</option><option value="618" >East Kashi Hills, Meghalaya, India</option><option value="122" >East Siang, Arunachal Pradesh, India</option><option value="680" >East Sikkim, Sikkim, India</option><option value="604" >Emakulam, Lakshadweep, India</option><option value="344" >Ernakulam, Kerala, India</option><option value="698" >Etah, Uttar Pradesh, India</option><option value="716" >Etawah, Uttar Pradesh, India</option><option value="697" >Faizabad, Uttar Pradesh, India</option><option value="546" >Faridabad, Haryana, India</option><option value="662" >Faridkot, Punjab, India</option><option value="703" >Farrukhabad, Uttar Pradesh, India</option><option value="694" >Fatehpur, Uttar Pradesh, India</option><option value="575" >Ferozepur, Himachal Pradesh, India</option><option value="667" >Ferozepur, Punjab, India</option><option value="23" >Gadchiroli, Maharashtra, India</option><option value="429" >Gaddiroli, Madhya Pradesh, India</option><option value="278" >Gandhinagar, Gujarat, India</option><option value="642" >Ganjam, Orissa, India</option><option value="174" >Gaya, Bihar, India</option><option value="738" >Ghaziabad, Uttar Pradesh, India</option><option value="732" >Ghazipur, Uttar Pradesh, India</option><option value="198" >Giridih, Jharkhand, India</option><option value="262" >Goa North District, Goa, India</option><option value="264" >Goa South District, Goa, India</option><option value="135" >Goalpara, Assam, India</option><option value="218" >Godda, Bihar, India</option><option value="726" >Gonda, Uttar Pradesh, India</option><option value="65" >Gondia, Maharashtra, India</option><option value="208" >Gopalganj, Bihar, India</option><option value="731" >Gorakhpur, Uttar Pradesh, India</option><option value="879" >Gudalore, Tamil Nadu, India</option><option value="320" >Gulbarga, Karnataka, India</option><option value="214" >Gumla, Jharkhand, India</option><option value="393" >Guna, Madhya Pradesh, India</option><option value="247" >Gunila, Bihar, India</option><option value="75" >Guntakal, Andhra Pradesh, India</option><option value="76" >Guntur, Andhra Pradesh, India</option><option value="556" >Gurdaspur, Haryana, India</option><option value="664" >Gurdaspur, Punjab, India</option><option value="544" >Gurgaon, Haryana, India</option><option value="391" >Gwalior, Madhya Pradesh, India</option><option value="570" >Hamirpur, Himachal Pradesh, India</option><option value="747" >Hamirpur, Uttar Pradesh, India</option><option value="722" >Hardoi, Uttar Pradesh, India</option><option value="312" >Hassan, Karnataka, India</option><option value="181" >Hazaribagh, Jharkhand, India</option><option value="280" >Himatnagar, Gujarat, India</option><option value="542" >Hissar, Haryana, India</option><option value="809" >Hooghly, West Bengal, India</option><option value="407" >Hoshangabad, Madhya Pradesh, India</option><option value="666" >Hoshiarpur, Punjab, India</option><option value="812" >Howrah, West Bengal, India</option><option value="77" >Hyderabad, Andhra Pradesh, India</option><option value="352" >Idikki, Kerala, India</option><option value="609" >Imphal, Manipur, India</option><option value="424" >Indore, Madhya Pradesh, India</option><option value="880" >Irichi, Tamil Nadu, India</option><option value="403" >Jabalpur, Madhya Pradesh, India</option><option value="621" >Jaintia Hills, Meghalaya, India</option><option value="453" >Jaipur, Rajasthan, India</option><option value="479" >Jaisalmer, Rajasthan, India</option><option value="661" >Jalandhar, Punjab, India</option><option value="721" >Jalaun, Uttar Pradesh, India</option><option value="5" >Jalgaon, Maharashtra, India</option><option value="28" >Jalna, Maharashtra, India</option><option value="465" >Jalore, Rajasthan, India</option><option value="817" >Jalpaiguri, West Bengal, India</option><option value="887" >Jammu Tawi, Jammu & Kashmir, India</option><option value="282" >Jamnagar, Gujarat, India</option><option value="227" >Jamshedpur, Bihar, India</option><option value="741" >Jaunpur, Uttar Pradesh, India</option><option value="173" >Jehanabad, Bihar, India</option><option value="374" >Jhabua, Madhya Pradesh, India</option><option value="460" >Jhalawar, Rajasthan, India</option><option value="745" >Jhansi, Uttar Pradesh, India</option><option value="462" >Jhunjhunu, Rajasthan, India</option><option value="545" >Jind, Haryana, India</option><option value="461" >Jodhpur, Rajasthan, India</option><option value="138" >Jorhat, Assam, India</option><option value="283" >Junagadh, Gujarat, India</option><option value="646" >Kalahandi, Orissa, India</option><option value="555" >Kamal, Haryana, India</option><option value="859" >Kamaraj, Tamil Nadu, India</option><option value="130" >Kamrup, Assam, India</option><option value="559" >Kangra, Haryana, India</option><option value="564" >Kangra, Himachal Pradesh, India</option><option value="492" >Kangra, Rajasthan, India</option><option value="717" >Kanpur, Uttar Pradesh, India</option><option value="861" >Kanyakumari, Tamil Nadu, India</option><option value="675" >Kapurthala, Punjab, India</option><option value="150" >Karbi Anglong, Assam, India</option><option value="897" >Kargil, Jammu & Kashmir, India</option><option value="136" >Karimganj, Assam, India</option><option value="653" >Karimganj, Orissa, India</option><option value="79" >Karimnagar, Andhra Pradesh, India</option><option value="151" >Karli Anglong, Assam, India</option><option value="547" >Karnal, Haryana, India</option><option value="659" >Karnatakaaikal, Pondicherry, India</option><option value="902" >Karnatakagil, Jammu & Kashmir, India</option><option value="80" >Karnatakaim Nagar, Andhra Pradesh, India</option><option value="350" >Kasaragode, Kerala, India</option><option value="329" >Kasargode, Karnataka, India</option><option value="890" >Kathua, Jammu & Kashmir, India</option><option value="187" >Katihar, Bihar, India</option><option value="645" >Keonjhar, Orissa, India</option><option value="81" >Khammam, Andhra Pradesh, India</option><option value="409" >Khandwa, Madhya Pradesh, India</option><option value="207" >Khangraria, Bihar, India</option><option value="388" >Khargone, Madhya Pradesh, India</option><option value="288" >Kheda, Gujarat, India</option><option value="501" >Kheda, Rajasthan, India</option><option value="723" >Kheri, Uttar Pradesh, India</option><option value="565" >Kinnaur, Himachal Pradesh, India</option><option value="319" >Kodagu, Karnataka, India</option><option value="627" >Kohima, Nagaland, India</option><option value="143" >Kokrajhar, Assam, India</option><option value="322" >Kolar, Karnataka, India</option><option value="31" >Kolhapur, Maharashtra, India</option><option value="818" >Kolkata, West Bengal, India</option><option value="82" >Koraput, Andhra Pradesh, India</option><option value="640" >Koraput, Orissa, India</option><option value="289" >Kota, Gujarat, India</option><option value="451" >Kota, Rajasthan, India</option><option value="160" >Kotonga, Assam, India</option><option value="348" >Kottayam, Kerala, India</option><option value="866" >Kovilpatti, Tamil Nadu, India</option><option value="85" >Krishna, Andhra Pradesh, India</option><option value="567" >Kulu, Himachal Pradesh, India</option><option value="899" >Kupwara, Jammu & Kashmir, India</option><option value="87" >Kurnool, Andhra Pradesh, India</option><option value="553" >Kurukshetra, Haryana, India</option><option value="146" >Lakhimpur, Assam, India</option><option value="832" >Lakhimpur, West Bengal, India</option><option value="761" >Lalitpur, Uttar Pradesh, India</option><option value="17" >Latur, Maharashtra, India</option><option value="894" >Leh, Jammu & Kashmir, India</option><option value="230" >Lohardaga, Jharkhand, India</option><option value="119" >Lohit, Arunachal Pradesh, India</option><option value="88" >Lower Subansiri, Andhra Pradesh, India</option><option value="121" >Lower Subansiri, Arunachal Pradesh, India</option><option value="695" >Lucknow, Uttar Pradesh, India</option><option value="660" >Ludhiana, Punjab, India</option><option value="625" >Lunglei, Mizoram, India</option><option value="231" >Madhepura, Bihar, India</option><option value="180" >Madhubani, Bihar, India</option><option value="857" >Madurai, Tamil Nadu, India</option><option value="91" >Mahabubnagar, Andhra Pradesh, India</option><option value="573" >Mahirpur, Himachal Pradesh, India</option><option value="760" >Mainpuri, Uttar Pradesh, India</option><option value="345" >Malapuram, Kerala, India</option><option value="808" >Malda, West Bengal, India</option><option value="45" >Malvan, Maharashtra, India</option><option value="776" >Mamirpur, Uttar Pradesh, India</option><option value="563" >Mandi, Himachal Pradesh, India</option><option value="389" >Mandla, Madhya Pradesh, India</option><option value="38" >Mandla, Maharashtra, India</option><option value="392" >Mandsaur, Madhya Pradesh, India</option><option value="325" >Mandya, Karnataka, India</option><option value="730" >Mathura, Uttar Pradesh, India</option><option value="639" >Mayurbhanj, Orissa, India</option><option value="827" >Mayurbhanj, West Bengal, India</option><option value="95" >Medak, Andhra Pradesh, India</option><option value="708" >Meerut, Uttar Pradesh, India</option><option value="294" >Mehsana, Gujarat, India</option><option value="806" >Midnapore, West Bengal, India</option><option value="712" >Mirzabad, Uttar Pradesh, India</option><option value="696" >Mirzapur, Uttar Pradesh, India</option><option value="554" >Mohindergarh, Haryana, India</option><option value="632" >Mokokchung, Nagaland, India</option><option value="629" >Mon, Nagaland, India</option><option value="177" >Monghyr, Bihar, India</option><option value="709" >Moradabad, Uttar Pradesh, India</option><option value="379" >Morena, Madhya Pradesh, India</option><option value="171" >Motihari, Bihar, India</option><option value="8"  selected >Mumbai, Maharashtra, India</option><option value="811" >Murshidabad, West Bengal, India</option><option value="737" >Muzaffarnagar, Uttar Pradesh, India</option><option value="185" >Muzaffarpur, Bihar, India</option><option value="326" >Mysore, Karnataka, India</option><option value="367" >Nadia, Kerala, India</option><option value="805" >Nadia, West Bengal, India</option><option value="466" >Nagaur, Rajasthan, India</option><option value="873" >Nagercoil, Tamil Nadu, India</option><option value="20" >Nagpur, Maharashtra, India</option><option value="577" >Nahan, Himachal Pradesh, India</option><option value="824" >Nainital, Uttarakhand, India</option><option value="178" >Nalanda, Bihar, India</option><option value="142" >Nalbari, Assam, India</option><option value="99" >Nalgonda, Andhra Pradesh, India</option><option value="21" >Nandapur, Maharashtra, India</option><option value="36" >Nanded, Maharashtra, India</option><option value="100" >Nandyal, Andhra Pradesh, India</option><option value="742" >Narendra Nagar, Uttarakhand, India</option><option value="421" >Narsinghpur, Madhya Pradesh, India</option><option value="12" >Nasik, Maharashtra, India</option><option value="915" >Navi Mumbai, Maharashtra, India</option><option value="221" >Nawadah, Bihar, India</option><option value="865" >Nellaikatta Bomman, Tamil Nadu, India</option><option value="101" >Nellore, Andhra Pradesh, India</option><option value="252" >New Delhi, Delhi, India</option><option value="868" >Nilgiris, Tamil Nadu, India</option><option value="102" >Nizamabad, Andhra Pradesh, India</option><option value="64" >Nizamabad, Maharashtra, India</option><option value="813" >North 24 Parganas, West Bengal, India</option><option value="850" >North Arcot, Tamil Nadu, India</option><option value="156" >North Cachar Hills, Assam, India</option><option value="679" >North Sikkim, Sikkim, India</option><option value="688" >North Tripura, Tripura, India</option><option value="132" >Nowgong, Assam, India</option><option value="14" >Osmanabad, Maharashtra, India</option><option value="356" >Ottapalam, Kerala, India</option><option value="202" >Palamu, Jharkhand, India</option><option value="340" >Palghat, Kerala, India</option><option value="458" >Pali, Rajasthan, India</option><option value="803" >Pallia, Uttar Pradesh, India</option><option value="263" >Panaji, Goa, India</option><option value="296" >Panchmahal, Gujarat, India</option><option value="378" >Panna, Madhya Pradesh, India</option><option value="34" >Panna, Maharashtra, India</option><option value="16" >Parbhani, Maharashtra, India</option><option value="855" >Pasumpon, Tamil Nadu, India</option><option value="346" >Pathanamthitta, Kerala, India</option><option value="669" >Patiala, Punjab, India</option><option value="183" >Patna, Bihar, India</option><option value="727" >Pauri Garhwal, Uttarakhand, India</option><option value="862" >Periyar, Tamil Nadu, India</option><option value="631" >Phek, Nagaland, India</option><option value="647" >Phulbani, Orissa, India</option><option value="693" >Pilibhit, Uttar Pradesh, India</option><option value="725" >Pithoragarh, Uttarakhand, India</option><option value="657" >Pondicherry, Pondicherry, India</option><option value="896" >Poonch, Jammu & Kashmir, India</option><option value="154" >Prag Jyotispur, Assam, India</option><option value="153" >Pragjyatispur, Assam, India</option><option value="103" >Prakasam, Andhra Pradesh, India</option><option value="692" >Pratapgarh, Uttar Pradesh, India</option><option value="858" >Pudukottai, Tamil Nadu, India</option><option value="888" >Pulwama, Jammu & Kashmir, India</option><option value="366" >Punalur, Kerala, India</option><option value="15" >Pune, Maharashtra, India</option><option value="643" >Puri, Orissa, India</option><option value="182" >Purnea, Bihar, India</option><option value="810" >Purulia, West Bengal, India</option><option value="882" >Quaid-E-Milleth, Tamil Nadu, India</option><option value="349" >Quilon, Kerala, India</option><option value="752" >Rae Bareli, Uttar Pradesh, India</option><option value="314" >Raichur, Karnataka, India</option><option value="46" >Raigad, Maharashtra, India</option><option value="912" >Raigarh, Chhatisgarh, India</option><option value="395" >Raipur, Chhatisgarh, India</option><option value="406" >Raisen, Madhya Pradesh, India</option><option value="423" >Rajgarh (Bia), Madhya Pradesh, India</option><option value="298" >Rajkot, Gujarat, India</option><option value="498" >Rajkot, Rajasthan, India</option><option value="417" >Rajnandgaon, Chhatisgarh, India</option><option value="891" >Rajouri, Jammu & Kashmir, India</option><option value="854" >Ramnad, Tamil Nadu, India</option><option value="756" >Rampur, Uttar Pradesh, India</option><option value="209" >Ranchi, Bihar, India</option><option value="104" >Rangareddy, Andhra Pradesh, India</option><option value="373" >Ratlam, Madhya Pradesh, India</option><option value="3" >Ratnagiri, Maharashtra, India</option><option value="405" >Rewa, Madhya Pradesh, India</option><option value="548" >Rohtak, Haryana, India</option><option value="574" >Rohtak, Himachal Pradesh, India</option><option value="188" >Rohtas, Bihar, India</option><option value="670" >Ropar, Punjab, India</option><option value="301" >Sabarkantha, Gujarat, India</option><option value="431" >Sabarkantha, Madhya Pradesh, India</option><option value="414" >Sagar, Madhya Pradesh, India</option><option value="489" >Sagar, Rajasthan, India</option><option value="441" >Saharanpur, Madhya Pradesh, India</option><option value="739" >Saharanpur, Uttar Pradesh, India</option><option value="204" >Saharsa, Bihar, India</option><option value="913" >Sahebganj, Jharkhand, India</option><option value="215" >Sahibganj, Bihar, India</option><option value="106" >Salem, Andhra Pradesh, India</option><option value="856" >Salem, Tamil Nadu, India</option><option value="194" >Samastipur, Bihar, India</option><option value="637" >Sambalpur, Orissa, India</option><option value="796" >Sambalpur, Uttar Pradesh, India</option><option value="19" >Sangli, Maharashtra, India</option><option value="582" >Sangrur, Himachal Pradesh, India</option><option value="663" >Sangrur, Punjab, India</option><option value="203" >Saran, Bihar, India</option><option value="245" >Sasaram, Bihar, India</option><option value="4" >Satara, Maharashtra, India</option><option value="376" >Satna, Madhya Pradesh, India</option><option value="476" >Sawai Madhopur, Rajasthan, India</option><option value="394" >Sehore, Madhya Pradesh, India</option><option value="611" >Senapati, Manipur, India</option><option value="396" >Seoni, Madhya Pradesh, India</option><option value="217" >Shaharsa, Bihar, India</option><option value="377" >Shahdol, Madhya Pradesh, India</option><option value="706" >Shahjahanpur, Uttar Pradesh, India</option><option value="370" >Shajapur, Madhya Pradesh, India</option><option value="552" >Shimla, Haryana, India</option><option value="318" >Shimoga, Karnataka, India</option><option value="399" >Shivpuri, Madhya Pradesh, India</option><option value="59" >Shivpuri, Maharashtra, India</option><option value="1" >Sholapur, Maharashtra, India</option><option value="52" >Shrirampur, Maharashtra, India</option><option value="145" >Sibsagar, Assam, India</option><option value="384" >Sidhi, Madhya Pradesh, India</option><option value="463" >Sikar, Rajasthan, India</option><option value="839" >Sikkim, Sikkim, India</option><option value="169" >Silchar, Assam, India</option><option value="561" >Simla, Himachal Pradesh, India</option><option value="11" >Sindhudurg, Maharashtra, India</option><option value="914" >Singhbhum, Jharkhand, India</option><option value="397" >Sioni, Madhya Pradesh, India</option><option value="571" >Sirmour, Himachal Pradesh, India</option><option value="454" >Sirohi, Rajasthan, India</option><option value="550" >Sirsa, Haryana, India</option><option value="499" >Sirshi, Rajasthan, India</option><option value="337" >Sirsi, Karnataka, India</option><option value="184" >Sitamarhi, Bihar, India</option><option value="734" >Sitapur, Uttar Pradesh, India</option><option value="176" >Siwan, Bihar, India</option><option value="562" >Solan, Himachal Pradesh, India</option><option value="543" >Sonepat, Haryana, India</option><option value="133" >Sonitpur, Assam, India</option><option value="814" >South 24 Parganas, West Bengal, India</option><option value="853" >South Arcot, Tamil Nadu, India</option><option value="683" >South Sikkim, Sikkim, India</option><option value="686" >South Tripura, Tripura, India</option><option value="449" >Sri Ganganagar, Rajasthan, India</option><option value="107" >Srikakulam, Andhra Pradesh, India</option><option value="892" >Srinagar, Jammu & Kashmir, India</option><option value="702" >Sultanpur, Uttar Pradesh, India</option><option value="648" >Sundargarh, Orissa, India</option><option value="302" >Surat, Gujarat, India</option><option value="304" >Surendranagar, Gujarat, India</option><option value="401" >Surguja, Chhatisgarh, India</option><option value="613" >Tamenglong, Manipur, India</option><option value="243" >Techanabad, Bihar, India</option><option value="772" >Tehri, Uttar Pradesh, India</option><option value="29" >Thane, Maharashtra, India</option><option value="353" >Thanjavur, Kerala, India</option><option value="852" >Thanjavur, Tamil Nadu, India</option><option value="612" >Thoubal, Manipur, India</option><option value="359" >Thycaud, Kerala, India</option><option value="413" >Tikamgarh, Madhya Pradesh, India</option><option value="118" >Tirap, Arunachal Pradesh, India</option><option value="159" >Tirap, Assam, India</option><option value="848" >Tirunelveli, Tamil Nadu, India</option><option value="906" >Tirupur, Tamil Nadu, India</option><option value="457" >Tonk, Rajasthan, India</option><option value="128" >Towang, Arunachal Pradesh, India</option><option value="341" >Trichur, Kerala, India</option><option value="846" >Trichy, Tamil Nadu, India</option><option value="339" >Trivandrum, Kerala, India</option><option value="633" >Tuensang, Nagaland, India</option><option value="317" >Tumkur, Karnataka, India</option><option value="864" >Udagamandalam, Tamil Nadu, India</option><option value="470" >Udaipur, Rajasthan, India</option><option value="895" >Udhampur, Jammu & Kashmir, India</option><option value="400" >Ujjain, Madhya Pradesh, India</option><option value="614" >Ukhrul, Manipur, India</option><option value="566" >Una, Himachal Pradesh, India</option><option value="213" >Unnano, Bihar, India</option><option value="719" >Unnao, Uttar Pradesh, India</option><option value="115" >Uppar Subanbsiri, Arunachal Pradesh, India</option><option value="40" >Usmanabad, Maharashtra, India</option><option value="307" >Uttara Kannada, Karnataka, India</option><option value="758" >Uttarkashi, Uttarakhand, India</option><option value="305" >Vadodara, Gujarat, India</option><option value="190" >Vaishali, Bihar, India</option><option value="306" >Valsad, Gujarat, India</option><option value="718" >Varanasi, Uttar Pradesh, India</option><option value="387" >Vidisha, Madhya Pradesh, India</option><option value="109" >Visakhapatnam, Andhra Pradesh, India</option><option value="112" >Vizianagaram, Andhra Pradesh, India</option><option value="113" >Warangal, Andhra Pradesh, India</option><option value="7" >Wardha, Maharashtra, India</option><option value="821" >West Dinajpur, West Bengal, India</option><option value="616" >West Garo Hills, Meghalaya, India</option><option value="114" >West Godavari, Andhra Pradesh, India</option><option value="790" >West Godavari, Uttar Pradesh, India</option><option value="117" >West Kameng, Arunachal Pradesh, India</option><option value="619" >West Khasi Hills, Meghalaya, India</option><option value="116" >West Siang, Arunachal Pradesh, India</option><option value="685" >West Sikkim, Sikkim, India</option><option value="120" >West Subansiri, Arunachal Pradesh, India</option><option value="687" >West Tripura, Tripura, India</option><option value="355" >Wynad, Kerala, India</option><option value="360" >Wynand, Kerala, India</option><option value="22" >Yeotmal, Maharashtra, India</option><option value="635" >Zunheboto, Nagaland, India</option>	
								</select>
							</div>
							
						</div>	
						<div class="row" style="margin-bottom:10px;display:none">
							<div class="col-md-12 col-sm-12">
								<select name="select_your_area" id="select_your_area" multiple >
									<option value="" >Select Area</option><option value="13952" >A.M. Colony</option><option value="13953" >A.M. Marg</option><option value="14015" >Andheri East</option><option value="22011" >Andheri East to Malad East</option><option value="14016" >Andheri West</option><option value="22006" >Andheri West to Malad West</option><option value="14002" >Anushakti Nagar</option><option value="14153" >B.A.R.C.</option><option value="22016" >Bandra  East to Dadar</option><option value="22014" >Bandra East to Andheri East</option><option value="22021" >Bandra West  To Andheri West</option><option value="22005" >Bandra West to Andheri West</option><option value="14142" >Bangar Nagar</option><option value="14130" >Barve Nagar</option><option value="14174" >Bhandup</option><option value="14194" >Bhavani Shankar</option><option value="14109" >Bombay Aerodrome</option><option value="14110" >BOMBAY CENTRAL HO</option><option value="22020" >Bombay Central To Nariman  Point-Cuffe Parade</option><option value="14111" >BOMBAY GPO</option><option value="14123" >Borivali East</option><option value="14124" >Borivali West</option><option value="22019" >Byculla To CST -Nariman Point-Cuff Parade</option><option value="14217" >Chakala MIDC</option><option value="14255" >Chembur</option><option value="14247" >CHINCH BUNDER HO</option><option value="14227" >Colaba (Mumbai)</option><option value="14222" >Council Hall Tajmahal</option><option value="14223" >Cumbala Hills</option><option value="22000" >Curry Road</option><option value="14363" >DADAR HO</option><option value="14360" >Dahisar</option><option value="14275" >Delisle Road</option><option value="21993" >Deonar, Govandi</option><option value="14316" >Dharavi</option><option value="14376" >F.C.I. Bombay</option><option value="22001" >Fort</option><option value="22022" >Ghatkopar East</option><option value="22009" >Ghatkopar East To Wadala</option><option value="14395" >GHATKOPAR WEST HO</option><option value="22013" >Ghatkopar West To Kurla West</option><option value="14397" >GIRGAON HO</option><option value="14407" >Goregaon East</option><option value="14408" >Goregaon West</option><option value="14410" >Grant Road</option><option value="22002" >GTB Nagar (Guru Teg Bahadur )</option><option value="14465" >I.I.T. Mumbai</option><option value="14464" >I.T.I. Pawai</option><option value="14460" >Iria (Mumbai)</option><option value="14516" >J.B.Nagar</option><option value="14515" >Jacob Circle</option><option value="14498" >Jogeshwari East</option><option value="14499" >Jogeshwari West -Oshiwara</option><option value="14497" >Juhu</option><option value="14711" >KALBADEVI HO</option><option value="14681" >Kandiwali E</option><option value="14724" >Kandiwali W</option><option value="14646" >Khar</option><option value="14653" >Kharadi</option><option value="14547" >Kurla</option><option value="21999" >lower parel</option><option value="22018" >Lower Parel to Bombay Central</option><option value="14835" >MAHIM HO</option><option value="14794" >Malabar Hill</option><option value="14795" >Malad East</option><option value="22012" >Malad East to Borivili East</option><option value="14796" >Malad West</option><option value="22007" >Malad West to Borivali West</option><option value="14809" >Mandpeswar</option><option value="14811" >MANDVI HO (Mumbai)</option><option value="14776" >Mantralaya</option><option value="14765" >Marine Lines</option><option value="14758" >Matunga</option><option value="14884" >Mazagaon</option><option value="14859" >Motilal Nagar</option><option value="22010" >Mulund  West To Vikhroli West</option><option value="14866" >Mulund Colony</option><option value="14867" >Mulund East</option><option value="22008" >Mulund East To Ghatkopar East</option><option value="14865" >MULUND HO</option><option value="21992" >Mulund West</option><option value="14953" >N.I.T.I.E. Mumbai</option><option value="14979" >Nariman Point</option><option value="14965" >Nehru Nagar</option><option value="15102" >Pant Nagar</option><option value="15107" >Parel</option><option value="22017" >Parel to Byculla</option><option value="21994" >Powai</option><option value="22004" >Powai to Andheri East</option><option value="15065" >Prabha Devi</option><option value="15218" >Raj Bhavan Mumbai</option><option value="15219" >Rajawadi</option><option value="15327" >Sahar</option><option value="15337" >Sakinaka</option><option value="15301" >Santacruz East</option><option value="15302" >Santacruz West</option><option value="15259" >Seeoz</option><option value="15257" >Sewri</option><option value="15381" >Shivaji Nagar (Chembur)</option><option value="15380" >Shivaji Nagar (Govandi)</option><option value="15368" >Sien</option><option value="15365" >Sion</option><option value="22015" >Sion To Dadar</option><option value="15496" >Tagore Nagar</option><option value="15421" >Tank Road</option><option value="15458" >Tele. Com. Factory</option><option value="15466" >Tilak Nagar</option><option value="15479" >Tulsiwadi (Mumbai)</option><option value="15531" >Vandre</option><option value="15532" >Vandre East</option><option value="15567" >Varsova</option><option value="15574" >Veer Jija Mata Udyan</option><option value="15602" >Versova</option><option value="15600" >Vidhya Nagari</option><option value="15588" >Vikroli</option><option value="15589" >Vileparle East</option><option value="15590" >Vileparle West</option><option value="15645" >Wadala</option><option value="15644" >Worli (Mumbai)</option>	
								</select>
							</div>
						</div>	
						<div class="row">	
							<div class="col-md-12 col-sm-12">
								<button name="btnSelectYourLocation" id="btnSelectYourLocation" onclick="setTopLocation()" class="btnoval">Select</button>
							</div>	
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</nav>
</header>-->




<!--header-->


<!--header-->

<header>

 

    <div class="container">

    

    <div class="row" style="margin-bottom:25px;">	

    <!-- logo -->

<div class="col-md-2" style="height:100px;">

    

    <a class="navbar-brand" href="http://localhost/wellnessway4you"><img src="uploads/cwri_logo.png" width="100px" height="100px" border="0" /></a>

    </div>

   <div class="col-md-8">

                            
     </div>

</div>

</div>

      <!-- Static navbar -->

 <div class="container">

      <nav class="navbar navbar-default">

       

          <div class="navbar-header">



                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">



                        <span class="sr-only">Toggle navigation</span>



                        <span class="icon-bar"></span>



                        <span class="icon-bar"></span>



                        <span class="icon-bar"></span>



                    </button>

                    



                </div>

          <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-left">



                         


                                                        <li>



                                                            <a href="pages.php?id=164">My Dashboard</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="pages.php?id=166">View Rewards</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="caravan.php">Care Partners</a>



                                                        


                                                        </li>



                                                    


                                                        <li>



                                                            <a href="pages.php?id=59">Advisers Hub</a>



                                                        


                                                        </li>



                                                    


                                                


                                                    


                                                        <li><a href="login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>



                                                    


                    </ul>

            

          </div><!--/.nav-collapse -->

            </nav>

       

 </div><!--/.container-fluid -->

    

    <!-- Tips bar  -->






</header>

<form action="register2.php" method="POST">
               
<section id="checkout">
	<div class="container">
		<div class="row">
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8">
                        <form name="frmlogin" id="frmlogin">
                                <input type="hidden" name="ref_url" id="ref_url" value="" >
                                <div id="checkout-accordion">
                                        <h3 data-corners="false">
                                                <p style="margin-top: 0px;">Wellness Register</p>
                                        </h3>
                                        <div class="checkout-accordion-content">
                                                <div id="checkout-tabs" class="checkout-tabs">
                                                        <ul>
                                                                <li class="col-md-4"><a href="#checkout-signup-tab">Sign Up</a></li>
                                                        </ul>
                                                        <div id="checkout-signup-tab">
                                                                <span id="err_msg_signup"></span>
                                                                <div id="signup-box">
                                                                        <div class="form-group">
                                                                                <select name="fav_cat_type_id" id="fav_cat_type_id" class="input-text-box">
                                                                                        
                                                                                        <?php echo $obj->getFavCategoryRamakant('42','')?>

                                                                                </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                              <a href="register2.php" class="btn-red" href="javascript:doVendorRegistrationProceed()">PROCEED</a>
                                                                        </div>	
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </form>
			</div>
			<div class="col-md-2">&nbsp;</div>
			
		</div>
	</div>
</section>
</form>
<!--<footer>

	<div class="container">

		<div class="row">

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>COMPANY</h4>

				<ul>

					<li><a href="http://localhost/testesofstates/about_us.php">About Us</a></li>

					<li><a href="http://localhost/testesofstates/terms.php">Terms & Conditions Policy</a></li>

					<li><a href="http://localhost/testesofstates/disclaimer.php">Disclaimer Policy</a></li>

					<li><a href="http://localhost/testesofstates/privacy_policy.php">Privacy Policy</a></li>

					<li><a href="http://localhost/testesofstates/cancellation_refund_policy.php">Cancellation & Refund Policy</a></li>

					<li><a href="http://localhost/testesofstates/shipping_delivery_policy.php">Shipping & Delivery Policy</a></li>

				</ul>

			</div>

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>Business Associates</h4>

				<ul>

					<li><a href="http://localhost/testesofstates/business-associate-register.php">Business Associates Registration</a></li>

					<li><a href="http://localhost/testesofstates/business-associate/login.php">Business Associates Login</a></li>

				</ul>

			</div>

			<div class="col-md-3 col-xs-12 footer_menu ">

				<h4>CONTACT</h4>

				<ul>

					<li><a href="http://localhost/testesofstates/contact_us.php">Contact Us</a></li>

					<li><img src="images/icon4.png" alt="">8828033111</li>

					<li><a href="mailto:support@tastes-of-states.com">support@tastes-of-states.com</a></li>

				</ul>

			</div>

			<div class="col-md-3 col-xs-12 footer_menu ">

				
				<div class="row">

					<div class="col-md-12">

						<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5927dde055350600125cfd8d&product=inline-share-buttons"></script>

						<div class="sharethis-inline-share-buttons"></div>

					</div>

					<div class="col-md-12">

						<div class="follow_title">Follow Us:</div>

						<ul class="social">    	

							<li><a href="https://www.facebook.com/Tastes-of-States-766701600150656/" target="_blank" alt="Facebook"><i class="fa fa-facebook">&nbsp;</i></a></li>

							<li><a href="https://twitter.com/TastesOfStates?s=09" target="_blank" alt="Twitter"><i class="fa fa-twitter">&nbsp;</i></a></li>    	

						</ul>            

					</div>

				</div>		

			</div>

		</div>

	</div>

</footer>-->

 <footer> 

   <div class="container">

   <div class="row">

   <div class="col-md-12">	

                        

 <table width="100%" cellspacing="5" cellpadding="10" border="0" class="footerBg" id="footer" >                                                    <tbody><tr>                                                        

                        <td width="70%" valign="middle" height="" align="left">

                        <div style="background-color:#5abd46; padding-left:15px;">

                        <span id="footer_pages" class="footerN" > <a class="footer_link" href="index.php">Home</a> | <a class="footer_link" href="about_us.php">About Us</a> | <a class="footer_link" href="contact_us.php">Contact Us</a> | <a class="footer_link" href="resources.php">Resources</a> | <a class="footer_link" href="disclaimer.php" >Disclaimer</a> | <a class="footer_link" href="terms_and_conditions.php" >Terms &amp; Conditions</a> | <a class="footer_link" href="privacy_policy.php">Privacy Policy</a> | </span><a href="#" class="footer_link" target="_blank">Blog</a></div> </td>                                                        <td width="30%" rowspan="2" align="right" valign="middle"><table width="30%" border="0" cellspacing="0" cellpadding="0">



  <tr>



    <td><a href="https://www.facebook.com/WellnessWay4U" target="_blank"><img src="uploads/fb.jpg" width="32" height="32" alt="facebook" /></a></td>



    <td><a href="https://twitter.com/WellnessWay4U" target="_blank"><img src="uploads/tw.jpg" width="32" height="32" alt="Twitter" /></a></td>



    <td><a href="#" target="_blank"><img src="uploads/linkedin.jpg" width="32" height="32" alt="Linkedin" /></a></td>



    <td><a href="#" target="_blank"><img src="uploads/youtube.jpg" width="32" height="32" alt="Youtube" /></a></td>



 <td><a target="_blank" href="#"><img width="32" height="32" alt="instagram" src="uploads/instagram.jpg"></a></td>



  </tr>



</table></td>                                                    </tr>



 

</tbody>



</table>

                            

 <div style="font-size:12px;">&copy;2016 Chaitanya Wellness Research Institute, all rights reserved.</div>

<!--default footer end here-->

 

        
       
  </div>

  </div>

  </footer>

  <!--  Footer-->



<!-- Bootstrap Core JavaScript -->



 <!--default footer end here-->

       <!--scripts and plugins -->

        <!--must need plugin jquery-->
   





  



<div id="overlay-box" class="overlay-box" style="display:none;"></div>

<script src="wa/assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="wa/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="wa/assets/plugins/hoe-nav/hoe.js"></script>
<script src="wa/assets/plugins/pace/pace.min.js"></script>
<script src="wa/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="wa/assets/js/app.js"></script>
<script src="wa/assets/js/moment-with-locales.js"></script>
<script src="wa/assets/js/bootstrap-datepicker.js"></script>
<script src="wa/assets/js/bootstrap-datetimepicker.js"></script>
<script src="wa/assets/js/bootstrap-dialog.js"></script>
<script src="wa/assets/js/bootbox.min.js"></script>
<script src="wa/assets/plugins/summernote/summernote.min.js"></script>
<script src="wa/admin-js/commonfn.js" type="text/javascript"></script>
<script type="text/javascript" src="wa/js/jquery.validate.min.js"></script>
<script src="wa/admin-js/register-validator.js" type="text/javascript"></script>
<script src="wa/js/tokenize2.js"></script>
<script>

	/*

	$('#btnOpenCart').on('click', function() {

		$(".overlay-box").show();

		$("#side-cart-box").show(0).animate({'right': 0},500);	

	});

	

	$('#cart-box-toggle').on('click', function() {

		$("#side-cart-box").show(0).animate({'right': -320},500);	

		$(".overlay-box").hide();

	});

	*/

	$(function () {

		$('input').attr('autocomplete','false');

		$("#checkout-accordion").accordion({

			/*disabled: true,*/

			event: 'customClick',

			heightStyle: "content"

		});

		

		//$("#checkout-accordion").accordion("option", "active", 0);

		

		$( "#checkout-tabs" ).tabs();

		$( "#checkout-delivery-box" ).tabs();

		

		
		

		
		

		
	});

	function operateAccordion(tabNumber) {

		//alert(tabNumber);

		$("#checkout-accordion").accordion("option", "active", tabNumber);

	}

	

	//demo 01

	$('#btnTopLocation').on('click', function() {

		$('#animatedModalLocation').show();

	});

	

	$("#btnTopLocation").animatedModal({

		modalTarget:'animatedModalLocation',

		width:'50%', 

		height:'33%', 

		top:'33%', 

		left:'25%',

		color: '#FFFFFF', 

		afterOpen: function() {

			

		},

	});

	

	$('#btnTopLocation2').on('click', function() {

		$('#animatedModalLocation2').show();

	});

	

	$("#btnTopLocation2").animatedModal({

		modalTarget:'animatedModalLocation2',

		width:'50%', 

		height:'40%', 

		top:'30%', 

		left:'25%',

		color: '#FFFFFF', 

		afterOpen: function() {

			

		},

	});

	

	$('#btnTopLocation4').on('click', function() {

		$('#animatedModalLocation4').show();

	});

	

	$("#btnTopLocation4").animatedModal({

		modalTarget:'animatedModalLocation4',

		width:'50%', 

		height:'40%', 

		top:'30%', 

		left:'25%',

		color: '#FFFFFF', 

		afterOpen: function() {

			

		},

	});

	

	$('#btnTopLocation3').on('click', function() {

		$('#animatedModalLocation3').show();

	});

	

	$("#btnTopLocation3").animatedModal({

		modalTarget:'animatedModalLocation3',

		width:'50%', 

		height:'40%', 

		top:'30%', 

		left:'25%',

		color: '#FFFFFF', 

		afterOpen: function() {

			

		},

	});

	
        $('#btnTopLocation15').on('click', function() {

		$('#animatedModalLocation15').show();

	});

	

	$("#btnTopLocation15").animatedModal({

		modalTarget:'animatedModalLocation15',

		width:'50%', 

		height:'40%', 

		top:'30%', 

		left:'25%',

		color: '#FFFFFF', 

		afterOpen: function() {

			

		},

	});

        
        

	$('.cls_ingredient_popup').on('click', function() {

		$('#animatedModalIngredient').show();

	});

	

	$(".cls_ingredient_popup").animatedModal({

		modalTarget:'animatedModalIngredient',

		width:'60%', 

		height:'50%', 

		top:'25%', 

		left:'20%',

		color: '#FFFFFF', 

		beforeOpen: function() {

			//alert('111111');

			

			

		},

	});

	

	$('#select_your_city').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});

	$('#select_your_city').on('tokenize:tokens:add', getTopAreaOption);

	$('#select_your_city').on('tokenize:tokens:remove', getTopAreaOption);

	

	$('#select_your_area').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});

	

	$('#select_your_city2').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});

	$('#select_your_city2').on('tokenize:tokens:add', getDeliveryAreaOption);

	$('#select_your_city2').on('tokenize:tokens:remove', getDeliveryAreaOption);

	

	$('#select_your_area2').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});

	

	$('#select_your_city4').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});

	$('#select_your_city4').on('tokenize:tokens:add', getBillingAreaOption);

	$('#select_your_city4').on('tokenize:tokens:remove', getBillingAreaOption);

	

	$('#select_your_area4').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});

	$('#request_city_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});

	$('#contactus_city_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter City'

	});
        $('#request_area_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});
        
        $('#request_city_id').on('tokenize:tokens:add', getRequestAreaOption);

	$('#request_city_id').on('tokenize:tokens:remove', getRequestAreaOption);

        
	$('#contactus_city_id').on('tokenize:tokens:add', getContactUsAreaOption);

	$('#contactus_city_id').on('tokenize:tokens:remove', getContactUsAreaOption);

	

	$('#contactus_area_id').tokenize2({

		tokensMaxItems: 1,

		placeholder: 'Enter Area'

	});

	

	$('#contactus_item_id').tokenize2({

		placeholder: 'Enter Item'

	});

	

	$('#contactus_item_id').on('tokenize:tokens:add', toggleContactUsItemOther);

	$('#contactus_item_id').on('tokenize:tokens:remove', toggleContactUsItemOther);

	
// Form Other request for cuisin 


</script>	
</body>
</html>
