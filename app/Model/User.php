<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

    public $validate = array(
        'username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
            'between' => array(
                'rule' => array('between', 5, 15),
                'required' => true,
                'message' => 'Usernames must be between 5 to 15 characters'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Password must have a mimimum of 6 characters'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        )
    );

    /**
     * Mã hóa password trước khi lưu vào database
     * @param type $options
     * @return boolean
     */
    public function beforeSave($options = array()) {
        if (!parent::beforeSave($options)) {
            return false;
        }
        if (isset($this->data[$this->alias]['password'])) {
            $hasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $hasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }

}
