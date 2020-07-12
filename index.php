<?php
// $Id: index.php,v 1.0 17/03/2005 12:01:00 AdminOne Exp $
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
$xoopsOption['template_main'] = 'rmgal_index.html'; 
include 'include/functions.php';
/**
 * Seleccionamos las categorías para presentar
 * la tabla.
 **/
$xoopsTpl->assign("lang_categos", _RMGAL_CATEGOS);
$xoopsTpl->assign("lang_totalimages", _RMGAL_TOTAL_IMAGES);
$xoopsTpl->assign("lang_images", _RMGAL_IMAGES);
$xoopsTpl->assign("lang_in", _RMGAL_IN);
$xoopsTpl->assign("lang_newimages", _RMGAL_NEW_IMAGES);
$xoopsTpl->assign("gallery_name", $xoopsModuleConfig['galname']);
$xoopsTpl->assign("module_url", XOOPS_URL."/modules/".$xoopsModule->dirname());
$xoopsTpl->assign("lang_comments", _RMGAL_COMMNETS);
$xoopsTpl->assign("lang_go", _RMGAL_GO);
$xoopsTpl->assign("lang_items_page", _RMGAL_ITEMS_PAGE);

$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='0' ORDER BY titulo;");
while ($row=$xoopsDB->fetchArray($result)){
	$days = time() - $row['fecha'];
	$days = (int)($days / 86400);
	if ($days <= $xoopsModuleConfig['newdays']){
		$new = 1;
	} else {
		$new = 0;
	}

	if ($row['viewcat']==1){
		$xoopsTpl->append('categos', array('id'=>$row['idcat'], 'titulo'=>$row['titulo'],'desc'=>$row['desc'],'fecha'=>date($xoopsModuleConfig['formatdate'], $row['fecha']), 'dir'=>$row['dir'], 'new'=>$new,'images'=>CountImages($row['idcat']),'subcategos'=>SubCategosLinks($row['idcat'])));
	} elseif ($row['viewcat']==0 && $xoopsUser && $xoopsUser->isAdmin()){
		$xoopsTpl->append('categos', array('id'=>$row['idcat'], 'titulo'=>$row['titulo'],'desc'=>$row['desc'],'fecha'=>date($xoopsModuleConfig['formatdate'], $row['fecha']), 'dir'=>$row['dir'], 'new'=>$new,'images'=>CountImages($row['idcat']),'subcategos'=>SubCategosLinks($row['idcat'])));
	} elseif ($row['viewcat']==2 && $xoopsUser){
		$xoopsTpl->append('categos', array('id'=>$row['idcat'], 'titulo'=>$row['titulo'],'desc'=>$row['desc'],'fecha'=>date($xoopsModuleConfig['formatdate'], $row['fecha']), 'dir'=>$row['dir'], 'new'=>$new,'images'=>CountImages($row['idcat']),'subcategos'=>SubCategosLinks($row['idcat'])));
	}
}

list($num) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgal_pics")));
$xoopsTpl->assign('total_images', $num);
list($num) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgal_categos")));
$xoopsTpl->assign('total_categos', $num);

/* Cargamos las imágenes nuevas */
$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." ORDER BY idpic DESC LIMIT 0, $xoopsModuleConfig[newpics];");
$xoopsTpl->assign('cols', $xoopsModuleConfig['newpics']);
while ($row=$xoopsDB->fetchArray($result)){
	$CatInfo = array();
	$CatInfo = getCategoName($row['catego']);
	if ($row['location']==0){
		$filethumb = XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/$CatInfo[dir]/ths/$row[thumb]";
	} else {
		$filethumb = $row['thumb'];
	}
	$xoopsTpl->append('newpics', array('id'=>$row['idpic'],'titulo'=>$row['titulo'],'posterid'=>$row['poster'],'poster'=>GetPosterName($row['poster']),'catego'=>$CatInfo['titulo'], 'categoid'=>$row['catego'],'file'=>$filethumb,'comments'=>$row['comments']));
}

CategosTreeList(0);

$xoopsTpl->assign("script", $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']);
include(XOOPS_ROOT_PATH."/footer.php");
?>
