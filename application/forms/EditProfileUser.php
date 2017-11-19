<?php

/**
 * Edit Profile User Form
 */

class Application_Form_EditProfileUser extends Zend_Form
{
    private $_secondName;
    private $_firstName;
    private $_middleName;
    private $_gender;
    private $_image;
    private $_birthday;
    private $_skype;
    private $_password;
    private $_rePassword;

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
            ->addElement('file', 'addFile', array('label' => 'Add new photo', 'class' => 'form-control'))
            ->addElement($this->_secondName)
            ->addElement($this->_firstName)
            ->addElement($this->_middleName)
            ->addElement($this->_gender)
            ->addElement($this->_birthday)
            ->addElement($this->_skype);

        $emails = $userM->getUserEmailsByUserId($id);

        $i = 0;

        foreach ($emails as &$email)
        {
            foreach ($email as $s)
            {
                $this->addElement('text', 'email' . $i, array(
                    'label' => 'Email address ' . (string)($i + 1) . ':',
                    'value' => $s,
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
                $this->addElement('text', 'phone' . $i, array(
                    'label' => 'Phone number ' . (string)($i + 1) . ':',
                    'value' => $s
                ));

                ++$i;
            }
        }
    }


    public function init()
    {
        $this->setAttrib("id", "form_edit_user_information");
        $this->setAttrib("class", "form_edit_user_information");

        $this->setAction('/edit-profile-user/index')
            ->setMethod('post');

        $this->_secondName = $this->createElement('text', 'last_name');
        $this->_secondName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Last_name:");

        $this->_firstName = $this->createElement('text', 'first_name');
        $this->_firstName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("First name:");

        $this->_middleName = $this->createElement('text', 'middle_name');
        $this->_middleName->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Middle name:");

        $this->_gender = $this->createElement('select', 'gender');
        $this->_gender->setLabel('Gender');
        $this->_gender->addMultiOptions(array(
            '0' => 'Male',
            '1' => 'Female',
        ));

        $this->_image = $this->createElement('image', 'image');
        $this->_image->setAttrib('src', '/images/photo/default.png')
            ->setAttrib('width', '100')
            ->setAttrib('height', '111');

        $this->_birthday = $this->createElement('text', 'birth_day');
        $this->_birthday->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Birthday:");

        $this->_skype = $this->createElement('text', 'skype');
        $this->_skype->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Skype:");

        $this->_password = $this->createElement('password', 'password');
        $this->_password->setAttrib("class", "form-control")
            ->setLabel("Password:");

        $this->_rePassword = $this->createElement('password', 're_password');
        $this->_rePassword->setAttrib("class", "form-control")
            ->setLabel("Confirm password:")
            ->addValidator(new Zend_Validate_Identical('password'));

        $this->setData();

        $this->addElement($this->_password)
            ->addElement($this->_rePassword)
            ->addElement('submit', 'Change', array('label' => 'Change information', 'class' => 'btn btn-success btn-block'));
    }
}

