<?php
/*
 *       Copyright 2009 2010 Mario Bielert <mario@moonlake.de>
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

class guestbook_Controller extends Moonlake_Controller_ActionController {
    /**
     * Show all entries of the guestbook
     */
    public function index_Action() {
        $app = $this->app;
        $request = $app->getRequest();
        $response = $app->getResponse();
        $view = new Moonlake_View_View('newlook');
        $model = new guestbook_Model(new Moonlake_Model_MySQLBackend(new Moonlake_Model_MySQLConnector('mysql')));

        $cond = new Moonlake_Model_Condition();
        $cond->orderby('id', 'DESC');

        $entries = $model->getEntriesByCondition($cond);

        // assign to index_View
        $view->assign("entries", $entries);
        $response->write($view->render('guestbook'));
    }

    /**
     * Create new entry in the Guestbook
     */
    public function newentry_Action() {
        $app = $this->app;
        $request = $app->getRequest();
        $response = $app->getResponse();

        // validate input
        $v_mail  = new mail_Validator();
        $v_str     = new string_Validator();
        $mail     = $v_mail->validate($request->getParam('mail'));
        $name     = $v_str->validate($request->getParam('name'));
        $message = $v_str->validate($request->getParam('message'));

        $validation_failed = null;
        if($mail === null or $mail == '') {
            $validation_failed = 'Die angegebene E-Mail Addresse ist nicht gültig.';
        }
        if($message === null or $message == '') {
            $validation_failed = 'Sie haben keine Nachricht angegeben.';
        }
        if($name === null or $name == '') {
            $validation_failed = 'Sie haben keinen Namen angegeben.';
        }

        // model instance
        $model = new guestbook_Model(new Moonlake_Model_MySQLBackend(new Moonlake_Model_MySQLConnector('mysql')));
        // view instance
        $view = new Moonlake_View_View('newlook');

        if($validation_failed === null) {
            // new entry
            // $args = array();
            $args['name'] = $request->getParam("name");
            $args['mail'] = $request->getParam("mail");
            $args['message'] = $request->getParam("message");
            $model->createEntry($args);
            $response->addHeader('Location','index.php?ctrl=guestbook');
        }
        else{
            $view->error   = $validation_failed;
            $view->newname = $name;
            $view->newmail = $mail;
            $view->newmsg  = $message;
        }

        // load entries from Model:
        $cond = new Moonlake_Model_Condition();
        $cond->orderby('id', 'DESC');
        $entries = $model->getEntriesByCondition($cond);

        // assign to index_View
        $view->assign("entries", $entries);
        // render index_View
        $response->write($view->render('guestbook'));
    }
}

?>
