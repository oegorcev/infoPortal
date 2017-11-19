<?php

/**
 * Edit Profile controller
 */

class EditProfileUserController extends Zend_Controller_Action
{

    private $_formEditUser = null;

    public function init()
    {
        $this->view->pageName = "Edit information";
        $this->_formEditUser = new Application_Form_EditProfileUser();
        $this->view->formEditUser = $this->_formEditUser;
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost() and $this->_formEditUser->isValid($this->getRequest()->getPost())) {

            $array = $this->getRequest()->getPost();

            $newUserData = array();
            $newEmails = array();
            $newPhones = array();




            while ($elem = current($array) or key($array) === "gender")
            {
                if(strpos(key($array), 'email') !== false) {
                    array_push($newEmails, $elem);
                } elseif (strpos(key($array), 'phone') !== false) {
                    array_push($newPhones, $elem);
                } elseif (strpos(key($array), 'gender') !== false) {
                    if($elem === "0") {
                        $newUserData[key($array)] = 'M';
                    }
                    else {
                        $newUserData[key($array)] = 'F';
                    }
                } elseif (strpos(key($array), 'MAX_FILE_SIZE') === false and strpos(key($array), 're_password') === false
                and strpos(key($array), 'Change') === false) {
                    $newUserData[key($array)] = $elem;
                }

                next($array);
            }



            $mapper = new Application_Model_UsersMapper();
            $curUserInfo = get_object_vars(Zend_Auth::getInstance()->getIdentity());

            $id = $mapper->getUserIdByLogin($curUserInfo['sign_in_login']);

            $mapper->deleteEmailsByUserID($id);

            foreach ($newEmails as $email)
            {
                $mapper->insertEmail($id, $email);
            }

            $mapper->deletePhonesByUserID($id);

            foreach ($newPhones as $phone)
            {
                $mapper->insertPhone($id, $phone);
            }

            $mapper->updateUserInformation($newUserData, $id);

            $this->_helper->redirector('index', 'user-information');
        }
    }


}

