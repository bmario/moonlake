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
 * This class is the sample controller for this framework. It's very simple and
 * only has the basic functions.
 */
class guestbook_Controller extends Moonlake_Controller_ActionController {
    
    /**
     * This action shows all entries of the guestbook.
     * Also this is the default action for this controller, so whenever this
     * controller is executed and there is no action given, this action will be
     * performed.
     *
     * This action is a must for every action controller.
     */
    public function index_Action() {

        // get the application class
        $app = $this->app;

        // get the request and the response, they are stored withhin the app.
        $request = $app->getRequest();
        $response = $app->getResponse();

        // create a view. We use the 'newlook' design.
        $view = new Moonlake_View_View('newlook');

        // create a model. Therefore, we instanciate a guestbook_Model.
        // the model abstractes the data storing from the backend.
        $model = new guestbook_Model(

                    // for this model we want to use a MySQLBackend
                    // the mysqlbackend translates our requests into mysql
                    // queries, which can be executed by the connector.
                    new Moonlake_Model_MySQLBackend(

                        // this backend should use the MySQLConnector
                        // the mysqlconnector executes the queries, which the 
                        // mysqlbackend creates.
                            
                        /* the parameter is the name of a name for the config 
                         * class. in this file is expected the following options
                         * 
                         * 'hostname' - the mysql server
                         * 'username' - the mysql user
                         * 'database' - the mysql database
                         * 'password' - the mysql password
                         */
                        new Moonlake_Model_MySQLConnector(
                                'mysql'
                 )));

        // this creates a new condition
        $cond = new Moonlake_Model_Condition();

        // set the ordering to order by 'id' descending
        // note that the field 'id' is automatically created for you by the
        // model. So don' t try to define it in guestbook_Model!
        $cond->orderby('id', 'DESC');

        // use the model to get all guestbook entries from the database.
        $entries = $model->getEntriesByCondition($cond);

        // assign the entries to the view
        $view->assign("entries", $entries);
 
        // use the view to render the view script 'guestbook' and then
        // write it to the response.
        // DON'T ECHO ANYTHING! ALLWAYS USE THE RESPONSE!
        $response->write($view->render('guestbook'));
    }

    /**
     * This action creates a new entry in the guestbook
     */
    public function newentry_Action() {

        // get the application class
        $app = $this->app;

        // get the request and the response, they are stored withhin the app.
        $request = $app->getRequest();
        $response = $app->getResponse();


        // use the validation classes to validate input

        // a validator for mail adresses
        $v_mail  = new mail_Validator();

        // a validator for strings
        $v_str   = new string_Validator();

        // first use the request to get the param and then validate it.
        $mail    = $v_mail->validate($request->getParam('mail'));
        $name    = $v_str->validate($request->getParam('name'));
        $message = $v_str->validate($request->getParam('message'));

        // set validation failures to null
        $validation_failed = null;

        // check if validation failed, or values are empty, if so, set an error
        // message
        if($mail === null or $mail == '') {
            $validation_failed = 'Die angegebene E-Mail Addresse ist nicht gültig.';
        }
        if($message === null or $message == '') {
            $validation_failed = 'Sie haben keine Nachricht angegeben.';
        }
        if($name === null or $name == '') {
            $validation_failed = 'Sie haben keinen Namen angegeben.';
        }

        // create a model instance
        $model = new guestbook_Model(
                    new Moonlake_Model_MySQLBackend(
                        new Moonlake_Model_MySQLConnector('mysql')));

        // create a view instance
        $view = new Moonlake_View_View('newlook');

        if($validation_failed === null) {
            // if validation not failed, then create an array with the new values
            $args['name']    = $name;
            $args['mail']    = $mail;
            $args['message'] = $message;

            // and create with this array a new guestbook entry in the model
            $model->createEntry($args);

            // after this, set a redirect, so refreshing can't used to post again
            $response->addHeader('Location','index.php?ctrl=guestbook');

            // end then leave this action.
            return;
        }

        // if validation failed, fill the form with the old values and set
        // a error message so the user knows, whats wrong.
        // note that $view->error = "Failure" and $view->assign("error", "Failure")
        // are equivalent
        $view->error   = $validation_failed;
        $view->newname = $name;
        $view->newmail = $mail;
        $view->newmsg  = $message;

        // this creates a new condition
        $cond = new Moonlake_Model_Condition();

        // set the ordering to order by 'id' descending
        // note that the field 'id' is automatically created for you by the
        // model. So don' t try to define it in guestbook_Model!
        $cond->orderby('id', 'DESC');

        // use the model to get all guestbook entries from the database.
        $entries = $model->getEntriesByCondition($cond);

        // assign the entries to the view
        $view->assign("entries", $entries);

        // use the view to render the view script 'guestbook' and then
        // write it to the response.
        // DON'T ECHO ANYTHING! ALLWAYS USE THE RESPONSE!
        $response->write($view->render('guestbook'));
    }
}

?>
