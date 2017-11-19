<?php

/**
 * User information controller
 */

class UserInformationController extends Zend_Controller_Action
{

    private $_formShowUser = null;

    public function init()
    {
        $this->view->pageName = "Show user information";
        $this->_formShowUser = new Application_Form_ShowUserInformation();
        $this->view->formShowUser = $this->_formShowUser;
    }

    public function indexAction()
    {
        // action body
    }


}

