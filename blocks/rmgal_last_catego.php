<?php
// $Id: rmgal_last_catego.php,v 1.0 23/03/2005 AdminOne Exp $
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

function bshow_last_catego($options){
	global $xoopsDB, $xoopsModuleConfig;
	$block = array();
	/* Buscamos la ultima categoría creada */
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." ORDER BY idcat DESC LIMIT 0, $options[0];");
	$num = $xoopsDB->getRowsNum($result);
	
	if ($num <= 0){
		return;		
	}
	
	while ($row = $xoopsDB->fetchArray($result)){;
		$rtn = array();
		$rtn['id'] = $row['idcat'];
		$rtn['titulo'] = $row['titulo'];
		$rtn['desc'] = $row['desc'];
		$rtn['fecha'] = sprintf(_MB_LANG_CREATED, date($options[1], $row['fecha']));
		$r1 = $xoopsDB->query("SELECT thumb FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$row[idcat]' LIMIT 0, 1;");
		if ($xoopsDB->getRowsNum($r1) <= 0){
			$rtn['image'] = "";
		} else {
			$rw1 = $xoopsDB->fetchArray($r1);
			$rtn['image'] = XOOPS_URL."/modules/rmgallery/uploads/$row[dir]/ths/$rw1[thumb]";
		}
		
		$block['categoria'][] = $rtn;
	}
	
	return $block;
}

function bedit_last_items($options){
	$form = _MI_RMGAL_SHOW." <input type=\"text\" name=\"options[]\" value=\"$options[0]\" />";
	$form .= " "._MI_RMGAL_LAST."<br>"._MI_RMGAL_BDATEFORMAT;
	$form .= "<input type=\"text\" name=\"options[]\" value=\"$options[1]\" />";
	return $form;
}
?>