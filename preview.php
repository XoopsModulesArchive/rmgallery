<?php
// $Id: preview.php,v 1.0 26/03/2005 22:28:00 AdminOne Exp $
//  ------------------------------------------------------------------------ //
//            RM+SOFT - Sistema de Galería Fotográfica en Línea              //
//                Copyright Red México Soft © 2005. (Eduardo Cortés)         //
//                     <http://www.redmexico.com.mx/>                        //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//  ------------------------------------------------------------------------ //
//	Este programa es un programa libre; puedes distribuirlo y modificarlo	 //
//	bajo los términos de al GNU General Public Licencse como ha sido		 //
//	publicada por The Free Software Foundation (Fundación de Software Libre; //
//	en cualquier versión 2 de la Licencia o mas reciente.					 //
//                                                                           //
//	Este programa es distribuido esperando que sea últil pero SIN NINGUNA	 //
//	GARANTÍA. Ver The GNU General Public License para mas detalles.			 //
//  ------------------------------------------------------------------------ //
//	Questions, Bugs or any comment plese write me						 	 //
//	Preguntas, errores o cualquier comentario escribeme						 //
//	<adminone@redmexico.com.mx>												 //
//  ------------------------------------------------------------------------ //


include_once("../../mainfile.php");

if (!isset($post_id)){
	$idimg = $_POST['idimg'];
	$bgcolor = $_POST['bgcolor'];
	$bordercolor = $_POST['bordercolor'];
	$fontcolor = $_POST['fontcolor'];
	$font = $_POST['font'];
	$sendername = $_POST['sendername'];
	$sendermail = $_POST['senderemail'];
	$toname = $_POST['toname'];
	$tomail = $_POST['toemail'];
	$desc = $_POST['desc'];
	$msg = $_POST['msg'];

	if ($idimg <= 0){
		header("location: index.php");
		die();
	}

	if ($bgcolor==""){ $bgcolor = "FFFFFF"; }
	if ($bordercolor == ""){ $bordercolor == "000000"; }
	if ($fontcolor == ""){ $fontcolor = "000000"; }
	$bordercolor = "#".$bordercolor;
	$bgcolor = "#".$bgcolor;
	$fontcolor = "#".$fontcolor;
	if ($font == ""){ $font = "Verdana"; }
	if ($sendername == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_SENDERNAME);
		die();
	}
	if ($sendermail == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_SENDERMAIL);
		die();
	}
	if (!checkEmail($sendermail)){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_INVALIDMAILS);
		die();
	}
	if ($toname == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_TONAME);
		die();
	}
	if ($tomail == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_TOMAIL);
		die();
	}
	if (!checkEmail($tomail)){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_INVALIDMAILR);
		die();
	}
	if ($desc == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_NODESC);
		die();
	}
	if ($msg == ""){
		redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_NOMSG);
		die();
	}
}else{
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_postal")." WHERE idpos='$post_id';");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){
		redirect_header("index.php", 1, _RMGAL_ERROR_NOEXISTPOSTAL);
		die();
	}
	$row = $xoopsDB->fetchArray($result);
	$idimg = $row['image'];
	$bgcolor = $row['bgcolor'];
	$bordercolor = $row['bordercolor'];
	$fontcolor = $row['textcolor'];
	$font = $row['font'];
	$sendername = $row['sender_name'];
	$sendermail = $row['sender_email'];
	$desc = $row['titulo'];
	$msg = $row['mensaje'];
}

/* Buscamos la información de la imagen */
$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE idpic='$idimg';");
$num = $xoopsDB->getRowsNum($result);
if ($num<=0){
	redirect_header("postal.php?idimg=$idimg", 1, _RMGAL_ERROR_NOIMG);
	die();
}

include("include/functions.php");

$row = $xoopsDB->fetchArray($result);
$image_title = $row['titulo'];
$image_id = $row['idpic'];
$catInfo = getCategoName($row['catego']);
$image_file = XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/".$catInfo['dir']."/".$row['image'];

/* Encontramos la anchura dela imágen */
//$img = ImageCreateFromJpeg(XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/uploads/".$catInfo['dir']."/".$row['image']);
//$image_width = imagesx($img);

//unset($img);

$postcard_title = $desc;
$postcard_msg = $msg;

echo "<html><head><title>".$xoopsModuleConfig['galname']."</title></head><body bgcolor=#FFFFFF style='font-family: Helvetica, Verdana, sans-serif; font-size: 11px; font-weight: normal;'>";
include("templates/rmgal_postal.html");
echo "<br><br><center>";
if ($preview==1){
	echo "<form name='frmPost' method='post' action='postal.php'>\n
			<input type='hidden' name='bgcolor' value='$bgcolor'>\n
			<input type='hidden' name='idimg' value='$idimg'>\n
			<input type='hidden' name='bordercolor' value='$bordercolor'>\n
			<input type='hidden' name='fontcolor' value='$fontcolor'>\n
			<input type='hidden' name='font' value='$font'>\n
			<input type='hidden' name='sendername' value='$sendername'>\n
			<input type='hidden' name='senderemail' value='$sendermail'>\n
			<input type='hidden' name='toname' value='$toname'>\n
			<input type='hidden' name='toemail' value='$tomail'>\n
			<input type='hidden' name='desc' value='$desc'>\n
			<input type='hidden' name='msg' value='$msg'>\n
			<input type='hidden' name='send' value='1'>\n
			<input type='button' name='cancel' value='"._RMGAL_MODIFY_POSTCARD."' onclick='javascript: history.go(-1);'>\n
			<input type='submit' name='sbt' value='"._RMGAL_SEND_POSTCARDNOW."'>\n</form>";
}
echo "Powered By <span style='font-family: Helvetica, Verdana Arial, sans-serif; font-size: 11px; font-weight: bolder; color: #000000;'>RM+Soft Gallery System</span> 1.0<br>
		Copyright &copy; 2005. <strong><a href='http://www.redmexico.com.mx/'>Red México Soft</a> (redmexico.com.mx)</strong>.";
echo "</body></html>";
?>