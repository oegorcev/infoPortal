<?php

/**
 * Sign In controller
 */


class SignInController extends Zend_Controller_Action
{

    private $_formLogin = null;

    private $_formRegister = null;

    private $_formForgotPassword = null;

    public function init()
    {
        $this->view->pageName = "Sign In";

        $this->_formLogin = new Application_Form_Login();
        $this->_formRegister = new Application_Form_Register();
        $this->_formForgotPassword = new Application_Form_ForgotPassword();

        $this->view->formRegister = $this->_formRegister;
        $this->view->formLogin = $this->_formLogin;
        $this->view->formForgotPassword = $this->_formForgotPassword;
    }

    public function indexAction()
    {


        $this->render('login');
    }

    public function loginAction()
    {
        if($this->getRequest()->getPost('data') == '/sign-in/login'){
            $this->_helper->layout->disableLayout();
        }

        if (Zend_Auth::getInstance()->hasIdentity()) {

            // если да, то делаем редирект, чтобы исключить многократную авторизацию

            $this->_helper->redirector('index', 'user-list');

        }

        // Если к нам идёт Post запрос

        if ($this->getRequest()->isPost() And $this->getRequest()->getPost('data') != '/sign-in/login') {
            // Принимаем его

            $formData = $this->getRequest()->getPost();

            // Если форма заполнена верно

            if ($this->_formLogin->isValid($formData)) {

                // Получаем адаптер подключения к базе данных

                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

                // указываем таблицу, где необходимо искать данные о пользователях

                // колонку, где искать имена пользователей,

                // а также колонку, где хранятся пароли

                $authAdapter->setTableName('Users')
                    ->setIdentityColumn('sign_in_login')
                    ->setCredentialColumn('password');


                // получаем введённые данные

                $username = $this->getRequest()->getPost('email');

                $password = $this->getRequest()->getPost('password');


                $dbUsersMapper = new Application_Model_UsersMapper();

                if ($dbUsersMapper->getAccountState($username) == true) {

                    // подставляем полученные данные из формы

                    $authAdapter->setIdentity($username)
                        ->setCredential($password);


                    // получаем экземпляр Zend_Auth

                    $auth = Zend_Auth::getInstance();


                    // делаем попытку авторизировать пользователя

                    $result = $auth->authenticate($authAdapter);

                    // если авторизация прошла успешно

                    if ($result->isValid()) {
                        // используем адаптер для извлечения оставшихся данных о пользователе

                        $identity = $authAdapter->getResultRowObject();


                        // получаем доступ к хранилищу данных Zend
                        $authStorage = $auth->getStorage();

                        // помещаем туда информацию о пользователе,

                        // чтобы иметь к ним доступ при конфигурировании Acl

                        $authStorage->write($identity);


                        // Используем библиотечный helper для редиректа

                        // на controller = index, action = index


                        $this->_helper->redirector('index', 'user-information');
                    } else {
                        $this->view->errMessage = 'Вы ввели неверное имя пользователя или неверный пароль';
                    }
                } else {

                    $this->view->errMessage = 'Вы ввели неверное имя пользователя или неверный пароль';
                }

            }

        }
    }

    public function registerAction()
    {
        if($this->getRequest()->getPost('data') == '/sign-in/register'){
            $this->_helper->layout->disableLayout();
        }

        if ($this->getRequest()->isPost() And $this->getRequest()->getPost('data') != '/sign-in/register') {

            if ($this->_formRegister->isValid($this->getRequest()->getPost())) {

                $dbUsersMapper = new Application_Model_UsersMapper();

                if ($dbUsersMapper->isUserExist($this->getRequest()->getPost('email'))) {

                    $newUser = new Application_Model_Users();

                    $newUser->setSignInLogin($this->getRequest()->getPost('email'));
                    $newUser->setPassword($this->getRequest()->getPost('password'));
                    $newUser->setPositionId($this->getRequest()->getPost('Positions'));

                    $dbUsersMapper->insertUser($newUser);
                    $this->_helper->redirector('login', 'sign-in');
                }
            }

        }
    }

    public function forgotPasswordAction()
    {
        if ($this->getRequest()->getPost('data') == '/sign-in/forgot-password') {
            $this->_helper->layout->disableLayout();
        }

        if ($this->getRequest()->isPost()) {


        }
    }

    public function logOutAction()
    {
        // уничтожаем информацию об авторизации пользователя
        Zend_Auth::getInstance()->clearIdentity();
        // и отправляем его на главную
        $this->_helper->redirector('index', 'sign-in');
    }
}

