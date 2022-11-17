<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
  <script language="JavaScript"> 
   //Disable right click script III- By Renigade (renigade@mediaone.net) 
   //For full source code, visit [url]http://www.dynamicdrive.com[/url] 
   var message = ""; 
 
   function clickIE(){ 
    if (document.all){ 
     (message); 
     return false; 
    } 
   } 
 
   function clickNS(e){ 
    if (document.layers || (document.getElementById && !document.all)){ 
     if (e.which == 2 || e.which == 3){ 
      (message); 
      return false; 
     } 
    } 
   } 
 
   if (document.layers){ 
    document.captureEvents(Event.MOUSEDOWN); 
    document.onmousedown = clickNS; 
   } else { 
    document.onmouseup = clickNS; 
    document.oncontextmenu = clickIE; 
   } 
   document.oncontextmenu = new Function("return false") 
  </script> 
<script type="text/javascript" src="js/shadedborder.js"></script>
<link rel="shortcut icon" href="Favicon.png" type="image/png" />
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="content2">
  <div id="innerholder2">
     <h4><span></span></h4>
  </div>
</div>
<div id="content">
  <div id="innerholder">
    <h3><span></span><hr></h3>
		<form action="reposperid.php" name="paramform" method="get">
        	<div>
            	<div class="Estilo4" id="label"><span class="Estilo7">Desde Cliente: </span>            	  
				  <input name="vps_par01" type="text"/>
				</div>
            </div>
			<div>
            <div id="label"><span class="Estilo4">Hasta Cliente: </span>
				  <input type="text" name="vps_par02" />
            </div>
			<div>
            	<div class="Estilo4" id="label"><span class="Estilo7">Desde Fecha: </span>            	  
				  <input name="vps_par03" type="text"/>
				</div>
            </div>
			<div>
            <div id="label"><span class="Estilo4">Hasta Fecha: </span>
				  <input type="text" name="vps_par04" />
            </div>
			<div>
            	<div class="Estilo4" id="label"><span class="Estilo7">Desde Acuerdo: </span>            	  
				  <input name="vps_par05" type="text"/>
				</div>
            </div>
			<div>
            <div id="label"><span class="Estilo4">Hasta Acuerdo: </span>
				  <input type="text" name="vps_par06" />
            </div>
            <input type="submit" value="Aceptar" id="loginbutton" name="loginbutton"/>
		</form>
  </div>
</div>
</body>
</html>