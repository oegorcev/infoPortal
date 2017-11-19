<?php

/**
 * Filter for Table form
 */

class Application_Form_FilterForTable extends Zend_Form
{

    private $_position;
    private $_gender;
    private $_ageFrom;
    private $_ageTo;
    private $_allOther;

    public function init()
    {
        $this->setAttrib("id", "filter_user_information");
        $this->setAttrib("class", "filter_user_information");

        $this->setAction('/user-list/index')
            ->setMethod('post');

        $this->_position = $this->createElement('text', 'position');
        $this->_position->setAttrib("class", "form-control")
            ->setLabel("Position:")
            ->setAttrib('onkeyup', 'callAjax("' . $this->_position->getName() . '")');

        $this->_ageFrom = $this->createElement('text', 'age_from');
        $this->_ageFrom
            ->setAttrib("class", "form-control")
            ->setLabel("Age from:")
            ->setAttrib('onkeyup', 'callAjax("' . $this->_ageFrom->getName() . '")');

        $this->_ageTo = $this->createElement('text', 'age_to');
        $this->_ageTo
            ->setAttrib("class", "form-control")
            ->setLabel("Age to:")
            ->setAttrib('onkeyup', 'callAjax("' . $this->_ageTo->getName() . '")');

        $this->_gender = $this->createElement('select', 'gender');
        $this->_gender->setLabel('Gender');
        $this->_gender->setAttrib('onkeyup', 'callAjax("' . $this->_gender->getName() . '")');
        $this->_gender->addMultiOptions(array(
            '0' => 'Male',
            '1' => 'Female',
        ));

        $this->_allOther = $this->createElement('text', 'all_other');
        $this->_allOther->setRequired(true)
            ->setAttrib("class", "form-control")
            ->setLabel("Email, phone, name, last name, middle name:")
            ->setAttrib('onkeyup', 'callAjax("' . $this->_allOther->getName() . '")');

        $this->addElement($this->_position)
            ->addElement($this->_gender)
            ->addElement($this->_ageFrom)
            ->addElement($this->_ageTo)
            ->addElement($this->_allOther)
            ->addElement('submit', 'Filter', array('label' => 'Filter information', 'class' => 'btn btn-success btn-block'));
    }
}

