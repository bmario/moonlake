<html>
	<head>
    <title>
        moonlakefw
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
            <?php echo $this->greeting; ?>
            <?php foreach($this->users as $ref) { ?>
                Benutzer: <?php echo $ref['name']; ?><br/>
                Mail: <?php echo $ref['mail']; ?><hr/>
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
