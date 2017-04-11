<?php

class CommentsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		// ユーザー自身による登録とログアウトを許可する
		$this->Auth->allow('add','login','result','delete','tweet');
	}

	public $components = array('Paginator');

	public $paginate = array(
		'maxLimit' => 10
		);
	public $uses =  array('User','Comment','Follow');

	public function test() {
		
	}

	public function tweet() {
		$this->loadModel('Follow');
		// 今ログインしているユーザーIDを変数にしておく
		$Users = $this->Auth->User();

		// Commentモデルのすべての情報から、データを取得。	
		$query = $this->Comment->find('all',array(
			// 条件はUser.IDと今ログインしてるユーザーが同じこと。
			'conditions' => array(
				'User.id' => $Users['id']),
			// Commentモデルの更新時間を降順で表示
			'order' => array(
				'Comment.modified' => 'DESC'),
			// 表示件数の上限数。
			'limit' => 1
			));
		// Viewで使うために'set'をする。
		$this->set('users',$Users);
		$this->set('query',$query);
		$this->set('login',$Users);

		// 自分がフォローしている人を検索。
		$r = $this->Follow->find('all',array(
			'conditions' => array(
				'Follow.from_id' => $Users['id']
				)
			)
		);

		// フォロー人数を検索。
		$a = count($r);
		$follow_id[] = 0;

		// 引っ張ってきた人の"to_id"を一件一件、配列に追加していく。
		for($i = 0;$i < $a;$i++) {
			$follow_id[] = $r[$i]['Follow']['to_id'];
		}

		// 配列に追加した情報を基に、それに付随するユーザー情報を検索する。
		$result = $this->Comment->find('all',array(
			'conditions' => array(
				array('or' => array(
					'User.id' => $Users['id'],
					'Comment.user_id' => $follow_id))),
			'order' => array(
				'Comment.modified' => 'DESC'),
			'limit' => 10));

		$this->set('result',$result);

		// 自分がフォローされている人を検索する。
		$f = $this->Follow->find('all',array(
			'conditions' => array(
				'Follow.to_id' => $Users['id']
				)
			)
		);

		// フォロワー人数を検索。
		$b = count($f);

		$my_comment = $this->Comment->find('all',array(
			'conditions' => array(
				'user_id' => $Users['id']
				)
			)
		);

		$comment_count = count($my_comment);

		$this->set('follow',$a);
		$this->set('follower',$b);
		$this->set('comment_count',$comment_count);

	}	

	public function add() {
		//今ログインしている'id'をCommentモデルの'user_id'に代入。
		$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
		$this->log('きたよ','access');
		//フォームのデータを検証して保存する...
		if($this->Comment->save($this->request->data)){
			//メッセージをセットしてリダイレクトする
			$this->Flash->set('投稿しました');
			return $this->redirect('tweet');
		}
	}

	public function delete($postId = null) {
		// $id = $this->Comment->postId ←の処理をしたかったが、
		//出来なかったため、無理やり(int)型にして突っ込んだ。
		$id = (int)$postId;
		if($this->request->is('get')){
			//GETアクセスだった場合の処理
		}
		if($this->Comment->delete($id)){
			$this->Flash->set('削除しました');
			return $this->redirect('tweet');
		}
	}

	public function logout() {
	$this->redirect($this->Auth->logout());
	}
}