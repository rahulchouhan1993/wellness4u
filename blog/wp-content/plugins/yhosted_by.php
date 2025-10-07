<?php
/* 
 * Copyright (c) Aabaco Small Business 2005. All Rights Reserved.
 *
 * This file is part of Yahoo HostedBy Plugin. The Yahoo HostedBy Plugin
 * is free software; you can redistribute it and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software 
 * Foundation under version 2 of the License, and no other version. The Yahoo 
 * HostedBy plugin is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with the Yahoo HostedBy plugin; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 */
/*
Plugin Name: Hosted by Aabaco Small Business Badge
Plugin URI: https://www.aabacosmallbusiness.com/
Description: Let your visitors know that you're as proud to be a part of the Web Hosting community as you are to be part of Wordpress by using this plug-in to place a "Hosted by Aabaco Small Business" badge on the right side of your blog pages. Your viewers can click on this badge to learn more about Web Hosting. 
Author: Aabaco Small Business
Version: 1.2
Author URI: https://www.aabacosmallbusiness.com/webhosting
*/
function attach_hosted_by_yahoo_button() {
  if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['HTTP_HOST'])) {
     echo <<<HOSTED_BY_YAHOO
<li><a href="https://smallbusiness.yahoo.com/webhosting" target="_top"><img src="https://s.yimg.com/lm/aabaco/hostedby1_small.png" width="82" height="29" border="0" align="middle" alt="Hosting by Yahoo Small Business" /></a></li>
HOSTED_BY_YAHOO;
  }
}
add_action('wp_meta', 'attach_hosted_by_yahoo_button');
?>
