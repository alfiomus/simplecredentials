<!doctype html>
<html>
<head>
<title>ValPS - Professional Services</title>
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
<style type="text/css">

body {
	background-image: url(images/fondo2.jpg);
}
.Estilo4 {font-family: Calibri; font-size: 16px; color: #999999; }
.Estilo7 {font-family: Calibri}

</style></head>
<body>
<div id="content2">
  <div id="innerholder2">
     <h4><span></span></h4>
  </div>
</div>
<div id="content">
  <div id="innerholder">
    <h3><span></span><hr></h3>
		<form action="index.php" name="loginform" method="post">
        	<div>
            	<div class="Estilo4" id="label"><span class="Estilo7">Usuario: </span>            	  
            	  <div class=roundedfield>
				  <input name="UserNameEntryField" type="text"/>
                </div>
          </div>
            <div>
            <div id="label"><span class="Estilo4">Clave: </span>
                <div class=roundedfield>  
				  <input type="password" name="Password" />
                </div>
            </div>
            <input type="submit" value="ENTRAR" id="loginbutton" name="loginbutton"/>
		</form>
  </div>
</div>
<div style="position:absolute; background-color: transparent; width: 400px; height: 400px; top: 258px; left: 750px">
	<?php
	$contenido=file_get_contents("http://www.amware.com.ar/news/");
	echo $contenido;
	?>
</div>
</body>
</html>