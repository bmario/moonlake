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

/**
 * This is the baseclass for every Application which uses this framework.
 */
abstract class Moonlake_Application_Application {

    /**
     * This is an array, which contains the name of
     * every controller, which is allowed to be used by the application.
     * @var String[] allowed_controller
     */
    protected $allowed_controller = array();

    /**
     * This contains the used frontcontroller.
     * @var Moonlake_Controller_FrontController
     */
    protected $frontctrl;

    /**
     * This contians the used request
     * @var Moonlake_Request_Request
     */
    protected $request;

    /**
     * This contains the used response
     * @var Moonlake_Response_Response
     */
    protected $response;

    /**
     * This methode fills the attributes above and sets the defaultcontroller
     */
    public abstract function init();

    /**
     * Return the frontcontroller
     * @return Moonlake_Controller_Front
     */
    public function getFrontCtrl() {
        return $this->frontctrl;
    }

    /**
     * This returns the actual request
     * @return Moonlake_Request_Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * This returns the actual response
     * @return Moonlake_Response_Response
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * This function creates an useful output in case of thrown exceptions.
     * This will be useful for debuging, but in productive applications, this
     * methode should be overriden to hide such things from the visitor of your
     * application.
     *
     * In case you override this function, only use plain echo, relay on nothing
     * from the framework, because you can't know, that is wrong and what you
     * can use without getting trouble.
     *
     * @param Exception $e
     */
    public static function exceptionHandler(Exception $e) {
        $message = nl2br($e->getMessage());
        $trace = '';

        foreach($e->getTrace() as $num => $line)
        {
            if(isset($line['class']) and isset($line['file']))
            {
                $trace .= "#$num {$line['file']}({$line['line']}):\n<b>{$line['class']}{$line['type']}{$line['function']}</b>(<i>";

                $i=0;
                foreach($line['args'] as $arg){
                    if($i++) $trace .=', ';
                    if(is_object($arg)) {
                        $trace .= 'Object('.get_class($arg).')';
                    }
                    else $trace .= "'$arg'";
                }

                $trace .= "</i>)\n\n";
            }
            else
            {
                // TODO
            }

        }
        
        $trace = nl2br($trace);
        echo <<<EXCEPT
<html>
    <head>
        <title>Exception in Moonlake Framework</title>
        <style type="text/css">
            body {
                margin: 0;
                padding: 25px;
                background: #F7F7F7;
                font-family: sans-serif;
                font-size: 14px;
                color: #5A554E;
            }

            h1, h2, h3 {
                margin: 0;
                padding: 0;
                font-weight: normal;
                color: #32639A;
                font-family: sans-serif;
            }

            h1 {
                font-size: 2em;
            }

            h2 {
                font-size: 2.4em;
            }

            h3 {
                font-size: 1.6em;
            }

            p, ul, ol {
                margin-top: 0;
                line-height: 200%;
                font-family:  sans-serif;
            }

            ul, ol {
                margin: 0px;
                padding: 0px;
                list-style: none;
            }

            td {
                padding: 10px 25px 10px 25px;
            }

            a {
                text-decoration: underline;
                color: #516C00;
            }

            a:hover {
                text-decoration: none;
            }

            h2 a {
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <center>
        <p>
        <h1>Moonlake Framework</h1>
        <h3>An exception happend during the execution.</h3></p>
        <table width="80%">
            <tr style="background-color: e2e2e2; vertical-align: top;">
                <td>Message:</td>
                <td>{$message}</td>
            </tr>
            <tr style="background-color: F2F2F2; vertical-align: top;">
                <td>File:</td>
                <td><pre>{$e->getFile()}</pre></td>
            </tr>
            <tr style="background-color: e2e2e2; vertical-align: top;">
                <td>Line:</td>
                <td><pre>{$e->getLine()}</pre></td>
            </tr>
            <tr style="background-color: F2F2F2; vertical-align: top;">
                <td>Trace:</td>
                <td>{$trace}</td>
            </tr>
        </table>
    </body>
</html>
EXCEPT;
    }
}

?>