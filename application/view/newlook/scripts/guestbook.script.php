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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Mein Gästebuch</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
<?php foreach($this->entries as $entry) { ?>
        <a href="mailto:<?php $this->escape($entry->mail); ?>"><b><?php $this->escape($entry->name); ?></b></a><br>
        <p><?php echo $entry->message; ?></p>
        <hr>
<?php } ?>
        <form action="index.php?ctrl=guestbook&action=newentry" method="post">
            <font color="red"><?php echo $this->error; ?></font><br />
            <b> Einen Eintrag verfassen </b><br>
            Dein Name: <input type="text" name="name" value="<?php echo $this->newname; ?>"><br>
            Deine Email: <input type="text" name="mail" value="<?php echo $this->newmail; ?>"><br>
            Deine Nachricht: <textarea name="message"><?php echo $this->newmsg; ?></textarea><br>
            <input type="submit">
        </form>
    </body>
</html>