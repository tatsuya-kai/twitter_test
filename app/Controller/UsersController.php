<?php 
// app/Controller/UsersController.php
App::uses('AppController','Controller');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		// ユーザー自身による登録とログアウトを許可する
		$this->Auth->allow('add','login','result','search', 'follow','user','mypage');
		$this->log($this->Auth->user(), 'access');
	}

	public $paginate = array(
		'limit' => 10,
		'order' => 'User.created'
		);

	public function initialize() {
		parent::initialize();
		$this->loadComponent('Paginator');
	}

	public function add() {
		//is('post')で値がpostで持ってきたかを確認する。
		if($this->request->is('post')){
			//一旦中身をリセットする役割。
		    $this->User->create();
		    //情報を保存処理している。
		    if($this->User->save($this->request->data)) {
	    		$this->Session->write('User', $this->request->data);
		      	// trueの時、結果画面へジャンプする
		      	$this->redirect('/users/result');
		   	}
		}
	}

	public function login() {
		if($this->request->is('post')){
			if($this->Auth->login()) {
				//return $this->redirect($this->Auth->redirectUrl());
				// refirectUrl()での方法だと、ログイン画面に戻される為、直接次のリンク先を入力。
				return $this->redirect(array('controller' => 'comments','action' => 'tweet'));
			} else {
				$this->Flash->error(__('ユーザー名、パスワードの組み合わせが違うようです。'));
			}
			$this->Auth->authError = '管理者としてログインする必要があります';
		}
	}

	public function logout() {
	$this->redirect($this->Auth->logout());
	}

	public function result() {
		// セッション内の()のキーの値を返し、それを変数に代入する。
		$user = $this->Session->read('User');
		// セッション内の情報のリセットの意味を込めて、削除する。
		$this->Session->delete('User');
		// 代入してきた情報を'username'としてセットする。
		$this->set('username', $user['User']['username']);
		// $this->redirect('/users/login');

	}

	public function search() {
		// Followモデルを使用する。
		$this->loadModel('Follow');
		// postデータが入っていれば'true'
		if($this->request->is('post')) {
			$user = $this->Auth->user();
			// postデータの $search に代入する。
			$search = $this->request->data['User']['user'];
			$data = $this->User->find('all',array(
				'conditions' => array(
					// $searchの前後を"OR"条件で曖昧検索する。 
					'OR' => array(
					'User.name LIKE' => "%".$search."%",
					'User.username LIKE' => "%".$search."%"),
					// ログイン者のデータは表示しない。
					'NOT' => array(
						'User.id' => $user['id'])),
				'limit' => 10,
				'order' => array('User.created' => 'DESC'
					)));
			if($data[0]['User']['name'] == '') {
				$this->Flash->error(__('対象のユーザーは見つかりません'));
			} else {
				$this->set('find',$data);
			}
			// Followモデル内のログイン者のフォロー者のみを引っ張る。
			$s = $this->Follow->find('all',array(
				'conditions' => array(
					'Follow.from_id' => $user['id']
					)
				)
			);
			// 検索したデータの数を数える。
			$a = count($s);
			// Noticeを防ぐ為に、'0'を代入しておく。
			$follow_id[] = 0;

			// データ数分、$follow_idの配列にフォロワーされている人('to_id')を代入していく。
			for($i = 0;$i < $a; ++$i) {
				$follow_id[] = $s[$i]['Follow']['to_id'];
			}

			// Userモデル内の、User.idと$Follow_idと一致していないデータを引っ張り、フォローしてない人を探し出す。
			$no_follow = $this->User->find('all',array(
				'conditions' => array(
					'NOT' => array(
						'id' => $follow_id,
						)
					)
				)
			);

			$this->set('d',$no_follow);

		}
	}

	public function follow($postId = null) {
		//$id = (int)$postId;
		$id = sprintf("%d",$postId);


		if($this->request->is('post')) {
            $this->loadModel('Follow');

            // 前準備として、各カラムに保存する情報を指定する。
            $this->Follow->set(array(
            	'from_id' => $this->Auth->user('id'),
            	'to_id' => $id));

            if($this->Follow->save()){	
				//メッセージをセットしてリダイレクトする
				$this->Flash->set('フォローしました');
				return $this->redirect('search');
			}
			
		}		
	}

	public function user($postId = null) {
		$id = sprintf("%d",$postId);

		if(isset($id)) {
			$result = $this->User->find('all',array(
				'conditions' => array(
					'User.id' => $id)
				)
			);
		}

		$this->log($result,'access');

		$this->set('result',$result);
	}

	public function mypage() {
		$user = $this->Auth->user('id');

		if(isset($user)){
			$result = $this->User->find('all',array(
				'conditions' => array(
					'User.id' => $user)
				)
			);
		}

		$this->set('result',$result);
		$this->render('user');
	}

}