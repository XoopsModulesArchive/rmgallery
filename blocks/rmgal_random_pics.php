<?php
// $Id: rmgal_random_pics.php,v 1.0 22/03/2005 AdminOne Exp $
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

function bshow_random_pics(){
	global $xoopsDB;
	
	$block = array();
	
	$num = $xoopsDB->getRowsNum($xoopsDB->query("SELECT idpic FROM ".$xoopsDB->prefix("rmgal_pics")));
	
	if ($num>1) {
		$num = $num - 1;
    	mt_srand((double)microtime()*1000000);
    	$imgnum = mt_rand(0, $num);
 	} else {
    	$imgnum = 0;
 	}
	
	$row = $xoopsDB->fetchArray($xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." LIMIT $imgnum, 1 ;"));
	$pic = array();
	$pic['id'] = $row['idpic'];
	$pic['titulo'] = $row['titulo'];
	$pic['vistas'] = $row['views'];
	$pic['categoid'] = $row['catego'];
	$row1 = $xoopsDB->fetchArray($xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$row[catego]' ;"));
	$pic['catego'] = $row1['titulo'];
	$pic['thumb'] = XOOPS_URL."/modules/rmgallery/uploads/$row1[dir]/ths/$row[thumb]";
	$block['image'][] = $pic;
	
	return $block;
}
?>