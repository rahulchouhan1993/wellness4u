<?php
/*
 * Copyright (c) Yahoo! Inc. 2005. All Rights Reserved.
 *
 * This file is part of Yahoo Masthead Plugin. The Yahoo Masthead Plugin
 * is free software; you can redistribute it and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software
 * Foundation under version 2 of the License, and no other version. The Yahoo
 * Masthead plugin is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with the Yahoo Masthead plugin; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 */
/*
Plugin Name: Web Hosting Masthead
Plugin URI: https://www.aabacosmallbusiness.com/ 
Description: Plugin to display Web Hosting Masthead.  
Author: Aabaco Small Business
Version: 1.2
Author URI: https://www.aabacosmallbusiness.com/webhosting 
*/
function attach_ywh_mast() {
  if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['HTTP_HOST'])) {
     echo <<<YWH_MAST
<style type="text/css">
.whhead {font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px;height:35px;border-bottom:1px solid #DCDCDC;padding:5px;}
.whhead a {border-bottom:none;}
.whlogo {width:362px;display:block; float:left;}
.rightside {width:50%;display:block; float:right; height:35px; text-align:right;}
#user_info { position: absolute; right: 1em; top: 50px;color: #fff;font-size: .9em;} 
#adminmenuback{top:auto !important;}
#yucs-logo {width:165px;height:32px;
		background-image:url(https://s.yimg.com/lm/aabaco/yahoo_smb_en-US_s_f_pw_351x40_small-business.png);
		_background-image:url(https://s.yimg.com/lm/aabaco/yahoo_smb_en-US_s_f_pw_351x40_small-business.png);
	}
</style>
<div class="whhead">
	<div class="whlogo">
		<a href="https://smallbusiness.yahoo.com/webhosting" title="Web Hosting">
			<div id="yucs-logo"> </div>
		</a>
	</div>
	<div class="rightside">
		<a href="https://smallbusiness.yahoo.com">Small Business Home</a> - <a href="https://help.luminate.com/kb/web-hosting">Help</a>&nbsp;&nbsp;
	</div>
</div>
YWH_MAST;
  }
}
add_action('admin_head', 'attach_ywh_mast');
?>
