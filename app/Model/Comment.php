<?php
App::uses('AppModel','Model');

class Comment extends AppModel {
	// public $belongsTo = array('User','Follow');
	public $belongsTo = array('User');
	public $name = "Comment";
}