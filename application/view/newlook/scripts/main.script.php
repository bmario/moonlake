<?php

/*
 *  Copyright 2010 Mario Bielert <mario@moonlake.de>
 *
 *  This file is part of the Moonlake Framework.
 *
 *  The Moonlake Framework is free software: you can redistribute it
 *  and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation, either version 3 of
 *  the License, or (at your option) any later version.
 *
 *  The Moonlake Framework is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with the Moonlake Framework.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : EarthlingTwo
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20090918
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="keywords" content="<?php echo $this->keywords; ?>" />
    <meta name="description" content="<?php echo $this->description; ?>" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="<?php echo $this->getBasePath(); ?>style/style.css" rel="stylesheet" type="text/css" media="screen" />

    <title><?php echo $this->page_title; ?> - Moonlake.de</title>
</head>
<body>
<div id="wrapper">
    <!-- #header -->
    <div id="header">
        <div id="logo">
            <h2><a href="http://moonlake.de/moonlake">MoonlakeDOTde</a></h2>
            <p>Codeto ergo sum!</p>
        </div>
    </div>
    <!-- end #header -->

    <!-- #menu -->
    <div id="menu">
        <ul>
            <?php
                $this->render('menu');
            ?>
        </ul>
    </div>
    <!-- end #menu -->
    <div id="page">
        <!-- content begin -->
        <div id="content"><?php echo $this->action('blog','list'); ?>

            <div style="clear: both;">&nbsp;</div>
        </div>
        <!-- end #content -->
        <div style="clear: both;">&nbsp;</div>
    </div>
    <!-- end #page -->
</div>
<div id="footer-content">
    <div class="column1">
        &nbsp;
    </div>
    <div class="column2">
    </div>
</div>
<div id="footer">
    <p>(c) 2010 moonlake.de - powered by <a href="http://fw.moonlake.de">moonlake framework</a></p>
    <p>&nbsp;</p>
    <p>Design by <a href="http://www.nodethirtythree.com">nodethirtythree</a> and <a href="http://www.freecsstemplates.org">Free CSS Templates</a>.</p>
    <p>&nbsp;</p>
    <p>
        <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
        <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS ist valide!" /></a>
    </p>
</div>
<!-- end #footer -->
</body>
</html>
