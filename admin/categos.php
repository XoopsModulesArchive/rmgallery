<?
// $Id: categos.php,v 1.0 17/03/2005 AdminOne Exp $  		             		 //
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
	include "../language/spanish/admin.php";
}

$saltos = 0;

function SubCategos($idc){
	global $xoopsDB, $saltos;
	$saltos += 8;
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='$idc' ORDER BY fecha ;");
	while ($row=$xoopsDB->fetchArray($result)){
		echo "<tr class='odd'><td align='left' style='padding-left: ".$saltos."px;'>\n
				<img src='../images/folder_path.gif' align='top'><img src='../images/folder_sub.gif' align='absmiddle'> $row[titulo]</td><td align='center' style='font-size: 9px;'>\n
				<a href='categos.php?op=mod&amp;idc=$row[idcat]'>Editar</a> |\n
				<a href='categos.php?op=del&amp;idc=$row[idcat]'>Eliminar</a> |\n
				<a href='categos.php?op=add&amp;parent=$row[idcat]'>Agregar Subcategoría</a></td></tr>";
		SubCategos($row['idcat']);
	}
	$saltos -= 8;
}

function ShowCategos(){
	global $xoopsDB;
	
	$sql = "SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE parent='0' ORDER BY fecha ;";
	$result = $xoopsDB->query($sql);
	include('functions.php');
	xoops_cp_header();
	rmgs_shownav();
	echo "<table width='100%' cellspacing='1' class='outer'>\n
				<tr><th colspan='2'>"._RMGAL_CATEGOTITLE."</th></tr>\n";
	
	while ($row=$xoopsDB->fetchArray($result)){
		
		echo "<tr class='even'><td align='left'><img src='../images/folder_cat.gif' align='absmiddle'> $row[titulo]</td>\n
				<td align='center' style='font-size: 9px;'>\n
				<a href='categos.php?op=mod&amp;idc=$row[idcat]'>Editar</a> |\n
				<a href='categos.php?op=del&amp;idc=$row[idcat]'>Eliminar</a> |\n
				<a href='categos.php?op=add&amp;parent=$row[idcat]'>Agregar Subcategoría</a></td></tr>\n";
		SubCategos($row['idcat']);
		
	}
	
	echo "</table>";
	xoops_cp_footer();
	
}

function NewCategoForm(){
	include 'functions.php';
	xoops_cp_header();
	rmgs_shownav();
	//NavHeader();
	include("../include/functions.php");
	$parent = $_GET['parent'];
	echo "<table width='100%' class='outer' cellspacing='1'>\n
			<form name='frmNew' method='post' action='categos.php'>
			<tr><th colspan='2'>"._RMGAL_CMCATEGO."</th></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_TITLECAT."</td>\n
			<td class='odd' align='left'><input type='text' name='title' maxlength='150' size='30'>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_DESCCAT."</td>\n
			<td class='odd' align='left'><textarea name='desc' cols='28' rows='3'></textarea>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_PARENT."</td>\n
			<td class='odd' align='left'>\n
			<select name='parent'>";
			if ($parent<=0){
				echo "<option value='0' selected>"._RMGAL_CATEGO_NOPARENT."</option>\n";
			} else {
				echo "<option value='0'>"._RMGAL_CATEGO_NOPARENT."</option>\n";
			}
			echo CategosTreeOption($parent);
	echo "	</select>
			</td></tr>\n
			<tr><th colspan='2'>"._RMGAL_CATEGO_PERMISOS."</th></tr>
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_UPLOAD."</td>\n
			<td class='odd' align='left'>
			<select name='upload'>\n
			<option value='0' selected>"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1'>"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2'>"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_VIEWCATEGO."</td>\n
			<td class='odd' align='left'>
			<select name='viewcatego'>\n
			<option value='0'>"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' selected>"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2'>"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_VIEWIMAGES."</td>\n
			<td class='odd' align='left'>
			<select name='viewimages'>\n
			<option value='0'>"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' selected>"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2'>"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_POSTAL."</td>\n
			<td class='odd' align='left'>
			<select name='postal'>\n
			<option value='0'>"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' selected>"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2'>"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>&nbsp;</td>\n
			<td class='odd' align='left'>
			<input type='hidden' name='op' value='savecatego'>
			<input type='submit' name='sbt' value='"._RMGAL_SEND."'>
			</td></tr>\n
			</form>
			</table>";
	xoops_cp_footer();
}

