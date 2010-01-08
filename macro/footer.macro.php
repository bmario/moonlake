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

class footer_Macro extends Moonlake_View_Macro {

    protected function prepend() {
        return '';
    }

    protected function content() {
        return "<div id=\"copy\">\n copyright {$this->assigns['cms_page_copy_year']} by <a href=\"mailto:{$this->assigns['cms_page_author_mail']}\">{$this->assigns['cms_page_author']}</a> - powered by <a href=\"http://cms.moonlake.de\">MoonlakeCMS</a>\n</div>";

    }

    protected function append() {
        return '';
    }
}

?>
