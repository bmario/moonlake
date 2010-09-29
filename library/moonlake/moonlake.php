<?php

/*
 *  Moonlake Framework
 *
 *  A tiny framework written for PHP 5.2
 *
 *  (c) 2009 2010 by Mario Bielert <mario@moonlake.de>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

final class Moonlake_Framework {

    /**
     * This methode initializes the framework.
     * Until now this means setting up the autoload stack.
     */
    public static function init() {
        // init exception handling
        include_once('library/moonlake/application/application.php');

        // if we get until here, we can now use Application::exceptionHandler()!

        // starting output buffering, so we can clear output if there is an
        // exception
        ob_start();

        try {
            // init autoload
            include_once('library/moonlake/autoload/autoload.php');
            Moonlake_Autoload_Autoload::initAutoload();

            // <-- maybe doing some more init in here :)


            // --> init end
        }
        // catching ALL exceptions and give it to the handler
        catch(Exception $e) {
            // cleaning any previous output
            ob_clean();

            // call exception handler, so we get nice output
            Moonlake_Application_Application::exceptionHandler($e);
        }
    }


    /**
     * This methode excutes an application.
     * @param Moonlake_Application_Application $app
     */
    public static function run(Moonlake_Application_Application $app) {
        // ob_start() not needed here, because we startet it allready in init()
        try {
            // init application
            $app->init();

            // run front controller
            $app->getFrontCtrl()->handleRequest();
        }
        // catch ALL exceptions
        catch (Exception $e) {
            // FIXME think about suppressing debug output. (Well overriding
            // Application::exceptionHandler does this stuff.)

            // clear all output so we have only our debug output!
            ob_clean();

            // call the handler for exceptions
            $app->exceptionHandler($e);
        }
    }
}

?>