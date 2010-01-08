<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="view/css/default.css" type="text/css" media="screen" />
    <title>
        <?php echo $this->title; ?>
    </title>
	</head>
	<body>
    <macro name="section" type="top">
        <macro name="header"/>
    </macro>
    <macro name="section" type="mid">
        <macro name="layer" type="left">

        </macro>
        <macro name="layer" type="mid">
            <?php foreach($this->entries as $ref) { ?>
                <b>Benutzer:</b> <?php echo $ref['name']; ?><br/>
                <b>Mail:</b> <?php echo $ref['mail']; ?><br/>
                <b>Message:</b> <?php echo $ref['message']; ?><hr/>
            <?php } ?>

        </macro>
        <macro name="layer" type="right">

        </macro>
    </macro>
    <macro name="section" type="foot">
        <macro name="footer"/>
    </macro>

	</body>
</html>
