<?php
// $Id: upload.php,v 1.0 26/03/2005 22:28:00 AdminOne Exp $
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

include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$xoopsOption['template_main'] = 'rmgal_upload.html'; 

$cat = isset($_GET['cat']) ? $_GET['cat'] : 0;
if ($cat<=0){ $cat = $_POST['cat']; }
if ($cat<=0){ redirect_header('index.php',0,''); die(); }

$op = isset($_POST['op']) ? $_POST['op'] : '';

// Obtenemos los datos de la categoría
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('rmgal_categos')." WHERE idcat='$cat'");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){ redirect_header('index.php', 1, _RMGAL_ERRCATEGO_NOTFOUND); die(); }
	$row = $xoopsDB->fetchArray($result);
	
// Ver categoría
$viewcat = $row['viewcat'];

if ($viewcat != 1 && $xoopsUser==''){
	redirect_header("index.php", 1, _RMGAL_NOT_ALLOWED);
	die();
}

if ($viewcat==0 && !$xoopsUserIsAdmin){
	redirect_header("index.php", 1, _RMGAL_NOT_ALLOWED);
	die();
}

if ($viewcat==2 && $xoopsUser==''){
	redirect_header("index.php", 1, _RMGAL_FIRST_LOGIN);
	die();
}

/* Comprobamos si el usuario tiene permiso para subir imágenes */
$upload = $row['upload'];

if ($upload==1){
	$canupload = true;
}elseif ($upload==0 && $xoopsUser!=''){
	if ($xoopsUserIsAdmin){ $canupload = true;;}
}elseif ($row['upload']==2 && $xoopsUser!=''){
	$canupload = true;
} else {
	$canupload = false;
}

if (!$canupload){
	redirect_header('index.php', 1, _RMGAL_ERR_NOTUPLOAD);
	die();
}
	
include 'include/functions.php';

if ($op=='save'){
	
	/**
	* Guardamos las imágenes
	**/
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$imgurl = $_POST['imgurl'];
	$smallurl = $_POST['smallurl'];
	$small_is_url = false;
	$image_is_url = false;
	
	if ($cat<=0){
		redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_ERRCATEGO_NOTFOUND);
		die();
	}
	if ($_FILES['imagen']['tmp_name']=="" && ($imgurl=="" || $smallurl=="")){
		redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	if ($title=="" || $desc==""){
		redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	if (!is_uploaded_file($_FILES['imagen']['tmp_name'])){
		if ($imgurl==""){
			redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_CATEGO_DATAMISSING);
			die();
		}
		$image_is_url = true;
		$small_is_url = true;
	}
	
	/**
	*$num = $xoopsDB->getRowsNum($xoopsDB->query("SELECT idpic FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE `titulo`='$title' AND `catego`='$idc'"));
	*	
	*if ($num>0){
	*	redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_PICS_EXISTS);
	*	die();
	*}
	**/
	
	list($tdir) = $xoopsDB->fetchRow($xoopsDB->query("SELECT dir FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$cat'"));
	/**
	 * Modificación realizada el 22/05/2005
	 */
	$dir = XOOPS_ROOT_PATH."/modules/rmgallery/uploads/$tdir/";
	
	if ($image_is_url){ 
		$imagendb = $imgurl;
		$smalldb = $smallurl;
		$location = 1;
	} else {
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dir . $_FILES['imagen']['name'])){ 
			$imagendb = $_FILES['imagen']['name'];
			$smalldb  = $imagendb;
			rmgs_resize($dir . $imagendb, $dir . $imagendb, $xoopsModuleConfig['bigw']);
			rmgs_resize($dir . $imagendb, $dir ."ths/".$imagendb, $xoopsModuleConfig['thumbw']);
			$location = 0;
		} else {
			redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_MOVEERROR);
			die();
		}
	}
	
	$sql = "INSERT INTO ".$xoopsDB->prefix("rmgal_pics")." (`titulo`,`desc`,`catego`,`fecha`,`image`,`thumb`,`poster`,`location`)
			VALUES ('$title','$desc','$cat','".time()."','$imagendb','$smalldb','".$xoopsUser->getVar('uid')."','$location') ;";
	$xoopsDB->query($sql);
	redirect_header("categos.php?idcat=$cat", 1, _RMGAL_PICS_CREATED);
	die();
	
} else {

	include 'include/navigation.php';
	$xoopsTpl->assign('lng_title', _RMGAL_TITLE);
	$xoopsTpl->assign('lng_description', _RMGAL_DESCRIPTION);
	$xoopsTpl->assign('lng_catego', _RMGAL_CATEGO);
	$xoopsTpl->assign('lng_imagefile', _RMGAL_IMAGE_FILE);
	$xoopsTpl->assign('lng_imageurl', _RMGAL_IMAGE_URL);
	$xoopsTpl->assign('lng_thumburl', _RMGAL_THUMB_URL);
	$xoopsTpl->assign('lng_send', _RMGAL_SEND);
	$xoopsTpl->assign('lng_uploadimage',_RMGAL_UPLOAD_IMAGES);
	$xoopsTpl->assign('lng_infothumbs',_RMGAL_THUMB_INFO);
	$xoopsTpl->assign('lng_resize_info', sprintf(_RMDAL_RESIZE_INFO, $xoopsModuleConfig['bigw'], $xoopsModuleConfig['thumbw']));
	$xoopsTpl->assign('categoname', $row['titulo']);
	$xoopsTpl->assign('categodesc', $row['desc']);
	$xoopsTpl->assign('categoid', $row['idcat']);
	$xoopsTpl->assign("lang_go", _RMGAL_GO);
	
	CategosTreeList();
	NavigationBar("cat",$cat);

}

include(XOOPS_ROOT_PATH."/footer.php");
?>