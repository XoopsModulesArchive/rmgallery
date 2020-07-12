<?php
// $Id: functions.php,v 1.0 18/03/2005 AdminOne Exp $  		             		 //
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

function GetXoopsUser($idu = 0){
	global $xoopsDB;
	
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("users")." WHERE uid='$idu'");
	$num = $xoopsDB->getRowsNum($result);
	
	if ($num<=0){
		return;
	}
	
	$row = $xoopsDB->fetchArray($result);
	return $row;
}

/**
 * Delete a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.2
 * @param       string   $dirname    Directory to delete
 * @return      bool     Returns TRUE on success, FALSE on failure
 */
function rmdirr($dirname)
{
    // Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
 
    // Simple delete for a file
    if (is_file($dirname)) {
        return unlink($dirname);
    }
 
    // Loop through the folder
    $dir = dir($dirname);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
 
        // Recurse
        rmdirr("$dirname/$entry");
    }
 
    // Clean up
    $dir->close();
    return rmdir($dirname);
}



/***
* Enumera todas las categorías existentes por padre e hijos
*
***/
$saltos = 0;

function SubCategosTree($idc, $parent = 0, $catego = 0){
	global $xoopsDB, $saltos;
	
	$saltos += 2;
	$starts .= str_repeat("-", $saltos);
	
	$result = $xoopsDB->query("SELECT idcat, titulo FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idc' ORDER BY titulo ;");
	while ($row = $xoopsDB->fetchArray($result)){
		if ($catego == $row['idcat']){
			$rtn .= "<option value='$row[idcat]' selected>$starts $row[titulo]</option>\n";
		} elseif($row['idcat'] != $catego) {
			$rtn .= "<option value='$row[idcat]'>$starts $row[titulo]</option>\n";
		}
		$rtn .= SubCategosTree($row['idcat'], $parent, $catego);
	}
	$saltos -= 2;
	return $rtn;
}

function CategosTreeOption($parent = 0, $catego = 0){
	global $xoopsDB;
	
	$result = $xoopsDB->query("SELECT idcat, titulo FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='0' ORDER BY titulo");
	while($row=$xoopsDB->fetchArray($result)){
		if ($parent==$row['idcat'] && $catego != $row['idcat']){
			$rtn .= "<option value='$row[idcat]' style='background-color: #EBEBEB;' selected>$row[titulo]</option>\n";
		} elseif ($catego != $row['idcat']) {
			$rtn .= "<option value='$row[idcat]' style='background-color: #EBEBEB;'>$row[titulo]</option>\n";
		}
		$rtn .= SubCategosTree($row['idcat'], $parent, $catego);
	}
	return $rtn;
}

function SubCategosTreeList($idc, $parent = 0, $catego = 0){
	global $xoopsDB, $saltos, $xoopsTpl;
	$starts = '';
	$saltos += 2;
	$starts .= str_repeat("-", $saltos);
	
	$result = $xoopsDB->query("SELECT idcat, titulo, parent FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idc' ORDER BY titulo ;");
	while ($row = $xoopsDB->fetchArray($result)){
		if ($catego == $row['idcat']){
			$xoopsTpl->append('categostree', array('id'=>$row['idcat'],'selected'=>1,'titulo'=>$starts." ".$row['titulo'],'type'=>1));
		} elseif($row['idcat'] != $catego) {
			$xoopsTpl->append('categostree', array('id'=>$row['idcat'],'selected'=>0,'titulo'=>$starts." ".$row['titulo'],'type'=>1));
		}
		SubCategosTreeList($row['idcat'], $row['parent'], $catego);
	}
	$saltos -= 2;
	return;
}

