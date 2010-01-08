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

class page_Macro extends Moonlake_View_Macro {
    
    protected function prepend() {
        return "<html>\n\t<head>\n\t\t<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\n\t\t<link rel=\"stylesheet\" href=\"view/css/default.css\" type=\"text/css\" media=\"screen\" />";
    }
    protected function append() {
        return "\n\t</body>\n</html>";
    }
    protected function content() {
        return str_replace('</title>', "</title>\n\t</head>\n\t<body>", $this->content);
    }
}

?>
