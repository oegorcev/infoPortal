<?php

/**
 * Login Form
 */

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setAttrib("id", "form_signin");
        $this->setAttrib("class", "form_signin");

        $this->setAction('/sign-in/login')
            ->setMethod('post');

        $email = $this->createElement('text', 'email');
        $email->setRequired(true)
            ->setAttrib("class", "form-control")
            ->addValidator('EmailAddress')
            ->addFilter('StringToLower')
            ->setLabel("Email:");

        $password = $this->createElement('password', 'password');
        $password->addValidator('StringLength', false, array(6))
            ->setAttrib("class", "form-control")
            ->setRequired(true)
            ->setLabel("Password:");

        $this->addElement($email)
            ->addElement($password)
            ->addElement('submit', 'login', array('label' => 'Sign In', 'class' => 'btn btn-success btn-block'))
            ->addElement('button', 'register', array('label' => 'Register', 'class' => 'btn btn-primary btn-block', 'onclick' => 'callAjax("/sign-in/register")'))
            ->addElement('button', 'forgot_password', array('label' => 'Forgot password?', 'class' => 'btn btn-default btn-block', 'onclick' => 'callAjax("/sign-in/forgot-password")'));
    }
}

