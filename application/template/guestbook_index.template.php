<?php
/*
 *       Copyright 2009 Mario Bielert <mario@moonlake.de>
 *
 *       This program is free software; you can redistribute it and/or modify
 *       it under the terms of the GNU General Public License as published by
 *       the Free Software Foundation; either version 2 of the License, or
 *       (at your option) any later version.
 *
 *       This program is distributed in the hope that it will be useful,
 *       but WITHOUT ANY WARRANTY; without even the implied warranty of
 *       MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *       GNU General Public License for more details.
 *
 *       You should have received a copy of the GNU General Public License
 *       along with this program; if not, write to the Free Software
 *       Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *       MA 02110-1301, USA.
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
      <a href="mailto:<?php echo $entry['mail']; ?>"><b><?php echo $entry['name']; ?></b></a><br>
      <?php echo $entry['message']; ?>
      <hr>
    <?php } ?>
    <?php echo $this->simpleFormBuilder("guestbook", "newentry"); ?>
      <b> Einen Eintrag verfassen </b><br>
      Dein Name: <input type="text" name="name"><br>
      Deine Email: <input type="text" name="mail"><br>
      Deine Nachricht: <textarea name="message"></textarea><br>
      <input type="submit">
    </form>
  </body>
</html>