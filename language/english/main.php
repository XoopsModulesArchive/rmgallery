<?php
// $Id: main.php,v 1.0 23/03/2005 AdminOne Exp $  	             		 //
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

define("_RMGAL_CATEGOS", "Categories");
define("_RMGAL_SUBCATEGOS", "Subcategories");
define("_RMGAL_TOTAL_IMAGES", "Images:");
define("_RMGAL_IMAGES", "Images");
define("_RMGAL_IN", "in");
define("_RMGAL_NEW_IMAGES", "New Images");
define("_RMGAL_COMMNETS", "Comments:");
define("_RMGAL_SELECT_CATEGO", "Select Category");
define("_RMGAL_GO", "Go");
define("_RMGAL_ITEMS_PAGE", "Images per page:");
define("_RMGAL_FOUND", "Found <strong>%s</strong> images in <strong>%s</strong> pages.");
define("_RMGAL_SHOWING", "Show <strong>%s</strong> from <strong>%s</strong>");
define("_RMGAL_FIRST", "First");
define("_RMGAL_LAST", "Last");
define("_RMGAL_DESCRIPTION", "Description:");
define("_RMGAL_FECHA", "Date:");
define("_RMGAL_HITS", "Hits:");
define("_RMGAL_POSTER", "Poster:");
define("_RMGAL_CATEGO", "Category:");
define("_RMGAL_PREV_IMG", "Previous");
define("_RMGAL_NEXT_IMG", "Next");
define("_RMGAL_SEND_POSTCARD", "Send E-Card");
define("_RMGAL_BGCOLOR", "Background color:");
define("_RMGAL_BORDER_COLOR", "Border color:");
define("_RMGAL_FONT_COLOR", "Font color:");
define("_RMGAL_FONT_TYPE", "Font type:");
define("_RMGAL_SENDER", "Sender");
define("_RMGAL_NAME", "Name:");
define("_RMGAL_EMAIL", "E-mail:");
define("_RMGAL_RECIPIENT", "Recipient");
define("_RMGAL_SHORT_DESC", "Short Description:");
define("_RMGAL_TEXT_MSG", "Message:");
define("_RMGAL_PREVIEW_POSTCARD", "Card preview");
define("_RMGAL_MODIFY_POSTCARD", "Modify Card");
define("_RMGAL_SEND_POSTCARDNOW", "Send card now");
define("_RMGAL_SEND_SUCESS", "Card sent successfully");
define("_RMGAL_POSTAL_RECEIVED", "Card Received!");

// Mensajes de Redirección
define("_RMGAL_NOT_ALLOWED", "You do not have permissions to see this category");
define("_RMGAL_FIRST_LOGIN", "In order to be able to see this category you login first.");
define("_RMGAL_IMAGE_NOTALLOW", "You do not have permissions to see this image.");
define("_RMGAL_ERROR_SENDERNAME", "You have not specified the name of the sender");
define("_RMGAL_ERROR_SENDERMAIL", "You have not specified the e-mail of the sender");
define("_RMGAL_ERROR_INVALIDMAILS", "The e-mail of the sender is not valid");
define("_RMGAL_ERROR_TONAME", "You have not specified the name of the recipient");
define("_RMGAL_ERROR_TOMAIL", "You have not specified the e-mail of the recipient");
define("_RMGAL_ERROR_INVALIDMAILR", "The e-mail of the recipient is not valid");
define("_RMGAL_ERROR_NODESC", "Write a short description for the E-Card");
define("_RMGAL_ERROR_NOMSG", "Write a message for the postcard");
define("_RMGAL_ERROR_NOIMG", "Image has not been specified");
define("_RMGAL_ERROR_SENDPOSTCARD", "Error happened on sending E-Card");
define("_RMGAL_ERROR_NOEXISTPOSTAL", "The requested E-Card does not exist");

?>