function ModCategoForm(){
	global $xoopsDB;
	include 'functions.php';
	xoops_cp_header();
	rmgs_shownav();
	
	$idc = $_GET['idc'];
	if ($idc<=0){
		redirect_header("categos.php", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	
	$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc'");
	$row = $xoopsDB->fetchArray($result);
	
	include("../include/functions.php");
	echo "<table width='100%' class='outer' cellspacing='1'>\n
			<form name='frmNew' method='post' action='categos.php'>
			<tr><th colspan='2'>"._RMGAL_CMCATEGO."</th></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_TITLECAT."</td>\n
			<td class='odd' align='left'><input type='text' value='$row[titulo]' name='title' maxlength='150' size='30'>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_DESCCAT."</td>\n
			<td class='odd' align='left'><textarea name='desc' cols='28' rows='3'>$row[desc]</textarea>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_PARENT."</td>\n
			<td class='odd' align='left'>\n
			<select name='parent'>";
			if ($row['parent']<=0){
				echo "<option value='0' selected>"._RMGAL_CATEGO_NOPARENT."</option>\n";
			} else {
				echo "<option value='0'>"._RMGAL_CATEGO_NOPARENT."</option>\n";
			}
			echo CategosTreeOption($row['parent'], $row['idcat']);
	echo "	</select>
			</td></tr>\n
			<tr><th colspan='2'>"._RMGAL_CATEGO_PERMISOS."</th></tr>
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_UPLOAD."</td>\n
			<td class='odd' align='left'>
			<select name='upload'>\n
			<option value='0' ";
			if ($row['upload']==0){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' ";
			if ($row['upload']==1){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2' ";
			if ($row['upload']==2){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_VIEWCATEGO."</td>\n
			<td class='odd' align='left'>
			<select name='viewcatego'>\n
			<option value='0' ";
			if ($row['viewcat']==0){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' ";
			if ($row['viewcat']==1){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2' ";
			if ($row['viewcat']==2){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_VIEWIMAGES."</td>\n
			<td class='odd' align='left'>
			<select name='viewimages'>\n
			<option value='0' ";
			if ($row['viewimage']==0){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' ";
			if ($row['viewimage']==1){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2' ";
			if ($row['viewimage']==2){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>"._RMGAL_CATEGO_POSTAL."</td>\n
			<td class='odd' align='left'>
			<select name='postal'>\n
			<option value='0' ";
			if ($row['postal']==0){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_NOBODY."</option>\n
			<option value='1' ";
			if ($row['postal']==1){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_EVERYBODY."</option>\n
			<option value='2' ";
			if ($row['postal']==2){ echo " selected"; }
	 echo ">"._RMGAL_CATEGO_REGISTERED."</option>\n
			</select>
			</td></tr>\n
			<tr><td align='left' class='even'>&nbsp;</td>\n
			<td class='odd' align='left'>
			<input type='hidden' name='op' value='savecatego'>
			<input type='hidden' name='modify' value='1'>
			<input type='hidden' name='idc' value='$idc'>
			<input type='submit' name='sbt' value='Enviar'>
			</td></tr>\n
			</form>
			</table>";
	xoops_cp_footer();
}

function SaveCatego(){
	global $xoopsDB;
	
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$upload = $_POST['upload'];
	$viewcat = $_POST['viewcatego'];
	$viewimg = $_POST['viewimages'];
	$postal = $_POST['postal'];
	$parent = $_POST['parent'];
	$idc = $_POST['idc'];
	$mod = $_POST['modify'];
	
	if ($title=="" || $desc==""){
		redirect_header("categos.php?op=new", 1, _RMGAL_CATEGO_DATAMISSING);
		die();
	}
	
	if ($mod){
		if ($idc<=0){
			redirect_header("categos.php?op=mod&amp;$idc", 1, _RMGAL_CATEGO_NOTFOUND);
			die();
		}
		$num = $xoopsDB->getRowsNum($xoopsDB->query("SELECT idcat FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc'"));
		if ($num<=0){
			redirect_header("categos.php?op=mod&amp;$idc", 1, _RMGAL_CATEGO_NOTFOUND);
			die();
		}
		$sql = "UPDATE ".$xoopsDB->prefix("rmgal_categos")." SET `titulo` = '$title', `desc` = '$desc', `fecha` = '".time()."', `upload` = '$upload',
				`viewimage` = '$viewimg', `viewcat` = '$viewcat', `postal` = '$postal', `parent` = '$parent' WHERE idcat='$idc';";
		$xoopsDB->query($sql);
		redirect_header("categos.php", 1, _RMGAL_CATEGO_CREATED);
		die();
	} else {
		$result = $xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE cat_title='$_POST[title]'");
		$num = $xoopsDB->getRowsNum($result);
		if ($num>0){
			redirect_header("categos.php?op=new&amp;$idc", 1, _RMGAL_CATEGO_EXISTS);
			die();
		}
		
		list($num) = $xoopsDB->fetchRow($xoopsDB->query("SELECT idcat FROM ".$xoopsDB->prefix("rmgal_categos")." ORDER BY idcat DESC LIMIT 1 ;"));
		$dir = XOOPS_ROOT_PATH."/modules/rmgallery/uploads/media".($num + 1);
		mkdir($dir, 0777);
		$dir .= "/ths";
		mkdir($dir, 0777);
		
		$xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("rmgal_categos")." (`titulo`,`desc`,`fecha`,`upload`,`viewimage`,`viewcat`,`postal`,`parent`,`dir`) 
						VALUES ('$title','$desc','".time()."','$upload','$viewimg','$viewcat','$postal','$parent','media".($num + 1)."') ;");
		
		redirect_header('categos.php', 1, _RMGAL_CATEGO_CREATED);
		die();
	}
}

function DeleteCatego(){
	global $xoopsDB;
	
	$ok = $_POST['ok'];
	
	if ($ok){
		$idc = $_POST['idc'];
		
		if ($idc <= 0){
			redirect_header("categos.php?op=new", 1, _RMGAL_CATEGO_DATAMISSING);
			die();
		}
		
		$parent = $xoopsDB->fetchRow($xoopsDB->query("SELECT parent FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc' ;"));
		$xoopsDB->query("UPDATE ".$xoopsDB->prefix("rmgal_categos")." SET `parent`='$parent' WHERE parent='$idc' ;");
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgal_categos")." WHERE idcat='$idc'");
		$xoopsDB->query("DELETE FROM ".$xoopsDB->prefix("rmgal_pics")." WHERE catego='$idc'");
		redirect_header("categos.php", 1, _RMGAL_OKDELETED);
		die();
		
	} else {
		include 'functions.php';
		xoops_cp_header();
		rmgs_shownav();
		echo "<table width='60%' class='outer' cellspacing='1' align='center'>\n
				<tr class='even'><td align='center'>\n<br>
				"._RMGAL_CONFIRM_DELCAT."<br><br><form name='delcat' method='post' action='categos.php'>\n
				<input type='submit' name='sbt' value='"._RMGAL_DELETE."'>\n
				<input type='button' name='cancel' value='"._RMGAL_CANCEL."' onclick='javascript: history.go(-1)'>\n
				<input type='hidden' name='op' value='del'>\n
				<input type='hidden' name='ok' value='1'>\n
				<input type='hidden' name='idc' value='$_GET[idc]'>\n
				</form></td></tr></table>";
		xoops_cp_footer();
	}
}

$op = $_GET['op'];
if ($op==""){ $op = $_POST['op']; }

switch ($op){
	case "new":
		NewCategoForm();
		break;
	case "savecatego":
		SaveCatego();
		break;
	case "mod":
		ModCategoForm();
		break;
	case "del":
		DeleteCatego();
		break;
	case "add":
		NewCategoForm();
		break;
	default:
		ShowCategos();
		break;
}
?>
