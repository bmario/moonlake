<?php

/* 
 * (c) 2009 2010 by Mario Bielert <mario@moonlake.de>
 *
 * This work is free software; you can redistribute it and/or modify it 
 * under the terms of the GNU General Public License as published by 
 * the Free Software Foundation; either version 2 of the License, or any later version.
 *
 * This work is distributed in the hope that it will be useful, 
 * but without any warranty; without even the implied warranty of merchantability 
 * or fitness for a particular purpose. 
 * See version 2 and version 3 of the GNU General Public License for more details. 
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the Free Software Foundation, Inc., 
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


final class Moonlake_Framework {

    /**
     * This methode initializes the framework.
     * Until now this means setting up the autoload stack.
     */
    public static function init() {
        // init exception handling
        include('library/moonlake/application/application.class.php');

        // if we get until here, we can now use Application::exceptionHandler()!

        // starting output buffering, so we can clear output if there is an
        // exception
        ob_start();

        try {
            // init autoload
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