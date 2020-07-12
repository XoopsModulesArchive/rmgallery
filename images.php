<?php
// $Id: categos.php,v 1.1 24/03/2005 23:15:00 AdminOne Exp $
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

$idpic = isset($_GET['idimg']) ? $_GET['idimg'] : 0;
if ($idpic<=0){ $idpic = isset($_POST['idimg']) ? $_POST['idimg'] : 0; }
if ($idpic<=0){
	header("location: index.php");
	die();
}

include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");

$op = isset($_GET['op']) ? $_GET['op'] : '';
if ($op==''){ $op = isset($_POST['op']) ? $_POST['op'] : ''; }


/**
* Seleccionamos que accion realizar
**/
if ($op==''){
	$xoopsOption['template_main'] = 'rmgal_image_detail.html'; 
	$xoopsDB->queryF("UPDATE ".$xoopsDB->prefix("rmgal_pics")." SET `views`=`views`+1 WHERE idpic='$idpic';");
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE idpic='$idpic';");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){
		header("location: index.php");
		die();
	}

	include 'include/functions.php';
	include 'include/navigation.php';
	$row = $xoopsDB->fetchArray($result);
	
	/**
	* Comprobamos los permisos de accesos de los usuarios
	**/
	list($viewcat, $view, $upload, $postal) = $xoopsDB->fetchRow($xoopsDB->query("SELECT viewcat, viewimage, upload, postal FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$row[catego]';"));
	if ($view==1){
		// El usuario tiene permiso
	}elseif ($view==0 && $xoopsUser!=''){
		if (!$xoopsUserIsAdmin){
			redirect_header("categos.php?idcat=$row[catego]", 1, _RMGAL_IMAGE_NOTALLOW);
			die();
		}
	}elseif ($view==2 && $xoopsUser!=''){
		// El usuario tiene permiso
	}else{
		if (!$xoopsUserIsAdmin){
			redirect_header("categos.php?idcat=$row[catego]", 1, _RMGAL_IMAGE_NOTALLOW);
			die();
		}
	}

	/**
	* Cargamos las opciones de la categorías
	**/
	$CatInfo = array();
	$CatInfo = getCategoName($row['catego']);

	$xoopsTpl->assign('imagetitle', $row['titulo']);
	$xoopsTpl->assign('imagedesc', $row['desc']);
	$xoopsTpl->assign('imageid', $row['idpic']);
	$xoopsTpl->assign('imagetitle', $row['titulo']);

	$xoopsTpl->assign('imagecatego', $CatInfo['titulo']);
	$xoopsTpl->assign('imagecatego_id', $row['catego']);
	$xoopsTpl->assign('imagetitle', $row['titulo']);
	/**
	* Si la imágen esta almacenada en el servidor
	* o si ha sido dada como url
	**/
	if ($row['location']==0){
		$xoopsTpl->assign('image_file', XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/$CatInfo[dir]/$row[image]");
		$xoopsTpl->assign('image_thumb', XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/$CatInfo[dir]/ths/$row[thumb]");
	} else {
		$xoopsTpl->assign('image_file', $row['image']);
		$xoopsTpl->assign('image_thumb', $row['thumb']);
	}
	/**
	* Valores de información
	**/
	$xoopsTpl->assign('fecha', date($xoopsModuleConfig['formatdate'], $row['fecha']));
	$xoopsTpl->assign('hits', $row['views']);
	$xoopsTpl->assign('poster', GetPosterName($row['poster']));
	$xoopsTpl->assign('posterid', $row['poster']);
	$xoopsTpl->assign('image_comments', $row['comments']);
	$xoopsTpl->assign("newlink", XOOPS_URL."/modules/".$xoopsModule->dirname()."/newimage.php?idcat=".$row['catego']);

	PreviousNext($idpic, $row['catego']);

	if ($xoopsUser==''){
		$xoopsTpl->assign('canedit', 0);
		$xoopsTpl->assign('candelete', 0);
	} else {
		if ($xoopsUser->getvar('uid')==$row['poster'] || $xoopsUserIsAdmin){
			$xoopsTpl->assign("delete_link", "<a href='images.php?op=del&amp;idimg=".$row['idpic']."'><img src='images/".$xoopsConfig['language']."/delete.gif' border='0'></a>");
			$xoopsTpl->assign("edit_link", "<a href='images.php?op=edit&amp;idimg=".$row['idpic']."'><img src='images/".$xoopsConfig['language']."/edit.gif' border='0'></a>");
		}
	}

	/* Comprobamos si se pueden enviar postales */
	if ($xoopsModuleConfig['ecards']){
		if ($xoopsModuleConfig['postcardwho'] == 1){
			$xoopsTpl->assign("postal_link", "<a href='postal.php?idimg=".$row['idpic']."'><img src='images/".$xoopsConfig['language']."/postal.gif' border='0'></a>");
		}elseif ($xoopsModuleConfig['postcardwho'] == 0 && $xoopsUser!=''){
			$xoopsTpl->assign("postal_link", "<a href='postal.php?idimg=".$row['idpic']."'><img src='images/".$xoopsConfig['language']."/postal.gif' border='0'></a>");
		}
	}
	/**
	* Comprobamos quien puede enviar imágenes
	**/
	if ($upload==1){
		$xoopsTpl->assign('canupload', 1);
	} elseif ($upload==0 && $xoopsUser){
		if ($xoopsUserIsAdmin){
			$xoopsTpl->assign('canupload', 1);
		}
	} elseif ($upload==2 && $xoopsUser){
		$xoopsTpl->assign('canupload', 1);
	} else {
		$xoopsTpl->assign('canupload', 0);
	}

	NavigationBar("pic",$idpic);

	$xoopsTpl->assign('lang_desc', _RMGAL_DESCRIPTION);
	$xoopsTpl->assign('lang_date', _RMGAL_FECHA);
	$xoopsTpl->assign('lang_hits', _RMGAL_HITS);
	$xoopsTpl->assign('lang_poster', _RMGAL_POSTER);
	$xoopsTpl->assign('lang_comments', _RMGAL_COMMNETS);
	$xoopsTpl->assign('lang_catego', _RMGAL_CATEGO);
	$xoopsTpl->assign('lang_prev', _RMGAL_PREV_IMG);
	$xoopsTpl->assign('lang_next', _RMGAL_NEXT_IMG);

	// Obtenemos los tamaños
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_sizes")." WHERE id_pic='$idpic'");
	while ($row=$xoopsDB->fetchArray($result)){
		$xoopsTpl->append('sizes',array('tipo'=>$row['tipo'],'title'=>$row['text'],'file'=>$row['file']));
	}
	include XOOPS_ROOT_PATH.'/include/comment_view.php';

} elseif ($op=='del') {

	/**
	* Comprobamos que el usuario este logeado
	**/
	if (!$xoopsUser==''){
		$uid = $xoopsUser->getVar('uid');
	} else {
		redirect_header('images.php?idimg='.$idpic, 1, _RMGAL_INVALID_USER);
		die();
	}
	/**
	* Cargamos los datos de la imágen
	**/
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE idpic='$idpic'");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){ redirect_header('index.php', 1, _RMGAL_ERROR_NOIMG); die(); }
	$row = $xoopsDB->fetchArray($result);
	/**
	* Comprobamos que el usuario sea el autor de la imágen
	**/
	if ($row['poster']!=$uid && !$xoopsUserIsAdmin){
		redirect_header('index.php', 1, _RMGAL_INVALID_USER);
		die();
	}
	
	/**
	* Cargamos las opciones de la categorías
	**/
	include ('include/functions.php');
	$CatInfo = array();
	$CatInfo = getCategoName($row['catego']);
	
	if (!$ok){
		echo "<table width='70%' align='center' class='outer' cellspacing='1'>
				<tr align='center' class='odd'><td>
				<form name='frmDel' method='post' action='images.php?op=del'>
				<br>";
				if ($row['location']==0){
					echo "<img src='uploads/$CatInfo[dir]/ths/$row[thumb]' border='1'><br>";
				} else {
					echo "<img src='$row[thumb]' border='1'><br>";
				}
				echo "<br>"._RMGAL_DEL_CONFIRM."<br><br>
				<input type='submit' name='sbt' value='"._RMGAL_DELETE."'>
				<input type='button' name='cancel' value='"._RMGAL_CANCEL."' onclick='history.go(-1)'>
				<input type='hidden' name='idimg' value='$idpic'>
				<input type='hidden' name='ok' value='1'>
				</form><br><br></td></tr></table>";
				
	} else {
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix('rmgal_sizes')." WHERE id_pic='$idpic'");
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE idpic='$idpic'");
		redirect_header('categos.php?idcat='.$CatInfo['idcat'], 1, '');
		die();
	}

} elseif ($op=='edit'){
	
	include 'include/functions.php';
	include 'include/navigation.php';
		
	$uid = rmgal_check_login();
	if (!$uid){
		redirect_header('images.php?idimg='.$idpic, 1, _RMGAL_INVALID_USER);
		die();
	}
	
	/**
	* Cargamos los datos de la imágen
	**/
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE idpic='$idpic'");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){ redirect_header('index.php', 1, _RMGAL_ERROR_NOIMG); die(); }
	$row = $xoopsDB->fetchArray($result);
	/**
	* Comprobamos que el usuario sea el autor de la imágen
	**/
	if ($row['poster']!=$uid && !$xoopsUserIsAdmin){
		redirect_header('index.php', 1, _RMGAL_INVALID_USER);
		die();
	}
	/**
	* Cargamos las opciones de la categorías
	**/
	$CatInfo = array();
	$CatInfo = getCategoName($row['catego']);
	
	$xoopsOption['template_main'] = 'rmgal_edit_image.html'; 
	$xoopsTpl->assign('lng_title', _RMGAL_TITLE);
	$xoopsTpl->assign('lng_description', _RMGAL_DESCRIPTION);
	$xoopsTpl->assign('lng_catego', _RMGAL_CATEGO);
	$xoopsTpl->assign('lng_send', _RMGAL_SEND);
	$xoopsTpl->assign('lng_uploadimage',_RMGAL_EDIT_IMAGES);
	$xoopsTpl->assign('imgname',$row['titulo']);
	$xoopsTpl->assign('imgdesc',$row['desc']);
	$xoopsTpl->assign('imgid', $idpic);
	$xoopsTpl->assign('categoname', $CatInfo['titulo']);
	
	if ($row['location']){
		$xoopsTpl->assign('imgfile', $row['thumb']);
	} else {
		$xoopsTpl->assign('imgfile', "uploads/".$CatInfo['dir']."/ths/$row[thumb]");
	}
	
	CategosTreeList();
	NavigationBar("pic",$idpic);
	
} elseif ($op=='save'){
	
	include 'include/functions.php';
	include 'include/navigation.php';
		
	$uid = rmgal_check_login();
	if (!$uid){
		redirect_header('images.php?idimg='.$idpic, 1, _RMGAL_INVALID_USER);
		die();
	}
	/**
	* Cargamos los datos de la imágen
	**/
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE idpic='$idpic'");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){ redirect_header('index.php', 1, _RMGAL_ERROR_NOIMG); die(); }
	/**
	* Comprobamos que el usuario sea el autor de la imágen
	**/
	if ($row['poster']!=$uid && !$xoopsUserIsAdmin){
		redirect_header('index.php', 1, _RMGAL_INVALID_USER);
		die();
	}
	
	$titulo = $_POST['title'];
	$desc = $_POST['desc'];
	
	if ($titulo == '' || $desc == ''){
		redirect_header('images.php?op=edit&amp;idimg='.$idpic, 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	
	/**
	* Guardamos los cambios
	**/
	$xoopsDB->query("UPDATE ".$xoopsDB->prefix('rmgal_pics')." SET `titulo`='$titulo',`desc`='$desc' WHERE idpic='$idpic'");
	$err = $xoopsDB->error();
	if ($err==''){
		redirect_header('images.php?idimg='.$idpic, 1, '');
	} else {
		redirect_header('images.php?op=edit&amp;idimg='.$idpic, 1, _RMGAL_ERROR_CHANGE);
	}
	
}

include(XOOPS_ROOT_PATH."/footer.php");
?>