<?php

class Application_Model_Users
{
    protected $_id;
    protected $_signInLogin;
    protected $_password;
    protected $_positionId;
    protected $_isAdmin;
    protected $_firstName;
    protected $_middleName;
    protected $_lastName;
    protected $_gender;
    protected $_birthday;
    protected $_pathToPhoto;
    protected $_isActive;
    protected $_skype;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {

        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getSignInLogin()
    {
        return $this->_signInLogin;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return mixed
     */
    public function getPositionId()
    {
        return $this->_positionId;
    }

    /**
     * @return mixed
     */
    public function getisAdmin()
    {
        return $this->_isAdmin;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddleName()
    {
        return $this->_middleName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->_birthday;
    }

    /**
     * @return mixed
     */
    public function getPathToPhoto()
    {
        return $this->_pathToPhoto;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->_isActive;
    }

    /**
     * @return mixed
     */
    public function getSkype()
    {
        return $this->_skype;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @param mixed $signaInLogin
     */
    public function setSignInLogin($signInLogin)
    {
        $this->_signInLogin = $signInLogin;
        return $this;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * @param mixed $positionId
     */
    public function setPositionId($positionId)
    {
        $this->_positionId = $positionId;
        return $this;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->_isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;
        return $this;
    }

    /**
     * @param mixed $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->_middleName = $middleName;
        return $this;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;
        return $this;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
        return $this;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->_birthday = $birthday;
        return $this;
    }

    /**
     * @param mixed $pathToPhoto
     */
    public function setPathToPhoto($pathToPhoto)
    {
        $this->_pathToPhoto = $pathToPhoto;
        return $this;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {

        $this->_isActive = $isActive;
        return $this;
    }

    /**
     * @param mixed $skype
     */
    public function setSkype($skype)
    {
        $this->_skype = $skype;
        return $this;
    }





}
