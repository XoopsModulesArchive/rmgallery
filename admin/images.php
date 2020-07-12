<?php
// $Id: images.php,v 1.1 17/03/2005 AdminOne Exp $  		             		 //
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

include '../../../include/cp_header.php';
if (!file_exists("../language/".$xoopsConfig['language']."/admin.php") ) {
	include_once "../language/spanish/admin.php";
}

/***
* Muestra la lista de categorías para realizar
* la busqueda de imágenes
*
* @Autor: 	AdminOne <adminone@redmexico.com.mx>
* @Params:	Sin Parámetros
***/
function ShowPics(){
	Global $xoopsDB;
	include("../include/functions.php");
	
	$idc = $_GET['idc'];
	$cPage = $_GET['page'];
	$cPage -= 1;
	if ($cPage<0){ $cPage=0; }
	$start = $cPage * 10;
	
	include 'functions.php';
	xoops_cp_header();
	rmgs_shownav();
	echo "<table width='60%' class='outer' cellspacing='1' align='center'>\n
			<tr class='even'><td align='center'>\n
			"._RMGAL_PICS_SELCAT."<br><br>
			<form name='frmCat' method='get' action='images.php'>\n
			<select name='idc'>";
			if ($idc <= 0){
				echo "<option value='0' selected>"._RMGAL_PICS_FIRSSEL."</option>\n";
			} else {
				echo "<option value='0'>"._RMGAL_PICS_FIRSSEL."</option>\n";
			}
			echo CategosTreeOption($idc);
	echo "</select> <input type='submit' name='sbt' value='"._RMGAL_SEND."'></td></tr></table><br><br>";			
	
	$row = $xoopsDB->fetchArray($xoopsDB->query("SELECT dir FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc'"));
	$dir = $row['dir'];
	$totalR = $xoopsDB->getRowsNum($xoopsDB->query("SELECT idpic FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idc'"));
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idc' ORDER BY titulo, fecha LIMIT $start, 10");
	if ($totalR > 0){ $totalPages = (int)($totalR / 10); }
	if (($totalR % 10) > 0){
		$totalPages += 1;
	}
	
	echo "<table width='100%' class='outer' cellspacing='1'>\n
			<tr><td align='left'><a href='images.php?op=new'>Nueva Imágen</a></td><td align='right' colspan='2'>";
		  
		  if (($cPage) > 0){
		  	echo "<a href='images.php?idc=$idc&amp;page=$cPage'>&lt;&lt;</a>";
		  }
		  
		  for ($i=1;$i<=$totalPages;$i++){
		  	if ($i==$cPage+1){
				echo "<a href='images.php?idc=$idc&amp;page=$i' style='color: #FF0000;'>$i</a>&nbsp;";
			} else {
				echo "<a href='images.php?idc=$idc&amp;page=$i'>$i</a>&nbsp;";
			}
		  }
		  
		  if (($cPage + 1) < $totalPages){
		  	echo "<a href='images.php?idc=$idc&amp;page=".($cPage + 2)."'>&gt;&gt;</a>";
		  }
		  
	echo "</td></tr>\n
			<tr><th colspan='3'>"._RMGAL_PICS_LIST."</th></tr>";
	while($row = $xoopsDB->fetchArray($result)){
		list($num) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("rmgal_sizes")." WHERE id_pic='$row[idpic]'"));
		echo "<tr class='even'><td align='left'>\n";
		if ($row['location']==0){
			echo "<a href='../uploads/$dir/$row[image]' target='_blank'><img src='../uploads/$dir/ths/$row[thumb]' border='0'></a></td>\n";
		} else {
			echo "<a href='$row[image]' target='_blank'><img src='$row[thumb]' border='0'></a></td>\n";
		}
		echo "<td align='left'><strong>$row[titulo]</strong><br><span style='font-family: 9px;'>$row[desc]</span><br>
			 <span style='font-size: 10px;'>".date("d/m/Y - h:i:s", $row['fecha'])."<br>\n
			 <strong>Rating:</strong> $row[views]<br>
			 <strong>Sizes: </strong> $num</span><br>
			 </td>\n
			 <td align='center'><a href='images.php?op=sizes&amp;idp=$row[idpic]'>"._RMGAL_SIZES."</a>&nbsp;|
			 <a href='images.php?op=del&amp;idc=$idc&amp;idp=$row[idpic]'>"._RMGAL_DELETE."</a></td></tr>";
	}
	echo "</table>";
	xoops_cp_footer();
}

/***
* Presenta el formulario para crear una nueva imágen
***/

