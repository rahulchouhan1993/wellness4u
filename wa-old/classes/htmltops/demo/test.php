<?php
require_once('../config.inc.php');
require_once('../pipeline.factory.class.php');
parse_config_file('../html2ps.config');

function convert_to_pdf($pdf) {

	class MyDestinationFile extends Destination {
		var $_dest_filename;

		function MyDestinationFile($dest_filename) {
			$this->_dest_filename = $dest_filename;
		}

		function process($tmp_filename, $content_type) {
			copy($tmp_filename, $this->_dest_filename);
		}
	}


	class MyDestinationDownload extends DestinationHTTP {
		function MyDestinationDownload($filename) {
			$this->DestinationHTTP($filename);
			$GLOBALS['PDFOutFileName'] = $filename;
		}

		function headers($content_type) {
			return array(
				"Content-Disposition: attachment; filename=".$GLOBALS['PDFOutFileName'].".".$content_type->default_extension,
				"Content-Transfer-Encoding: binary",
				"Cache-Control: must-revalidate, post-check=0, pre-check=0",
				"Pragma: public"
			);
		}
	}

	class MyFetcherLocalFile extends Fetcher {
	var $_content;

		function MyFetcherLocalFile() {
						
			$output .= '<table width="1000" border="0" cellpadding="0" cellspacing="0">';
		$output .= '<tbody>';
		$output .= '	<tr>';
		$output .= '		<td width="150" align="left"><strong>For the period from </strong></td>';
		$output .= '		<td width="20" align="left"><strong>:</strong></td>';
		$output .= '		<td width="200" align="left">'.date("d M Y").'</td>';
		$output .= '		<td width="150" align="left"><strong>to </strong></td>';
		$output .= '		<td width="20" align="left"><strong>:</strong></td>';
		$output .= '		<td width="200" align="left">'.date("d M Y").'</td>';
		$output .= '		<td width="100" align="left"><strong>&nbsp;</strong></td>';
		$output .= '		<td width="20" align="left"><strong>&nbsp;</strong></td>';
		$output .= '		<td width="140" align="left"><strong>&nbsp;</strong></td>';
		$output .= '	</tr>';
		$output .= '	<tr>';	
		$output .= '		<td colspan="9" align="left" height="30">&nbsp;</td>';
		$output .= '	</tr>';
		$output .= '</tbody>';
		$output .= '</table>';
		$output .= '<table width="1000" border="0" cellpadding="0" cellspacing="0">';
		$output .= '<tbody>';	
		$output .= '	<tr>';	
		$output .= '		<td width="150" align="left"><strong>Name</strong></td>';
		$output .= '		<td width="20" align="left"><strong>:</strong></td>';
		$output .= '		<td width="200" align="left">Testname</td>';
		$output .= '		<td width="150" align="left"><strong>CWRI Regn No</strong></td>';
		$output .= '		<td width="20" align="left"><strong>:</strong></td>';
		$output .= '		<td width="200" align="left">123456</td>';
		$output .= '		<td width="100" align="left"><strong>&nbsp;</strong></td>';
		$output .= '		<td width="20" align="left"><strong>&nbsp;</strong></td>';
		$output .= '		<td width="140" align="left"><strong>&nbsp;</strong></td>';
		$output .= '	</tr>';
		$output .= '	<tr>';	
		$output .= '		<td colspan="9" align="left" height="30">&nbsp;</td>';
		$output .= '	</tr>';
		$output .= '</tbody>';
		$output .= '</table>';
			
			$this->_content = $output;
		}

		function get_data($dummy1) {
			return new FetchedDataURL($this->_content, array(), "");
		}

		function get_base_url() {
			return "";
		}
	}



	$media = Media::predefined("A4");
	$media->set_landscape(true);
	$media->set_margins(array('left'   => 5,
        	                  'right'  => 5,
	                          'top'    => 0,
	                          'bottom' => 0));
	$media->set_pixels(1024); 

	$GLOBALS['g_config'] = array(
                  'cssmedia'     => 'screen',
                  'renderimages' => true,
                  'renderforms'  => false,
                  'renderlinks'  => true,
                  'renderfields'  => true,
                  'mode'         => 'html',
                  'debugbox'     => false,
                  'draw_page_border' => false,
				  'pagewidth'     => 1160,
                  );

	$g_px_scale = mm2pt($media->width() - $media->margins['left'] - $media->margins['right']) / $media->pixels;
	$g_pt_scale = $g_px_scale * 1.43; 

	$pipeline = new Pipeline;
        $pipeline->configure($GLOBALS['g_config']);
	$pipeline->fetchers[] = new MyFetcherLocalFile();
	// $pipeline->destination = new MyDestinationFile($pdf);
	$pipeline->destination = new MyDestinationDownload($pdf);
	$pipeline->data_filters[] = new DataFilterHTML2XHTML;
	$pipeline->pre_tree_filters = array();
	$header_html    = "";
	$footer_html    = "";
	$filter = new PreTreeFilterHeaderFooter($header_html, $footer_html);
	$pipeline->pre_tree_filters[] = $filter;
	$pipeline->pre_tree_filters[] = new PreTreeFilterHTML2PSFields();
	$pipeline->parser = new ParserXHTML();
	$pipeline->layout_engine = new LayoutEngineDefault;
	$pipeline->output_driver = new OutputDriverFPDF($media);

	$pipeline->process('', $media);
}

$filename = 'test_'.time();
convert_to_pdf($filename);
?>