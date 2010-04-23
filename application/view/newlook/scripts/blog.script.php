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
<?php if($this->entries): ?>
<?php foreach($this->entries as $entry) { ?>
<div class="post">
    <h2 class="title"><?php echo $entry->name; ?></h2>
    <p class="meta"><?php echo $entry->short; ?></p>
    <div class="entry">
        <?php foreach(explode("\n", $entry->content) as $line) { ?>
        <p><?php echo $line; ?></p>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php else: ?>
    <p>Keine Einträge zum Anzeigen vorhanden.</p>
<?php endif; ?>