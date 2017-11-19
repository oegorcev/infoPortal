<?php

/**
 * Show user information Form
 */

class Application_Form_ShowUserInformation extends Zend_Form
{
    private $_secondName;
    private $_firstName;
    private $_middleName;
    private $_gender;
    private $_image;
    private $_birthday;
    private $_skype;

    function setData()
    {
        $userM = new Application_Model_UsersMapper();
        $user = new Application_Model_Users();

        $curUserInfo = get_object_vars(Zend_Auth::getInstance()->getIdentity());

        $id = $userM->getUserIdByLogin($curUserInfo['sign_in_login']);
        $userM->getUserInformationByUserId((string)$id, $user);

        $this->_secondName->setValue($user->getLastName());
        $this->_firstName->setValue($user->getFirstName());
        $this->_middleName->setValue($user->getMiddleName());

        if ($user->getGender() === 'F') {
            $genderID = 1;
        } else {
            $genderID = 0;
        }

        $this->_gender->setValue((string)$genderID);
        $this->_birthday->setValue($user->getBirthday());
        $this->_skype->setValue($user->getSkype());

        $this->_image->setAttrib('src', (string)$user->getPathToPhoto());


        $this->addElement($this->_image)
            ->addElement($this->_secondName)
            ->addElement($this->_firstName)
            ->addElement($this->_middleName)
            ->addElement($this->_gender)
            ->addElement($this->_birthday)
            ->addElement($this->_skype);

        $emails = $userM->getUserEmailsByUserId($id);

        $this->addElement('text', $user->getSignInLogin(), array(
            'label' => 'Login Email address ',
            'value' => $user->getSignInLogin(), 'disabled' => 'disabled'
        ));

        $i = 0;

        foreach ($emails as &$email)
        {
            foreach ($email as $s)
            {
                $this->addElement('text', $s, array(
                    'label' => 'Email address ' . (string)($i + 1) . ':',
                    'value' => $s, 'disabled' => 'disabled'
                ));

                ++$i;
            }
        }

        $phones = $userM->getUsersPhonesByUserID($id);

        $i = 0;

        foreach ($phones as &$phone)
        {
            foreach ($phone as $s)
            {
                $this->addElement('text', $s, array(
                    'label' => 'Phone number ' . (string)($i + 1) . ':',
                    'value' => $s, 'disabled' => 'disabled'
                ));

                ++$i;
            }
        }
    }

    public function init()
    {
        $this->setAttrib("id", "form_edit_user_information");
        $this->setAttrib("class", "form_edit_user_information");


        $this->setAction('/edit-user-information/index')
            ->setMethod('post');

        $this->_secondName = $this->createElement('text', 'second_name');
        $this->_secondName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Second name:")
            ->setAttrib('disabled', 'disabled');

        $this->_firstName = $this->createElement('text', 'first_name');
        $this->_firstName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("First name:")
            ->setAttrib('disabled', 'disabled');

        $this->_middleName = $this->createElement('text', 'middle_name');
        $this->_middleName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Middle name:")
            ->setAttrib('disabled', 'disabled');

        $this->_gender = $this->createElement('select', 'gender');
        $this->_gender->setLabel('Gender');
        $this->_gender->addMultiOptions(array(
            '0' => 'Male',
            '1' => 'Female',
        ))
            ->setAttrib('disabled', 'disabled');

        $this->_image = $this->createElement('image', 'image');
        $this->_image->setAttrib('width', '100')
            ->setAttrib('height', '111')
            ->setAttrib('disabled', 'disabled');

        $this->_birthday = $this->createElement('text', 'birthday');
        $this->_birthday->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Birthday:")
            ->setAttrib('disabled', 'disabled');

        $this->_skype = $this->createElement('text', 'skype');
        $this->_skype->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Skype:")
            ->setAttrib('disabled', 'disabled');

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->setData();
        }
    }
}

