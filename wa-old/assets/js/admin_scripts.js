function fin(responseTxt,responseStat) {
  //alert(responseStat+' - '+responseTxt);
}

// create a new ajaxObject, give it a url it will be calling and
// tell it to call the function "fin" when its got data back from the server.
//var test1 = new ajaxObject('http://someurl.com/server.cgi',fin);
//    test1.update();
               
// create a new ajaxObject, give it a url and tell it to call fin when it
// gets data back from the server.  When we initiate the ajax call we'll
// be passing 'id=user4379' to the server.           
//var test2 = new ajaxObject('http://someurl.com/program.php',fin);
//    test2.update('id=user4379');
               
// create a new ajaxObject but we'll overwrite the callback function inside
// the object to more tightly bind the object with the response hanlder.


// create a new ajaxObject and pass the data to the server (in update) as
// a POST method instead of a GET method.
//var test4 = new ajaxObject('http://someurl.com/postit.cgi', fin);
//   test4.update('coolData=47&userId=user49&log=true','POST'); 


function ajaxObject(url, callbackFunction) {
	var that=this;     
  	this.updating = false;
  	this.abort = function() {
    	if (that.updating) {
      		that.updating=false;
      		that.AJAX.abort();
      		that.AJAX=null;
    	}
	}
	this.update = function(passData,postMethod) {
    	if (that.updating) { 
			return false;
		}
    	that.AJAX = null;                         
    	if (window.XMLHttpRequest) {             
      		that.AJAX=new XMLHttpRequest();             
    	} else {                                 
      		that.AJAX=new ActiveXObject("Microsoft.XMLHTTP");
    	}                                             
    	if (that.AJAX==null) {                             
      		return false;                               
    	} else {
      		that.AJAX.onreadystatechange = function() { 
        		if (that.AJAX.readyState==4) {             
          			that.updating=false;               
          			that.callback(that.AJAX.responseText,that.AJAX.status,that.AJAX.responseXML);       
          			that.AJAX=null;                                         
        		}                                                     
      		}                                                       
      		that.updating = new Date();                             
      		if (/post/i.test(postMethod)) {
        		var uri=urlCall+'?'+that.updating.getTime();
        		that.AJAX.open("POST", uri, true);
        		that.AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        		that.AJAX.send(passData);
      		} else {
        		var uri=urlCall+'?'+passData+'&timestamp='+(that.updating.getTime());
        		that.AJAX.open("GET", uri, true);                             
        		that.AJAX.send(null);                                         
      		}             
      		return true;                                             
    	}                                                                           
  	}
  	var urlCall = url;       
  	this.callback = callbackFunction || function () { };
  
}

function fn_confirmdelete(type,url)
{
	Choice = confirm("Are you sure to delete this "+type+ " ?");
	if (Choice == true)
	{
		window.location = url;
	}
	else
	{
		//window.location = '';
	}
}