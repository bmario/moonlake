<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="view/css/default.css" type="text/css" media="screen" />
    <title>
        moonlake.de - <?php echo $this->cms_page_title; ?>
    </title>
	</head>
	<body>
    
        <div id="header"><span class="heading">moonlake.de <sub>Home</sub></span></div>
        <macro name="breadcrumb"/>
    
    <table id="mid"><tr>
        <td id="navleft">
            <macro name="menu_list"/>
        </td>
        <td id="content">
            <?php echo $this->content; ?>
        </td>
        <td id="navright">
            <macro name="login_form"/>
        </td>
    </tr></table>
    
        <div id="copy">
 copyright 2009 by <a href="mailto:mario@moonlake.de">Mario Bielert</a> - powered by <a href="http://cms.moonlake.de">MoonlakeCMS</a>
</div>
    

	</body>
</html>
