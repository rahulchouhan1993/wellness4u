<?php
// $Header: /cvsroot/html2ps/demo/index.php,v 1.5 2007/05/06 18:49:30 Konstantin Exp $
  require_once('../config.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

<script language="javascript" type="text/javascript">

String.prototype.trim = function() {
        var x=this;
        x=x.replace( /^\s*/, "" );
        x=x.replace( /\s*$/, "" );
        return x;
}

function validate() {
        var formobj = document.forms[0];
        var urlval = formobj.URL.value.trim();

        if ( !isValidURL( urlval ) ) {
                alert( 'Please input a valid URL.' );
                return false;
        }

        return true;
}

function isValidURL(url) {

        if ( url == null )
                return false;

// space extr
        var reg='^ *';
//protocol
        reg = reg+'(?:([Hh][Tt][Tt][Pp](?:[Ss]?))(?:\:\\/\\/))?';
//usrpwd
        reg = reg+'(?:(\\w+\\:\\w+)(?:\\@))?';
//domain
        reg = reg+'([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|localhost|([Ww][Ww][Ww].|[a-zA-Z0-9].)?[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,6})';
//port
        reg = reg+'(\\:\\d+)?';
//path
        reg = reg+'((?:\\/.*)*\\/?)?';
//filename
        reg = reg+'(.*?\\.(\\w{2,4}))?';
//qrystr
        reg = reg+'(\\?(?:[^\\#\\?]+)*)?';
//bkmrk
        reg = reg+'(\\#.*)?';
// space extr
        reg = reg+' *$';

        return url.match(new RegExp(reg, 'i'));
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HTML2PS/PDF</title>

<!--CSS file may be preferred as external file-->

<style type="text/css">
/* standard tag styles */
body {
        color:#000;
        background-color:#fff;
        margin:10px;
        font-family:arial, helvetica, sans-serif;
        color:#000;
        font-size:12px;
        line-height:18px;
}
p {
  color:#000;
  font-size:12px;
  line-height:18px;
  margin-top:3px;
 }
 h1 {
        font-family:arial, helvetica, sans-serif;
        color:#669;
        font-size:27px;
        letter-spacing:-1px;
        margin-top:12px;
        margin-bottom:12px;
}
input,textarea,select {
        background-color:#eeeeee;
        border: 1px solid #045564;
}
textarea {
 width: 290px;
 height: 150px;
}
img {
        border:0px;
}
fieldset {
        border: #26a solid 1px;
        margin-left:10px;
        padding-bottom:0px;
        padding-top:0px;
        margin-top:10px;
}
legend {
        background: #eee;
        border: #26a solid 1px;
        padding: 1px 10px;
        font-weight:bold;
}
/* special class/styles */
.submit {
        background-color:#669;
        color:#fff;
}
.nulinp {
        border:0px;
        background-color:#fff;
}
.hand {
        cursor: pointer;
}
/* forms formatting */
div.form-row {
        clear: both;
        padding-top: 5px;
}
div.form-row span.labl {
        float: left;
        width: 160px;
        text-align: right;
}
div.form-row span.formw {
        float: right;
        width: 300px;
        text-align: left;
}
div.spacer {
        clear: both;
}
div.comment {
  line-height: 1.1em;
}
</style>
</head>
<body>
<div class="form-row">
<form action="html2ps.php" method="get" style="margin-top:12px">
    <input type="hidden" name="process_mode" value="single" />
    <input type="hidden" id="ur" name="URL" value="http://localhost/sellzo/test3.php"/>
    <input type="hidden" id="pixels" name="pixels" value="500"/>
    <input type="hidden" name="scalepoints" value="1" id="scalepoint"/>
    <input type="hidden" name="renderimages" value="1" id="renderi"/>
    <input type="hidden" name="media" id="medi" value="Screenshot640"  />
    <input type="hidden" name="cssmedia" id="cssmedia" value="Screen"  />
    <input type="hidden" name="method" id="png" value="png"  />
    <input type="hidden" name="output" id="towher1" value="2"  />
    <input class="submit" type="submit" name="convert" value="Convert File" />
</form>
</div>












</body>
</html>