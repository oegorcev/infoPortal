<?php

/**
 * User list controller
 */

class UserListController extends Zend_Controller_Action
{
    private $_formFilterUsers = null;

    public function init()
    {
        parent::init();

        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('index', 'html');
    }

    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest())//if ajax
        {
            $this->_helper->layout->disableLayout();
        }


        $this->view->pageName = "User list";
        $this->_formFilterUsers = new Application_Form_FilterForTable();
        $this->view->formFilterUser = $this->_formFilterUsers;

        $tableColumns = array("First name ▼", "Last name ▼", "Middle name ▼", "Gender ▼", "Position ▼", "Age ▼");

        $this->view->tableColumns = $tableColumns;

        $users = new Application_Model_UsersMapper();
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($users->getUsersInformationForUserList()));

        $paginator->setItemCountPerPage(20);

        $page = $this->_getParam('page', 1);
        $paginator->setCurrentPageNumber($page);

        $this->view->users = $paginator->getCurrentItems();
        $this->view->paginator = $paginator;
    }

    public function paginatorAction()
    {

    }
}