function NewImageForm(){
	global $xoopsDB;
	
	$idc = $_GET['idc'];
	
	include 'functions.php';
	xoops_cp_header();
	rmgs_shownav();
	include("../include/functions.php");
	echo "<table width='80%' align='center' cellspacing='1' class='outer'>\n
		  <form name='pic' enctype='multipart/form-data' action='images.php' method='post'>\n
		  <tr><td class='even' align='left'>\n
		  "._RMGAL_TITLECAT."</td>\n
		  <td class='odd' align='left'>\n
		  <input type='text' name='title' size='30'></td></tr>
		  <tr><td class='even' align='left'>\n
		  "._RMGAL_DESCCAT."</td>\n
		  <td class='odd' align='left'>\n
		  <textarea name='desc' rows='3'></textarea></td></tr>\n
		  <tr><td class='even' align='left'>\n
		  "._RMGAL_CATEGO."</td>\n
		  <td class='odd' align='left'>\n
		  <select name='idc'>\n";
		  if ($idc<=0){
		  	echo "<option value='0' selected>"._RMGAL_PICS_FIRSSEL."</option>\n";
		  } else {
		  	echo "<option value='0'>"._RMGAL_PICS_FIRSSEL."</option>\n";
		  }
		  echo CategosTreeOption($idc);
		  
	echo "</td></tr>\n
		  <tr><td class='even' align='left'>"._RMGAL_PICS_FILE."</td>\n
		  <td class='odd' align='left'><input type='file' name='imagen' size='30'></td></tr>
		  <tr><td class='even' align='left'>"._RMGAL_PICS_URL."</td>\n
		  <td class='odd' align='left'><input type='text' name='imgurl' size='30'></td></tr>
		  <tr><td class='even' align='left'>"._RMGAL_PICS_THUMBURL."</td>\n
		  <td class='odd' align='left'><input type='text' name='smallurl' size='30'></td></tr>\n
		  <tr><td class='even'>&nbsp;</td>\n
		  <td class='odd' align='left'>
		  <input type='hidden' name='op' value='save'>\n
		  <input type='submit' name='sbt' value='"._RMGAL_SEND."'></td></tr></form></table>";
	xoops_cp_footer();
}

