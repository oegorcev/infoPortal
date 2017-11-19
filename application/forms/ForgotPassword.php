<?php

/**
 * Forgot password Form
 */

class Application_Form_ForgotPassword extends Zend_Form
{

    public function init()
    {
        $this->setAttrib("id", "form_forgotpas");
        $this->setAttrib("class", "form_forgotpas");

        $this->setAction('/sign-in/forgot-password')
            ->setMethod('post');

        $email = $this->createElement('text', 'email');
        $email->setRequired(true)
            ->setAttrib("class", "form-control")
            ->addValidator('EmailAddress')
            ->addValidator('stringLength', false, array(6, 20))
            ->addFilter('StringToLower')
            ->setLabel("Input your Email:");

        $this->addElement($email)
            ->addElement('submit', 'Search_user', array('label' => 'Search user', 'class' => 'btn btn-success btn-block'))
            ->addElement('button', 'Back', array('label' => 'Back', 'class' => 'btn btn-danger btn-block', 'onclick' => 'callAjax("/sign-in/login")'));
    }
}

