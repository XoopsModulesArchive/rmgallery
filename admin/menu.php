<?php
// $Id: menu.php,v 1.0 17/03/2005 AdminOne Exp $  		             		 //
//  ------------------------------------------------------------------------ //
//            RM+SOFT - Sistema de Galer�a Fotogr�fica en L�nea              //
//                Copyright Red M�xico Soft � 2005. (Eduardo Cort�s)         //
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
//	bajo los t�rminos de al GNU General Public Licencse como ha sido		 //
//	publicada por The Free Software Foundation (Fundaci�n de Software Libre; //
//	en cualquier versi�n 2 de la Licencia o mas reciente.					 //
//                                                                           //
//	Este programa es distribuido esperando que sea �ltil pero SIN NINGUNA	 //
//	GARANT�A. Ver The GNU General Public License para mas detalles.			 //
//  ------------------------------------------------------------------------ //
//	Questions, Bugs or any comment plese write me						 	 //
//	Preguntas, errores o cualquier comentario escribeme						 //
//	<adminone@redmexico.com.mx>												 //
//  ------------------------------------------------------------------------ //

/* Men� para las categor�as */
$adminmenu[0]['title'] = _MI_RMGAL_AM1;
$adminmenu[0]['link'] = "admin/categos.php";
$adminmenu[1]['title'] = _MI_RMGAL_AM2;
$adminmenu[1]['link'] = "admin/categos.php?op=new";

/* Men� para las im�genes */
$adminmenu[2]['title'] = _MI_RMGAL_AM3;
$adminmenu[2]['link'] = "admin/images.php";
$adminmenu[3]['title'] = _MI_RMGAL_AM4;
$adminmenu[3]['link'] = "admin/images.php?op=new";
?>