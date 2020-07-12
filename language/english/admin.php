<?
// $Id: admin.php,v 1.0 17/03/2005 AdminOne Exp $  		             		 //
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

#Menu del Administrador
define("_MI_RMGAL_AM1", "Management of categories");
define("_MI_RMGAL_AM2", "New category");
define("_MI_RMGAL_AM3", "Management of images");
define("_MI_RMGAL_AM4", "New image");

define("_RMGAL_CATEGOTITLE", "Existing categories");
define("_RMGAL_NEWCATEGO", "Create category");
define("_RMGAL_CATEGOS", "List of categories");
define("_RMGAL_NOCATEGOS", "Categories still do not exist");
define("_RMGAL_CMCATEGO", "Create/modify category");
define("_RMGAL_TITLECAT", "Title");
define("_RMGAL_DESCCAT", "Description");
define("_RMGAL_CATEGO_UPLOAD", "Images uploading");
define("_RMGAL_CATEGO_NOBODY", "Administrator");
define("_RMGAL_CATEGO_EVERYBODY", "All");
define("_RMGAL_CATEGO_REGISTERED", "Registered users");
define("_RMGAL_CATEGO_VIEWCATEGO", "Show category");
define("_RMGAL_CATEGO_VIEWIMAGES", "Show images");
define("_RMGAL_CATEGO_POSTAL", "Send E-Card");
define("_RMGAL_CATEGO_PARENT", "Parent category ");
define("_RMGAL_CATEGO_NOPARENT", "None");
define("_RMGAL_CATEGO_PERMISOS", "Permissions");

/* Textos para las imágenes */
define("_RMGAL_PICS_SELCAT", "Select a category to search images");
define("_RMGAL_PICS_FIRSSEL", "Selection...");
define("_RMGAL_PICS_LIST", "List of found images");
define("_RMGAL_PICS_FILE", "File of Image");
define("_RMGAL_PICS_URL", "URL of Image");
define("_RMGAL_PICS_THUMB", "Thumbnail File");
define("_RMGAL_PICS_THUMBURL", "URL of the thumbnail");
define("_RMGAL_PICS_EXISTS", "The specified image already exists");
define("_RMGAL_PICS_CREATED", "The image has been created successfully");
define("_RMGAL_PICS_DELCONFIRM", "yDo you really want to delete this element?");
define("_RMGAL_PICS_SIZES","Other sizes of images");
define("_RMGAL_PICS_SIZEFILE","File");
define("_RMGAL_PICS_SIZETYPE","File Type");
define("_RMGAL_PICS_SIZEIMAGE","Image size");
define("_RMGAL_PICS_SIZEZIP","Tablet");
define("_RMGAL_PICS_SIZEEXIST","Existing sizes");
define("RMGAL_PICS_SIZECREATED","Size added successfully");
define("RMGAL_PICS_SIZEBACK","Return to the images");

//Mensaje de redirección
define("_RMGAL_CATEGO_NOTFOUND", "There aren't the specified category");
define("_RMGAL_CATEGO_EXISTS", "The specified category already exists");
define("_RMGAL_CATEGO_CREATED", "Category created successfully");
define("_RMGAL_CATEGO_DATAMISSING", "Data missing");
define("_RMGAL_DELETE", "Delete");
define("_RMGAL_SIZES", "Other sizes");
define("_RMGAL_CANCEL", "Cancel");
define("_RMGAL_MODIFY", "Modify");
define("_RMGAL_SEND", "Send");
define("_RMGAL_OKDELETED", "Element deleted successfully");
define("_RMGAL_CONFIRM_DELGAL", "Do you really want to remove this gallery? This action will erase the directory along with all images contained in it.");
define("_RMGAL_CONFIRM_DELCAT", "<strong>Do you really want to remove this category?</strong><br><br>Subcategories will be assigned to the parent category.");
define("_RMGAL_CATEGO", "Category");
define('_RMGAL_MOVEERROR','Error appeared on loading image');

?>
