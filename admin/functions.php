<?php
///////////////////////////////////////////////////////////////////////////////
// $Id: functions.php,v 0.1 06/07/2005 14:33:31 BitC3R0 Exp $                //
// ------------------------------------------------------------------------  //
//                           RM+SOFT.Gallery.System                          //
//                     Copyright © 2005. Red Mexico Soft                     //
//                        <http://www.redmexico.com.mx>                      //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it andor modify      //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//  ------------------------------------------------------------------------ //
//  Este programa es un programa libre; puedes distribuirlo y modificarlo    //
//  bajo los términos de al GNU General Public Licencse como ha sido         //
//  publicada por The Free Software Foundation (Fundación de Software Libre; //
//  en cualquier versión 2 de la Licencia o mas reciente.                    //
//                                                                           //
//  Este programa es distribuido esperando que sea últil pero SIN NINGUNA    //
//  GARANTÍA. Ver The GNU General Public License para mas detalles.          //
//  ------------------------------------------------------------------------ //
//  Questions, Bugs or any comment plese write me                            //
//  Preguntas, errores o cualquier comentario escribeme                      //
//  <bitec3r0@hotmail.com>                                                   //
//  ------------------------------------------------------------------------ //
//                                                                           //
///////////////////////////////////////////////////////////////////////////////

function rmgs_shownav(){
	echo "<table width='100%' cellspacing='1' class='outer'>
			<tr class='even' align='center'>
			<td><a href='categos.php'>"._RMGAL_CATEGOTITLE."</a></td>
			<td><a href='categos.php?op=new'>"._RMGAL_NEW_CATEGO."</a></td>
			<td><a href='images.php'>"._RMGAL_IMAGES_LIST."</a></td>
			<td><a href='images.php?op=new'>"._RMGAL_NEW_IMAGE."</a></td></tr></table><br>";
}

?>
