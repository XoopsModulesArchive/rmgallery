<?
// $Id: modinfo.php,v 1.0 17/03/2005 AdminOne Exp $  	             		 //
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

define("_MI_RMGAL_DESC", "RM+Soft Gallery");
#Menu del Administrador

define("_MI_RMGAL_AM1", "Management of categories");
define("_MI_RMGAL_AM2", "New category");
define("_MI_RMGAL_AM3", "Management of images");
define("_MI_RMGAL_AM4", "New image");

#Opciones de Configuraci�n
define("_MI_RMGAL_COMMENTS", "Allow comments");
define("_MI_RMGAL_COMMENTSDESC", "Users can comment the images of the galleries");
define("_MI_RMGAL_WHOCOM", "Can anonymous users send commens?");
define("_MI_RMGAL_WHOCOMDESC", "Who can send comments");
define("_MI_RMGAL_UPLOADSDESC", "Who can place their own images the galleries");
define("_MI_RMGAL_WHOUPLOAD", "Anonymous users can uplload images");
define("_MI_RMGAL_IMAGECOLS", "Number of Columns");
define('_MI_RMGAL_THUMBW','Thubnails width:');
define('_MI_RMGAL_BIGW','Normal IMages Width:');

define("_MI_RMGAL_FORMATDATE", "Date format");
define("_MI_RMGAL_GALLERYNAME", "Gallery Name");
define("_MI_RMGAL_ECARDS", "Activate E-Card");
define("_MI_RMGAL_DAYSNEW", "Limit of day to consider to a category or image New");
define("_MI_RMGAL_NEWSPIC", "Number of columns for the images");
define("_MI_RMGAL_POSTCARDSWHO", "Anonymous users can send E-Cards");
define("_MI_RMGAL_POSTCARDDAYS", "Days before deleting E-Cards");
define("_MI_RMGAL_ITEMS", "Images per page");
define("_MI_RMGAL_BODYMAIL", "Text for E-mails");
define("_MI_RMGAL_TEMPHEAD", "Hello <strong>%user</strong>:<br><br>\n%sender has sent to you E-Card from %sitename.<br><br>\n In order to see it click in the following link:<br>\n <a href='%link'>%link</a>.<br><br>\n This card will be active during %days days, later will be deleted automatically.<br><br>\nGreetings, <br><strong>%sitename</strong>.");

// Bloques
define("_MI_RMGAL_BNAME1", "New categories");
define("_MI_RMGAL_BDESC1", "Shows the recently created categories");
define("_MI_RMGAL_BNAME2", "New images");
define("_MI_RMGAL_BDESC2", "Shows the recently created images");
define("_MI_RMGAL_BNAME3", "Random image");
define("_MI_RMGAL_BDESC3", "Show random image from galleries");
define("_MI_RMGAL_BNAME4", "RM+Soft GS - Latest category");
define("_MI_RMGAL_BDESC4", "Shows the information of the latest category");

?>
