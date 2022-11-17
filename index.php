<?php

include('includes/session.php');
$title='ValPS - Professional Services';
?>
<html>
<head>
		<?php 
		echo'<title>' .$title. '</title>' 
		?>
		<link href="images/apple-touch-icon.png" rel="apple-touch-icon"/>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="shortcut icon" href="Favicon.png" type="image/png" />
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		A:link, A:visited { text-decoration: none }
		body {background-image: url(images/fondo1.jpg);	}
		.Estilo4 {font-family: Calibri; font-size: 16px; color: #cbc8c8; }
		.Estilo7 {font-family: Calibri}
		.treeMenuDefault {
		font-style: italic;
		}

		</style>
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
		<script language="javascript">
		// Función que actualiza la selección de modulo
		function gone()
		{
			location=document.mod.modulo.options[document.mod.modulo.selectedIndex].value
		}
	</script>
	<SCRIPT>
	function op() {
     // Esta funcion se utiliza en aquellos puntos donde no se abre ningun link.
	}
	</SCRIPT>
	</head>
	<FRAMESET rows="100,*" onResize="if (navigator.family == 'nn4') window.location.reload()" frameborder="no" >
		<FRAME src="header.php" name="header" scrolling="no">
		<FRAMESET cols="235,*" onResize="if (navigator.family == 'nn4') window.location.reload()"> 
			<FRAME src="menuizq.php" name="treeframe"> 
			<FRAME src="centro.php" name="basefrm"> 
		</FRAMESET>
	</FRAMESET>
</html>