/***
* Guarda las imágenes y sus archivos
* Debe existir el directorio "uploads" y tener permiso de escritura
*
* @Autor:	AdminOne <adminone@redmexico.com.mx>
* @Params:	POST: formulario NewImage
***/
function SaveImage(){
	global $xoopsDB, $xoopsUser, $xoopsModuleConfig;
	$idc = $_POST['idc'];
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$imgurl = $_POST['imgurl'];
	$smallurl = $_POST['smallurl'];
	$small_is_url = false;
	$image_is_url = false;
	
	if ($idc<=0){
		redirect_header("images.php?op=new&amp;idc=$idc", 1, _RMGAL_CATEGO_NOTFOUND);
		die();
	}
	
	if ($_FILES['imagen']['tmp_name']=="" && $imgurl==""){
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
	
	list($tdir) = $xoopsDB->fetchRow($xoopsDB->query("SELECT dir FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc'"));
	/**
	 * Modificación realizada el 22/05/2005
	 */
	$dir = XOOPS_ROOT_PATH."/modules/rmgallery/uploads/$tdir/";
	include '../include/functions.php';
	if ($image_is_url){ 
		$imagendb = $imgurl;
		$smalldb = $smallurl;
		$location = 1;
	} else {
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dir.$_FILES['imagen']['name'])){ 
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
			VALUES ('$title','$desc','$idc','".time()."','$imagendb','$smalldb','".$xoopsUser->getVar(uid)."','$location') ;";
	$xoopsDB->query($sql);
	redirect_header("images.php?idc=$idc", 1, _RMGAL_PICS_CREATED);
	die();
}

function DeleteImage(){
	global $xoopsDB;
	
	if (isset($_POST['ok'])){
		$ok = $_POST['ok'];
	} else {
		$ok = 0;
	}
	
	if ($ok){
		$idc = $_POST['idc'];
		$idp = $_POST['idp'];
		
		if ($idc <= 0 || $idp <= 0){
			header("location: images.php");
			die();
		}
		
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE idpic='$idp' ;");
		redirect_header("images.php?idc=$idc", 1, _RMGAL_OKDELETED);
		die();
	} else {
		include 'functions.php';
		xoops_cp_header();
		rmgs_shownav();
		echo "<table width='60%' class='outer' cellspacing='0' align='center'>\n
				<tr class='even'><td align='center'><br><br>\n
				"._RMGAL_PICS_DELCONFIRM."<br><br>
				<form name='frmDel' method='post' action='images.php'>\n
				<input type='submit' name='sbt' value='"._RMGAL_DELETE."'>\n
				<input type='button' name='cancel' value='"._RMGAL_CANCEL."' onclick='javascript:history.go(-1);'>\n
				<input type='hidden' name='op' value='del'>\n
				<input type='hidden' name='ok' value='1'>\n
				<input type='hidden' name='idp' value='$_GET[idp]'>\n
				<input type='hidden' name='idc' value='$_GET[idc]'>\n
				</form><br></td></tr></table>";
		xoops_cp_footer();
	}
}

function ImageSizes(){
	global $xoopsDB;
	
	$idp = $_GET['idp'];
	if ($idp<=0){ header('location: images.php'); }
	
	list($idc, $titulo) = $xoopsDB->fetchRow($xoopsDB->query("SELECT catego, titulo FROM ".$xoopsDB->prefix('rmgal_pics')." WHERE idpic='$idp'"));
	
	include 'functions.php';
	xoops_cp_header();
	rmgs_shownav();
	echo "<center><a href='images.php?idc=$idc'>".RMGAL_PICS_SIZEBACK."</a></center><br>\n
	      <table width='60%' align='center' class='outer' cellspacing='1'>\n
		  <tr><th colspan='2'>"._RMGAL_PICS_SIZES."</th></tr>\n
		  <form name='frmSize' method='post' action='images.php'>\n
		  <tr><td class='even' align='left'>"._RMGAL_TITLECAT."</td>\n
		  <td class='odd' align='left'><input type='text' size='30' name='titulo'></td></tr>
		  <tr><td class='even' align='left'>"._RMGAL_PICS_SIZEFILE."</td>\n
		  <td class='odd' align='left'><input type='text' name='archivo' size='30'></td></tr>\n
		  <tr><td class='even' align='left'>"._RMGAL_PICS_SIZETYPE."</td>
		  <td class='odd' align='left'>
		  <select name='tipo'>
		    <option value='0' selected>"._RMGAL_PICS_SIZEIMAGE."</option>
			<option value='1'>"._RMGAL_PICS_SIZEZIP."</option>
		  </select>\n
		  <input type='hidden' name='op' value='newsize'>\n
		  <input type='hidden' name='idp' value='$idp'>\n
		  <input type='hidden' name='idc' value='$idc'>\n
		  </td></tr>
		  <tr><td class='even' align='left'>&nbsp;</td>\n
		  <td class='odd' align='left'><input type='submit' name='sbt' value='"._RMGAL_SEND."'></td></tr>\n
		  </form></table>";
	
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_sizes")." WHERE id_pic='$idp'");
	echo "<br><table width='60%' align='center' class='outer' cellspacing='1'>\n
			<tr><th align='left'>$titulo</th></tr>\n
			<form name='frmDel' method='post' action='images.php'>\n
			<tr><td class='even' align='left'>"._RMGAL_PICS_SIZEEXIST."<br>
			<select name='size' size='5'>";
		while ($row=$xoopsDB->fetchArray($result)){
			if ($row['tipo']==0){
				$tipo = "Imagen";
			} else {
				$tipo = "Comprimido";
			}
			echo "<option value='$row[id_size]'>$row[text] - $tipo</option>\n";
		}
	echo "</select>\n
		  <br><input type='submit' name='delete' value='"._RMGAL_DELETE."'>\n
		  <input type='hidden' name='op' value='delsize'>\n
		  <input type='hidden' name='idp' value='$idp'>\n
			</td></tr></form></table>";
	xoops_cp_footer();
}

function SaveSize(){
	global $xoopsDB, $idp;
	$titulo = $_POST['titulo'];
	$archivo = $_POST['archivo'];
	$tipo = $_POST['tipo'];
	
	if ($titulo=="" || $archivo==""){
		redirect_header("images.php?op=sizes&amp;idp=$idp", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	
	$xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("rmgal_sizes")." (`id_pic`,`text`,`file`,`tipo`) VALUES
					('$idp','$titulo','$archivo','$tipo')");
	redirect_header("images.php?op=sizes&amp;idp=$idp", 1, RMGAL_PICS_SIZECREATED);
}

function DeleteSize(){
	global $xoopsDB;
	$size = $_POST['size'];
	$idp = $_POST['idp'];
	
	if ($size<=0 || $idp<=0){
		redirect_header("images.php?op=sizes&amp;idp=$idp", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	
	$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgal_sizes")." WHERE id_pic='$idp' AND id_size='$size'");
	redirect_header("images.php?op=sizes&amp;idp=$idp", 1, "");
	
}

if (isset($_GET['op'])){
	$op = $_GET['op'];
}elseif (isset($_POST['op'])){
	$op = $_POST['op'];
}

switch ($op){
	case "new":
		NewImageform();
		break;
	case "save":
		SaveImage();
		break;
	case "del":
		DeleteImage();
		break;
	case "sizes":
		ImageSizes();
		break;
	case "newsize":
		SaveSize();
		break;
	case "delsize":
		DeleteSize();
		break;
	default:
		ShowPics();
		break;
}
?>