<?php
// $Id: categos.php,v 1.0 24/03/2005 23:15:00 AdminOne Exp $
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

if (!isset($_GET['idcat'])){ //Si no se ha establecido el ide de categoría regresamos al home
	header("location: index.php");
	die();
}

$idcat = $_GET['idcat'];

if ($idcat<=0){ // Si no se ha especificado una categoría válida regresamos al home
	header("location: index.php");
	die();
}

include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$xoopsOption['template_main'] = 'rmgal_categos_detail.html'; 
include 'include/functions.php';
include 'include/navigation.php';

$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idcat';");
$num = $xoopsDB->getRowsNum($result);

if ($num<=0){ // Si no se ha encontrado la categoría regresamos al home
	header("location: index.php");
	die();
}

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
	$xoopsTpl->assign('upload_link', "<a href='upload.php?cat=$row[idcat]'><img src='images/".$xoopsConfig['language']."/upload.gif' border='0'></a>");
}elseif ($upload==0 && $xoopsUser!=''){
	if ($xoopsUserIsAdmin){ $xoopsTpl->assign('upload_link', "<a href='upload.php?cat=$row[idcat]'><img src='images/".$xoopsConfig['language']."/upload.gif' border='0'></a>");}
}elseif ($row['upload']==2 && $xoopsUser!=''){
	$xoopsTpl->assign('upload_link', "<a href='upload.php?cat=$row[idcat]'><img src='images/".$xoopsConfig['language']."/upload.gif' border='0'></a>");
} else {
	//Empty
}

$xoopsTpl->assign("module_url", XOOPS_URL."/modules/".$xoopsModule->dirname());
$xoopsTpl->assign('lang_categos', _RMGAL_SUBCATEGOS);
$xoopsTpl->assign("categoname", $row['titulo']);
$xoopsTpl->assign('categoid', $row['idcat']);
$xoopsTpl->assign('categodesc', $row['desc']);
$xoopsTpl->assign("newlink", XOOPS_URL."/modules/".$xoopsModule->dirname()."/newimage.php?idcat=".$row['idcat']);
$categodir = XOOPS_URL."/modules/".$xoopsModule->dirname()."/uploads/$row[dir]/";
$xoopsTpl->assign('categodir', $categodir);
$xoopsTpl->assign("lang_go", _RMGAL_GO);
$xoopsTpl->assign("lang_totalimages", _RMGAL_TOTAL_IMAGES);
$xoopsTpl->assign("lang_items_page", _RMGAL_ITEMS_PAGE);
$xoopsTpl->assign('cols', $xoopsModuleConfig['newpics']);
$xoopsTpl->assign("lang_comments", _RMGAL_COMMNETS);

$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idcat' ORDER BY titulo;");
$num = $xoopsDB->getRowsNum($result);
$xoopsTpl->assign('subcategos_count', $num);

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

if (isset($_GET['itemsxpag'])){
	//setcookie('itemsxpag', $_GET['itemsxpag'], 86400);
	$_SESSION['itemsxpag'] = $_GET['itemsxpag'];
	$limit = $_GET['itemsxpag'];
} else {
	$limit = $_SESSION['itemsxpag'];
}

if ($limit <= 0){
	$limit = $xoopsModuleConfig['items'];
	$_SESSION['itemsxpag'] = $limit;
}

if (isset($_GET['page'])){
	$page = $_GET['page'];
} else {
	$page = 0;
}
if ($page <= 0){ $page = 0; }
$start = $page * $limit;

list($numR) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idcat';"));
if ($numR > 0){ $totalPages = (int)($numR / $limit); }
if (($numR % $limit) > 0){
	$totalPages += 1;
}

$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idcat' ORDER BY titulo LIMIT $start, $limit;");
$num = $xoopsDB->getRowsNum($result);
while ($row=$xoopsDB->fetchArray($result)){
	$CatInfo = array();
	$CatInfo = getCategoName($row['catego']);
	
	$days = time() - $row['fecha'];
	$days = (int)($days / 86400);
	if ($days <= $xoopsModuleConfig['newdays']){
		$new = 1;
	} else {
		$new = 0;
	}
	if ($row['location']==0){
		$xoopsTpl->append('images', array('id'=>$row['idpic'],'titulo'=>$row['titulo'],'file'=>$categodir.$row['image'],'thumb'=>$categodir."ths/".$row['thumb'],'posterid'=>$row['poster'],'poster'=>GetPosterName($row['poster']),'catego'=>$CatInfo['titulo'], 'categoid'=>$row['catego'],'comments'=>$row['comments'],'new'=>$new));
	} else {
		$xoopsTpl->append('images', array('id'=>$row['idpic'],'titulo'=>$row['titulo'],'file'=>$row['image'],'thumb'=>$row['thumb'],'posterid'=>$row['poster'],'poster'=>GetPosterName($row['poster']),'catego'=>$CatInfo['titulo'], 'categoid'=>$row['catego'],'comments'=>$row['comments'],'new'=>$new));
	}
}

$xoopsTpl->assign("lang_found", sprintf(_RMGAL_FOUND, $numR, $totalPages));
$xoopsTpl->assign("lang_showing", sprintf(_RMGAL_SHOWING, $start+1, $start+$num));
$xoopsTpl->assign("currentpage", $page);

/* Barra de navegación de páginas */
if ($page > 0){
	$xoopsTpl->append("pagnav", array('text'=>_RMGAL_FIRST,'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=$idcat&amp;page=0"));
	$xoopsTpl->append("pagnav", array('text'=>"<<",'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=$idcat&amp;page=".($page-1)));
}

for ($i=1;$i<=$totalPages;$i++){
	$xoopsTpl->append("pagnav", array('text'=>$i,'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=$idcat&amp;page=".($i- 1)));
}

if (($page+1) < $totalPages){
	$xoopsTpl->append("pagnav", array('text'=>">>",'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=$idcat&amp;page=".($page+1)));
	$xoopsTpl->append("pagnav", array('text'=>_RMGAL_LAST,'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=$idcat&amp;page=".($totalPages - 1)));
}

NavigationBar("cat",$idcat);
CategosTreeList($idcat);
ItemsPorPagina();

include(XOOPS_ROOT_PATH."/footer.php");
?>
