<?php

class Application_Model_UsersMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Users');
        }
        return $this->_dbTable;
    }

    public function getAllPositions()
    {
        $postionTable = new Application_Model_DbTable_Positions();
        $select = $postionTable->select();
        $select->from($postionTable, 'name');

        $rows = $postionTable->fetchAll($select)->toArray();

        return $rows;
    }

    public function getUserIdByLogin($login)
    {
        $usersTable = new Application_Model_DbTable_Users();
        $select = $usersTable->select();

        $select->from($usersTable, 'id')
            ->where('sign_in_login = ?', $login);

        $row = $usersTable->fetchRow($select)->toArray();

        return $row["id"];
    }

    public function getUserInformationByUserId($id, Application_Model_Users $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $user->setId($row->id)
            ->setSignInLogin($row->sign_in_login)
            ->setFirstName($row->first_name)
            ->setMiddleName($row->middle_name)
            ->setLastName($row->last_name)
            ->setGender($row->gender)
            ->setBirthday($row->birth_day)
            ->setPathToPhoto($row->path_to_photo)
            ->setSkype($row->skype);
    }

    public function getUserEmailsByUserId($id)
    {
        $emailsTable = new Application_Model_DbTable_Emails();
        $select = $emailsTable->select();

        $select->from($emailsTable, 'email')
            ->where('user_id = ?', $id);

        $rows = $emailsTable->fetchAll($select)->toArray();

        return $rows;
    }

    public function getUsersPhonesByUserID($id)
    {
        $phonesTable = new Application_Model_DbTable_Phones();
        $select = $phonesTable->select();

        $select->from($phonesTable, 'phone')
            ->where('user_id = ?', $id);

        $rows = $phonesTable->fetchAll($select)->toArray();

        return $rows;
    }

    public function getPosition($postition_id)
    {
        $positionsTable = new Application_Model_DbTable_Positions();
        $select = $positionsTable->select();

        $select->from($positionsTable, 'name')
            ->where('id = ?', $postition_id);

        $row = $positionsTable->fetchRow($select)->toArray();

        return $row["name"];
    }

    public function getAccountState($userLogin)
    {
        if(empty($userLogin)) return false;
        $usersTable = new Application_Model_DbTable_Users();
        $select = $usersTable->select();

        $select->from($usersTable, 'is_active')
               ->where('sign_in_login = ?', $userLogin);

        $row = $usersTable->fetchRow($select)->toArray();

        return (boolean)(count($row) == 1 && $row['is_active'] == "1");
    }


    public function updateUserInformation($data, $id)
    {
        $usersTable = new Application_Model_DbTable_Users();

        try {
            $usersTable->update($data, 'id = ' . $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteEmailsByUserID($id)
    {
        $emailsTable = new Application_Model_DbTable_Emails();

        try {
            $emailsTable->delete('user_id ='. $id);
        }catch (Exception $e)
        {

        }
    }

    public function deletePhonesByUserID($id)
    {
        $phonesTable = new Application_Model_DbTable_Phones();

        try {
            $phonesTable->delete('user_id ='. $id);
        }catch (Exception $e)
        {

        }
    }

    public function insertEmail($id, $email)
    {
        $emailsTable = new Application_Model_DbTable_Emails();

        $data = array(
            'user_id'      => $id,
            'email' => $email
        );

        $emailsTable->insert($data);
    }

    public function insertPhone($id, $phone)
    {
        $phonesTable = new Application_Model_DbTable_Phones();
        $data = array(
            'user_id'      => $id,
            'phone' => $phone
        );

        $phonesTable->insert($data);
    }

    public function getUsersInformationForUserList()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();

        foreach ($resultSet as $row) {
            $bday = new DateTime($row->birth_day); // Your date of birth
            $today = new Datetime(date('m.d.y'));
            $diff = $today->diff($bday);

            $entry = array($row->first_name,
                          $row->middle_name,
                          $row->last_name,
                          $row->gender,
                          $this->getPosition($row->position_id),
                          $diff->y);
            $entries[] = $entry;
        }

        return $entries;
    }

    public function isUserExist($userLogin)
    {
        $usersTable = new Application_Model_DbTable_Users();
        $select = $usersTable->select();
        $select->from($usersTable, 'id')
            ->where('sign_in_login = ?', $userLogin);

        $row = $usersTable->fetchRow($select);

        return ($row == NULL);
    }

    public function insertUser(Application_Model_Users $user)
    {
        $usersTable = new Application_Model_DbTable_Users();
        $positionsTable = new Application_Model_DbTable_Positions();

        $select = $positionsTable->select();

        $select->from($positionsTable, 'id')
               ->where('name = ?', $user->getPositionId());

        $row = $positionsTable->fetchRow($select)->toArray();

        $data = array(
            'sign_in_login' => $user->getSignInLogin(),
            'password' => $user->getPassword(),
            'position_id' => $row["id"],
        );

        $usersTable->insert($data);

    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Users();

            $entry->setId($row->id)
                ->setSignInLogin($row->sign_in_login)
                ->setPassword($row->password)
                ->setPositionId($row->position_id)
                ->setIsAdmin($row->is_admin)
                ->setFirstName($row->first_name)
                ->setMiddleName($row->middle_name)
                ->setLastName($row->last_name)
                ->setGender($row->gender)
                ->setBirthday($row->birth_day)
                ->setPathToPhoto($row->path_to_photo)
                ->setIsActive($row->is_active)
                ->setSkype($row->skype);
            $entries[] = $entry;

        }

        return $entries;
    }
}
