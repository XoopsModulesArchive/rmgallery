<?
// $Id: index.php,v 1.0 17/03/2005 AdminOne Exp $  		             		 //
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

xoops_cp_header();
echo "<table width='60%' class='outer' cellspacing='1' align='center'>\n
		<tr class='head'><td align='center' height='10'></td></tr>
		<tr class='even'><td align='center'>\n
		<a href='categos.php'>"._RMGAL_CATEGOTITLE."</a></td></tr>
		<tr class='odd'><td align='center'>\n
		<a href='categos.php?op=new'>"._RMGAL_NEW_CATEGO."</a></td></tr>
		<tr class='head'><td align='center' height='10'></td></tr>
		<tr class='even'><td align='center'>\n
		<a href='images.php'>"._RMGAL_IMAGES_LIST."</a></td></tr>
		<tr class='odd'><td align='center'>\n
		<a href='images.php?op=new'>"._RMGAL_NEW_IMAGE."</a></td></tr>
		</table>";
xoops_cp_footer();
?>