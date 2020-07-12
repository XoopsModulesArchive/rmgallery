<?php
// $Id: navigation.php,v 1.0 25/03/2005 18:26:00 AdminOne Exp $
//  ------------------------------------------------------------------------ //
//            RM+SOFT GS - Sistema de Galería Fotográfica en Línea           //
//             Copyright Red México Soft © 2005. (Eduardo Cortés) 	         //
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

/**
 *	NavigationBar ordena la barra de navegación
 *	dependiendo del elemento actual
 *
 *	@Params	$by: Elemento en por el que se busca (pic, cat, home)
 *
 */
function NavigationBar($by = "home", $ide = 0){
	global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $xoopsModule;
	
	$xoopsTpl->append('navigation', array('text'=>$xoopsModuleConfig['galname'],'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()));
	switch ($by){
		case "pic":
			$result = $xoopsDB->query("SELECT catego, titulo FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE idpic='$ide';");
			$num = $xoopsDB->getRowsNum($result);
			if ($num<=0){ return; }
			$row = $xoopsDB->fetchArray($result);
			getParentCatNav($row['catego']);
			$xoopsTpl->append('navigation', array('text'=>$row['titulo'],'link'=>''));
			break;
		case "cat":
			
			$result = $xoopsDB->query("SELECT idcat, titulo, parent FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$ide' ;");
			$num = $xoopsDB->getRowsNum($result);
			if ($num<=0){ return; }
			$row = $xoopsDB->fetchArray($result);
			if ($row['parent']>0){ getParentCatNav($row['parent']); }
			$xoopsTpl->append('navigation', array('text'=>$row['titulo'],'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=".$row['idcat']));
			break;
		default:
			return;
			break;
	}
	return;
}

function getParentCatNav($idc){
	global $xoopsDB, $xoopsTpl, $xoopsModule;
	
	$result = $xoopsDB->query("SELECT idcat, titulo, parent FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc' ;");
	$num = $xoopsDB->getRowsNum($result);
	if ($num<=0){ return; }
	$row = $xoopsDB->fetchArray($result);
	if ($row['parent']>0){ getParentCatNav($row['parent']); }
	$xoopsTpl->append('navigation', array('text'=>$row['titulo'],'link'=>XOOPS_URL."/modules/".$xoopsModule->dirname()."/categos.php?idcat=".$row['idcat']));
	return;
}

function ItemsPorPagina(){
	global $xoopsModuleConfig, $xoopsTpl;
	$itemsxpag = $_SESSION['itemsxpag'];
	/* Lista de items por páginas */
	if ($itemsxpag <= 0){
		$itemsxpag = $xoopsModuleConfig['items'];
	}

	$items = $xoopsModuleConfig['newpics'];
	$i = 1;
	for ($i==1;$i<=10;$i++){
		if (($items * $i) == $itemsxpag){
			$xoopsTpl->append('itemsxpag', array('num'=>$items * $i, 'selected'=>'selected'));
		} else {
			$xoopsTpl->append('itemsxpag', array('num'=>$items * $i, 'selected'=>''));
		}	
	}
	return;
}

/**
 * Esta funcíon localiza la imágen anterior
 * y siguiente a la actual
 */
function PreviousNext($idp, $idc){
	global $xoopsDB, $xoopsTpl;
	if ($idp <= 0 || $idc <= 0){
		return;
	}
	
	$result = $xoopsDB->query("SELECT idpic, titulo FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idc';");
	$num = $xoopsDB->getRowsNum($result);
	if ($num <= 0){ return; }
	
	while (list($id, $titulo) = $xoopsDB->fetchRow($result)){
		
		if ($id == $idp){
			$found = 1;
		}
		
		if ($found==1){
			$xoopsTpl->assign('previd', $prev['id']);
			$xoopsTpl->assign('prev', $prev['titulo']);
			$found = 2;
		}elseif ($found==2){
			$xoopsTpl->assign('nextid', $id);
			$xoopsTpl->assign('next', $titulo);
			return;
		}
		
		$prev = array();
		$prev['id'] = $id;
		$prev['titulo'] = $titulo;
	}
}
?>