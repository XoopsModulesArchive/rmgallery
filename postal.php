<?php
// $Id: postal.php,v 1.0 26/03/2005 19:26:00 AdminOne Exp $
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

function SendPostcard(){
	global $xoopsDB, $xoopsModuleConfig, $xoopsConfig, $xoopsUser;
	include(XOOPS_ROOT_PATH."/class/mail/phpmailer/class.phpmailer.php");
	
	if (!$xoopsUser && $xoopsModuleConfig['postcardwho']==0){
		header("location: index.php");
		die();
	}
	
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
	
	$post_id = md5(time());
	$body = $xoopsModuleConfig['bodymail'];
	$body = str_replace("%user", $toname, $body);
	$body = str_replace("%sender", $sendername, $body);
	$body = str_replace("%sitename", $xoopsConfig['sitename'], $body);
	$body = str_replace("%link", XOOPS_URL."/modules/rmgallery/postal.php?post_id=$post_id", $body);
	$body = str_replace("%days", $xoopsModuleConfig['postcarddays'], $body);
	
	$sql = "INSERT INTO ".$xoopsDB->prefix("rmgal_postal")." ( `idpos` , `fecha` , `image` ,
			`titulo` , `mensaje` , `bgcolor` , `textcolor` , `font` , `bordercolor` , `sender_name` ,
			`sender_email` , `to_name` , `to_email` ) VALUES ('$post_id','".time()."','$idimg','$desc','$msg','$bgcolor','$fontcolor',
			'$font','$bordercolor','$sendername','$sendermail','$toname','$tomail');";
	$xoopsDB->query($sql);

		$mail = new phpmailer();
		$mail->PluginDir = "";
		$mail->Mailer = "sendmail";
		$mail->From = "$sendermail";
		$mail->FromName = "$sendername";
		$mail->IsHTML(true);
		$mail->Subject = _RMGAL_POSTAL_RECEIVED;
		$mail->Body = $body;
		$mail->AddAddress($tomail);
		if ($mail->Send()){
			redirect_header('images.php?idimg=$idimg', 1, _RMGAL_SEND_SUCESS);
		} else {
			redirect_header('images.php?idimg=$idimg', 1, _RMGAL_ERROR_SENDPOSTCARD);
		}
		
		die();

}

include("../../mainfile.php");

if (isset($post_id)){
	include("preview.php");
	die();
}

$idimg = isset($_GET['idimg']) ? $_GET['idimg'] : 0;
if ($idimg <=0){ $idimg = isset($_POST['idimg']) ? $_POST['idimg'] : 0; }

if ($idimg<=0){
	header("location: index.php");
	die();
}

if (isset($_POST['preview'])){
	if ($preview == 1){ 
		include("preview.php");
		die();
	}
}

if (isset($_POST['send'])){
	SendPostcard();
	die();
}



include(XOOPS_ROOT_PATH."/header.php");
$xoopsOption['template_main'] = 'rmgal_postcard_new.html';

/* Eliminamos las postales viejas */
$tdays = $xoopsModuleConfig['postcarddays'] * 86400;
$result = $xoopsDB->query("SELECT idpos, fecha FROM ".$xoopsDB->prefix("rmgal_postal"));
$todel = array();
while (list($idp, $fecha)=$xoopsDB->fetchRow($result)){
	if ((time() - $fecha) > $tdays){
		$todel[] = $idp;
	}
}

for ($i=0;$i<count($todel);$i++){
	$xoopsDB->queryF("DELETE FROM ".$xoopsDB->prefix("rmgal_postal")." WHERE `idpos` = '$todel[$i]';");
}

if ($xoopsModuleConfig['postcardwho']==0 && !$xoopsUser){
	header("location: images.php?idimg=$idimg");
	die();
}
include ("include/functions.php");

$xoopsTpl->assign('lang_sendpostcard', _RMGAL_SEND_POSTCARD);
$xoopsTpl->assign('lang_bgcolor', _RMGAL_BGCOLOR);
$xoopsTpl->assign('lang_bordercolor', _RMGAL_BORDER_COLOR);
$xoopsTpl->assign('lang_fontcolor', _RMGAL_FONT_COLOR);
$xoopsTpl->assign('lang_sender', _RMGAL_SENDER);
$xoopsTpl->assign('lang_fonttype', _RMGAL_FONT_TYPE);
$xoopsTpl->assign('lang_sendername', _RMGAL_NAME);
$xoopsTpl->assign('lang_senderemail', _RMGAL_EMAIL);
$xoopsTpl->assign('lang_shortdesc', _RMGAL_SHORT_DESC);
$xoopsTpl->assign('lang_shortdesc', _RMGAL_SHORT_DESC);
$xoopsTpl->assign('lang_msgpostcard', _RMGAL_TEXT_MSG);
$xoopsTpl->assign('lang_previewcard', _RMGAL_PREVIEW_POSTCARD);

if ($xoopsUser){
	$xoopsTpl->assign('user_name', $xoopsUser->getvar('uname'));
	$xoopsTpl->assign('user_email', $xoopsUser->getvar('email'));
}
$xoopsTpl->assign('lang_recipient', _RMGAL_RECIPIENT);

$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE idpic='$idimg';");
$num = $xoopsDB->getRowsNum($result);
if ($num <=0){
	header("location: images.php?idimg=$idimg");
	die();
}

$row = $xoopsDB->fetchArray($result);
$catInfo = getCategoName($row['catego']);
$xoopsTpl->assign('image_title', $row['titulo']);
$xoopsTpl->assign('image_file', XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/".$catInfo['dir']."/".$row['image']);
$xoopsTpl->assign('image_id', $idimg);

include(XOOPS_ROOT_PATH."/footer.php");	
?>