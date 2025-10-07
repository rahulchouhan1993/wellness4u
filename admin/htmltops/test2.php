<?php
require_once('generic.param.php');
require_once('config.inc.php');
require_once(HTML2PS_DIR.'pipeline.factory.class.php');
ini_set("user_agent", DEFAULT_USER_AGENT);
$g_baseurl = 'http://localhost/sellzo/remote.php?action=createvoucherimage';
$g_css_index = 0;
// Title of styleshee to use (empty if no preferences are set)
$g_stylesheet_title = "";

$GLOBALS['g_config'] = array(
                             'cssmedia'      => "screen",
                             'landscape'     => false,
                             'margins'       => array(
                                                      'left'    => 0,
                                                      'right'   => 0,
                                                      'top'     => 0,
                                                      'bottom'  => 0,
                                                      ),
                             'media'         => "Screenshot640",
                             'method'        => "png",
                             'mode'          => 'html',
                             'output'        => "2",
                             'pagewidth'     => 500,
                             'renderfields'  => false,
                             'renderforms'   => false,
                             'renderimages'  => true,
                             'renderlinks'   => false,
                             'scalepoints'   => true,
                             'smartpagebreak' => isset($_REQUEST['smartpagebreak'])
                             );


// ========== Entry point
parse_config_file('html2ps.config');
$g_media = Media::predefined($GLOBALS['g_config']['media']);
$g_media->set_landscape($GLOBALS['g_config']['landscape']);
$g_media->set_margins($GLOBALS['g_config']['margins']);
$g_media->set_pixels($GLOBALS['g_config']['pagewidth']);

// Initialize the coversion pipeline
$pipeline = new Pipeline();
$pipeline->configure($GLOBALS['g_config']);


// Configure the fetchers
if (extension_loaded('curl')) 
{
  require_once(HTML2PS_DIR.'fetcher.url.curl.class.php');
  $pipeline->fetchers = array(new FetcherUrlCurl());
  if ($proxy != '') 
  {
    $pipeline->fetchers[0]->set_proxy($proxy);
  };
} 
else 
{
  require_once(HTML2PS_DIR.'fetcher.url.class.php');
  $pipeline->fetchers[] = new FetcherURL();
};


// Configure the data filters
$pipeline->data_filters[] = new DataFilterDoctype();
$pipeline->data_filters[] = new DataFilterUTF8($GLOBALS['g_config']['encoding']);
if ($GLOBALS['g_config']['html2xhtml']) {
  $pipeline->data_filters[] = new DataFilterHTML2XHTML();
} else {
  $pipeline->data_filters[] = new DataFilterXHTML2XHTML();
};

$pipeline->parser = new ParserXHTML();

// "PRE" tree filters

$pipeline->pre_tree_filters = array();

$header_html    = '';
$footer_html    = "";
$filter = new PreTreeFilterHeaderFooter($header_html, $footer_html);
$pipeline->pre_tree_filters[] = $filter;

if ($GLOBALS['g_config']['renderfields']) {
  $pipeline->pre_tree_filters[] = new PreTreeFilterHTML2PSFields();
};

// 

if ($GLOBALS['g_config']['method'] === 'ps') {
  $pipeline->layout_engine = new LayoutEnginePS();
} else {
  $pipeline->layout_engine = new LayoutEngineDefault();
};

$pipeline->post_tree_filters = array();

// Configure the output format
if ($GLOBALS['g_config']['pslevel'] == 3) {
  $image_encoder = new PSL3ImageEncoderStream();
} else {
  $image_encoder = new PSL2ImageEncoderStream();
};

switch ($GLOBALS['g_config']['method']) 
{
	case 'fastps':
					if ($GLOBALS['g_config']['pslevel'] == 3) 
					{
						$pipeline->output_driver = new OutputDriverFastPS($image_encoder);
					} 
					else 
					{
						$pipeline->output_driver = new OutputDriverFastPSLevel2($image_encoder);
					};
					break;
	case 'pdflib':
					$pipeline->output_driver = new OutputDriverPDFLIB16($GLOBALS['g_config']['pdfversion']);
					break;
	case 'fpdf':
					$pipeline->output_driver = new OutputDriverFPDF();
					break;
	case 'png':
					$pipeline->output_driver = new OutputDriverPNG();
					break;
	case 'pcl':
					$pipeline->output_driver = new OutputDriverPCL();
					break;
	default:
					die("Unknown output method");
}


$filename = 'sellzo_voucher_'.time().'.png';

switch ($GLOBALS['g_config']['output']) 
{
	case 0:
		$pipeline->destination = new DestinationBrowser($filename);
		break;
	case 1:
		$pipeline->destination = new DestinationDownload($filename);
		break;
	case 2:
		//$pipeline->destination = new DestinationFile($filename, 'File saved as: <a href="%link%">%name%</a>');
		$pipeline->destination = new DestinationFile($filename, '');
		break;
};


// Start the conversion

$time = time();
$status = $pipeline->process($g_baseurl, $g_media);
?>