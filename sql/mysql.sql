-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmgal_categos`
-- 

CREATE TABLE `rmgal_categos` (
  `idcat` int(11) NOT NULL auto_increment,
  `titulo` varchar(150) NOT NULL default '',
  `desc` text NOT NULL,
  `fecha` varchar(30) NOT NULL default '',
  `upload` int(1) NOT NULL default '0',
  `viewimage` int(1) NOT NULL default '0',
  `viewcat` int(1) NOT NULL default '0',
  `postal` int(1) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  `dir` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`idcat`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmgal_pics`
-- 

CREATE TABLE `rmgal_pics` (
  `idpic` int(11) NOT NULL auto_increment,
  `titulo` varchar(150) NOT NULL default '',
  `desc` text NOT NULL,
  `catego` int(11) NOT NULL default '0',
  `views` int(11) NOT NULL default '0',
  `fecha` varchar(30) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `poster` int(11) NOT NULL default '0',
  `comments` int(11) NOT NULL default '0',
  `location` int(1) NOT NULL default '0',
  PRIMARY KEY  (`idpic`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmgal_postal`
-- 

CREATE TABLE `rmgal_postal` (
  `idpos` varchar(150) NOT NULL default '',
  `fecha` varchar(30) NOT NULL default '',
  `image` int(11) NOT NULL default '0',
  `titulo` varchar(150) NOT NULL default '',
  `mensaje` text NOT NULL,
  `bgcolor` varchar(7) NOT NULL default '',
  `textcolor` varchar(7) NOT NULL default '',
  `font` varchar(50) NOT NULL default '',
  `bordercolor` varchar(7) NOT NULL default '',
  `sender_name` varchar(150) NOT NULL default '',
  `sender_email` varchar(200) NOT NULL default '',
  `to_name` varchar(150) NOT NULL default '',
  `to_email` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`idpos`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rmgal_sizes`
-- 

CREATE TABLE `rmgal_sizes` (
  `id_size` int(11) NOT NULL auto_increment,
  `id_pic` int(11) NOT NULL default '0',
  `text` varchar(60) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `tipo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_size`)
) TYPE=MyISAM;