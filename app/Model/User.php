<?php

App::uses('AppModel','Model');
App::uses('SimplePasswordHasher','Controller/Component/Auth');

class User extends AppModel {
	public $hasMany = array('Comment');
	public $uses = array('Comment','Follow');
	public $validate = array( 
		'name' => array(
			'type' => array(
				'rule' => 'alphaNumeric',
				'message' => '名前は全角または半角英数字のみです。'
			),
			'number' => array(
				'rule' => array('between',4,20),
				'message' => '名前は4文字～20文字で入力してください。'
			)
		),
		'username' => array(
			'type' => array(
				'rule' => '|^[0-9a-zA-Z_-]*$|',
				'message' => 'ユーザー名は半角英数字、アンダーバー、ハイフンで入力してください'
			),
			'number' => array(
				'rule' => array('between',4,20),
				'message' => 'ユーザー名は4文字～20文字で入力してください。'
			),
			'check' => array(
				'rule' => 'isUnique',
				'message' => '入力したユーザーは既に存在しています。'
			)
		),
		'password' => array(
			'type' => array(
				'rule' => '|^[0-9a-zA-Z]*$|',
				'message' => 'パスワードは半角英数字のみです。'
			),
			'number' => array(
				'rule' => array('between',4,8),
				'message' => 'パスワードは4文字～8文字で入力してください。'
		),
			'match' => array(
				'rule' => 'passwordConfirm',
				'message' => 'パスワードが一致してません。'
			)
		),
		'pass' => array(
			'type' => array(
				'rule' => '|^[0-9a-zA-Z]*$|',
				'message' => 'パスワード(確認)は全角または半角英数字のみです。'
			),
			'number' => array(
				'rule' => array('between',4,8),
				'message' => 'パスワード(確認)は4文字～8文字で入力してください。'
			)
		),
		'email' => array(
			'type' => array(
				'rule' => array('email'),
				'message' => '入力したメールアドレスに間違いがあります。'
			),
			'number' => array(
				'rule' => array('maxLength',100),
				'message' => 'メールアドレスは100文字以下で入力してください。'
			)
		)
	);

	public function beforeSave($optiions = array()) {
		if(isset($this->data[$this->alias]['password'])){
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']
				);
		} return true;
	}

	public function passwordConfirm($check) {
		// 2つのパスワードフィールドが一致することを確認する
		if($this->data['User']['password'] === $this->data['User']['pass']) {
			return true;
		} else {
			return false;
		}
	}

}