function CategosTreeList($catego = 0){
	global $xoopsDB, $xoopsTpl;
	$xoopsTpl->append('categostree', array('id'=>0,'selected'=>0,'titulo'=>_RMGAL_SELECT_CATEGO,'type'=>1));
	$xoopsTpl->append('categostree', array('id'=>0,'selected'=>0,'titulo'=>"---------------------",'type'=>1));
	$result = $xoopsDB->query("SELECT idcat, titulo, parent FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='0' ORDER BY titulo");
	while($row=$xoopsDB->fetchArray($result)){
		if ($catego == $row['idcat']){
			$xoopsTpl->append('categostree', array('id'=>$row['idcat'],'selected'=>1,'titulo'=>$row['titulo'], 'type'=>0));
		} elseif ($catego != $row['idcat']) {
			$xoopsTpl->append('categostree', array('id'=>$row['idcat'],'selected'=>0,'titulo'=>$row['titulo'], 'type'=>0));
		}
		SubCategosTreeList($row['idcat'], $row['parent'], $catego);
	}
	return;
	$saltos = 0;
}

function CountImages($idcat){
	global $xoopsDB;
	
	$rtn = 0;
	$num = $xoopsDB->getRowsNum($xoopsDB->query("SELECT idpic FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idcat' ;"));
	$rtn = $num;
	
	$result = $xoopsDB->query("SELECT idcat FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idcat' ;");
	while ($row=$xoopsDB->fetchArray($result)){
		$rtn += CountImages($row['idcat']);
	}
	
	return $rtn;
}

function SubCategosLinks($idcat){
	global $xoopsDB;
	$rtn = "";
	$result = $xoopsDB->query("SELECT idcat, titulo FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idcat' ;");
	while ($row=$xoopsDB->fetchArray($result)){
		$rtn .= "<a href='categos.php?idcat=$row[idcat]'>$row[titulo]</a>, ";
	}
	if (substr($rtn, strlen($rtn) - 2, 2) == ", "){
		$rtn = substr($rtn, 0, strlen($rtn) - 2);
	}
	return $rtn;
}

function getCategoName($idcat){
	global $xoopsDB;
	
	if ($idcat <= 0){
		return;
	}
	
	$result = $xoopsDB->query("SELECT idcat, titulo, dir FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idcat' ;");
	$num = $xoopsDB->getRowsNum($result);
	if ($num <= 0){ return; }
	$rtn=$xoopsDB->fetchArray($result);
	return $rtn;
}

function GetPosterName($idp){
	global $xoopsDB;
	
	$result = $xoopsDB->query("SELECT uname FROM ".$xoopsDB->prefix("users")." WHERE uid='$idp';");
	$num = $xoopsDB->getRowsNum($result);
	if ($num <= 0){
		return $GLOBALS['xoopsConfig']['anonymous'];
	} else {
		list($uname) = $xoopsDB->fetchRow($result);
		return $uname;
	}
}

function rmgs_resize($source,$target,$width){
      //calculamos la altura proporcional
      $datos = getimagesize($source);
      $ratio = ($datos[0] / $width);
      $altura = round($datos[1] / $ratio);
      // esta será la nueva imagen reescalada
      $thumb = imagecreatetruecolor($width,$altura);
      $img = imagecreatefromjpeg($source);
      // con esta función la reescalamos
      imagecopyresampled ($thumb, $img, 0, 0, 0, 0, $width, $altura, $datos[0], $datos[1]);
      // la guardamos con el nombre y en el lugar que nos interesa.
      imagejpeg($thumb,$target);
} 

function rmgal_check_login(){
	global $xoopsUser;
	
	/**
	* Comprobamos que el usuario este logeado
	**/
	if ($xoopsUser==''){
		return false;
	} else {
		return $xoopsUser->getVar('uid');
	}
}

/**
* Comprueba si ya existe una imágen con nombre identico
* @titulo = Titulo de la imágen
* @action = 'save', 'mod'
* @img = Id de la imagen util cuando action = 'mod'
* @return = true si existe, false si no
**/
function check_if_exists($titulo, $action = 'save', $img = 0){
	global $xoopsDB;
	
	$sql = "SELECT COUNT(*) FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE titulo='$titulo'";
	if ($action=='mod') { $sql .= " AND idpic<>'$img'"; }
	
	list($num) = $xoopsDB->fetchRow($xoopsDB->query($sql));
	if ($num>0){ return true; } else { return false; }	
}
?>