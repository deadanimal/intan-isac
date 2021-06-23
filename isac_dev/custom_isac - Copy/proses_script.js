
   var http_request = false;
   
   function makePOSTRequest(url, parameters) {
      http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType) {
         	// set type accordingly to anticipated content type
            //http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
         }
      } else if (window.ActiveXObject) { // IE
         try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
            try {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
         }
      }
      if (!http_request) {
         alert('Cannot create XMLHTTP instance');
         return false;
      }
      
      http_request.onreadystatechange = alertContents;
      http_request.open('POST', url, true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
   }

   function alertContents() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {
            //alert(http_request.responseText);
            result = http_request.responseText;
          //  document.getElementById('myspan').innerHTML = result;            
         } else {
            alert('There was a problem with the request.');
         }
      }
   }
   
   function get(obj) {
   		
		//var hantar = document.getElementById('hantar').value = '1';
		document.getElementById('hantar').value = '1';
		
		if(document.getElementById('hantar').value == '1'){
			
		//if jenis='single'
		if(document.getElementById("jenis").value == 'single'){
			
			for(var i = 0; i<document.myform.jwpn.length; i++){
			if(document.myform.jwpn[i].checked) {
			destination=document.myform.jwpn[i].value }
			}
			
			var poststr = "jwpn=" + encodeURI( destination ) + "&soalan=" + encodeURI( document.getElementById("soalan").value ) +
					"&jenis=" + encodeURI( document.getElementById("jenis").value ) +
                    "&usr=" + encodeURI( document.getElementById("usr").value ) +
					"&app=" + encodeURI( document.getElementById("app").value );
		
			makePOSTRequest('post.php', poststr);
		}
		//end
	
		//if jenis='multiple'
		else if(document.getElementById("jenis").value == 'multiple'){
			
			
			for(var i = 0; i<document.myform.jwpn.length; i++){
			
			jwpn = document.myform.jwpn[i].value;
			if(document.myform.jwpn[i].checked == 1) {
			
			ischeck = 'true'; 
			}
			else{
			ischeck = 'false';
			}
			
			var poststr = "jwpn=" + encodeURI( jwpn ) + "&soalan=" + encodeURI( document.getElementById("soalan").value ) +
					"&jenis=" + encodeURI( document.getElementById("jenis").value ) +
					"&ischeck=" + encodeURI( ischeck ) +
                    "&usr=" + encodeURI( document.getElementById("usr").value ) +
					"&app=" + encodeURI( document.getElementById("app").value );
			
			makePOSTRequest('post.php', poststr);
			
			}
			
		}
		//end
		
		//if jenis='true or false'
		else if(document.getElementById("jenis").value == 'truefalse'){
			
			
			for(var i = 0; i<document.myform.jwpn.length; i++){
			if(document.myform.jwpn[i].checked) {
			destination=document.myform.jwpn[i].value }
			}
			
			var poststr = "jwpn=" + encodeURI( destination ) + "&soalan=" + encodeURI( document.getElementById("soalan").value ) +
					"&jenis=" + encodeURI( document.getElementById("jenis").value ) +
                    "&usr=" + encodeURI( document.getElementById("usr").value ) +
					"&app=" + encodeURI( document.getElementById("app").value );
		
			makePOSTRequest('post.php', poststr);
			
		}
		//end
		
		
		//if jenis='ranking'
		else if(document.getElementById("jenis").value == 'ranking'){
			
			
			for(var i = 0; i<document.myform.jwpn.length; i++){
			
			jwpn =document.myform.jwpn[i].value; 
			id_pilihan =  document.myform.pilihan[i].value; 
			
			var poststr = "jwpn=" + encodeURI( jwpn ) + "&soalan=" + encodeURI( document.getElementById("soalan").value ) +
					"&jenis=" + encodeURI( document.getElementById("jenis").value ) +
					"&id_pilihan=" + encodeURI( id_pilihan ) +
                    "&usr=" + encodeURI( document.getElementById("usr").value ) +
					"&app=" + encodeURI( document.getElementById("app").value );
		
			makePOSTRequest('post.php', poststr);
			
			}
			
			
			
			
		}
		//end
		
		
		}
		
		
	 
   }
   
   
   
   function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	function saveMasa() {		
		
		masa = window.parent.parentform.document.getElementById('ParentMasa').value;
		idpermohonan = document.getElementById('app').value;
		
		strURL = 'post.php?masa='+masa+'&idmohon='+idpermohonan;
		
		var req = getXMLHTTP();
		
		if (req) {
				
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
	
	
	function saveMasa2(id) {		
		
		masa = window.parent.parentform.document.getElementById('ParentMasa').value;
		idpermohonan=id;
		
		
		strURL = 'post.php?masa='+masa+'&idmohon='+idpermohonan;
		
		var req = getXMLHTTP();
		
		if (req) {
				
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
   