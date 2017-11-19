<?php

/**
 * Register Form
 */

class Application_Form_Register extends Zend_Form
{

    private $_dropDown;

    function setData()
    {
        $dbMapper = new Application_Model_UsersMapper();

        $positions = $dbMapper->getAllPositions();

        $posArray = array();

        foreach ($positions as $position){

            $posArray[$position["name"]] = $position["name"];
        }

       // Zend_Debug::dump($posArray);die;
        $this->_dropDown->addMultiOptions($posArray);

    }

    public function init()
    {
        $this->setAttrib("id", "form_register");
        $this->setAttrib("class", "form_signin");

        $this->setAction('/sign-in/register')
            ->setMethod('post');

        $email = $this->createElement('text', 'email');
        $email->setAttrib("class", "form-control")
            ->addValidator('EmailAddress')
            ->setRequired(true)
            ->addFilter('StringToLower')
            ->setLabel("Email:");

        $password = $this->createElement('password', 'password');
        $password->addValidator('StringLength', false, array(6))
            ->setAttrib("class", "form-control")
            ->setRequired(true)
            ->setLabel("Password:");

        $rePassword = $this->createElement('password', 'Retype_password');
        $rePassword->addValidator('StringLength', false, array(6))
            ->setAttrib("class", "form-control")
            ->setRequired(true)
            ->setLabel("Retype password:")
            ->addValidator(new Zend_Validate_Identical('password'));

        $this->_dropDown = $this->createElement('select', 'Positions');
        $this->_dropDown->setLabel('What is your position?');

        $this->setData();

        $this->addElement($email)
            ->addElement($password)
            ->addElement($rePassword)
            ->addElement($this->_dropDown)
            ->addElement('submit', 'Register_me', array('label' => 'Register Me', 'class' => 'btn btn-success btn-block'))
            ->addElement('button', 'Back', array('label' => 'Back', 'class' => 'btn btn-danger btn-block', 'onclick' => 'callAjax("/sign-in/login")'));
    }
}

