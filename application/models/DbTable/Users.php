<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_primary = 'id';
    protected $_name = 'Users';
    protected $_sequence = true;
}

