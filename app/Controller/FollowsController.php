<?php 

class FollowsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		// ユーザー自身による登録ログアウトを許可する
		$this->Auth->allow('follow','follower','add','delete');
	}

	public $components = array('Paginator');

	public $paginate = array(
		'maxLimit' => 10
		);

	public $uses = array('User','Comment','Follow');

	public function follow() {
		$this->loadModel('User','Comment');
		// 今ログインしているユーザーIDを変数変換。
		$Users = $this->Auth->User();

		$q = $this->Follow->find('all',array(
			'conditions' => array(
				'from_id' => $Users['id'])
			)
		);

		$a = count($q);
		$follow_id[] = 0;

		for($i = 0;$i < $a;++$i){
			$follow_id[] = $q[$i]['Follow']['to_id'];
		}

		$query = $this->User->find('all',array(
			'conditions' => array(
				'id' => $follow_id),
			'limit' => 10));

		$this->set('query',$query);
		$this->set('user',$Users);

				// 自分がフォローされている人を検索する。
		$f = $this->Follow->find('all',array(
			'conditions' => array(
				'Follow.to_id' => $Users['id']
				)
			)
		);

		$my_comment = $this->Comment->find('all',array(
			'conditions' => array(
				'user_id' => $Users['id']
				)
			)
		);

		$comment_count = count($my_comment);		

		// フォロワー人数を検索。
		$b = count($f);


		$this->set('follower',$b);
		$this->set('comment_count',$comment_count);

	}

	public function follower() {
		$this->loadModel('User','Comment');
		// 今ログインしているユーザーIDを変数変換。
		$Users = $this->Auth->User();

		$q = $this->Follow->find('all',array(
			'conditions' => array(
				'to_id' => $Users['id'])
			)
		);

		$a = count($q);
		$follow_id[] = 0;

		for($i = 0;$i < $a;$i++){
			$follow_id[] = (int)$q[$i]['Follow']['from_id'];
		}

		$query = $this->User->find('all',array(
			'conditions' => array(
					'id' => $follow_id),
			'limit' => 10));

// ヒアドキュメント … 打ち込んだものをそのまま表示させるための記法。
// $変数 = <<< 名称(EOL)
// ～～
// 名称(EOL)
		$sql = <<< SQL
SELECT
	*
FROM
	`follows` AS `Follow`
WHERE
	`to_id` = {$Users['id']}
AND `from_id` NOT IN (
	SELECT
		`to_id`
	FROM
		`follows`
	WHERE
		`from_id` = {$Users['id']}
)
SQL;
		$follow = $this->Follow->query($sql, false);
		$this->log($follow,'access');

//		$b = count($query);
//		$bs[] = 0;

//		for($i = 0;$i < $b;$i++){
//			$bs[] = $query[$i]['User']['id'];
//		} 

		//$follow = $this->Follow->find('all',array(
		//	'conditions' => array(
		//		'from_id' => $Users['id'],
		//		'to_id' => $bs)
		//			)
		//		);

	//	$c = count($follow);
	//	$cs[] = 0;

	//	for($i = 0;$i < $c;$i++){
	//		$cs[] = (int)$follow[$i]['Follow']['to_id'];
	//	}

	//	$d[] = 0;

		// foreach($bs as $bss) {
		// 	if($bss !== $cs[$z]) {
		// 		if($d !== $bss) {
		// 			$d[] = (int)$bss;
		// 			$z++ ;
		// 		}
		// 	}
		// }

		//var_dump($cs);
		//exit;

		$this->set('follow',$follow);
		$this->set('query',$query);
		$this->set('user',$Users);

		// 自分がフォローしている人を検索。
		$r = $this->Follow->find('all',array(
			'conditions' => array(
				'Follow.from_id' => $Users['id']
				)
			)
		);

		// フォロー人数を検索。
		$a = count($r);

		$my_comment = $this->Comment->find('all',array(
			'conditions' => array(
				'user_id' => $Users['id']
				)
			)
		);

		$comment_count = count($my_comment);

		$this->set('a',$a);
		$this->set('comment_count',$comment_count);


	}

	public function add($postId = null) {
		//$id = (int)$postId;
		$id = sprintf("%d",$postId);

		if($this->request->is('post')) {
            $this->loadModel('User');

            // 前準備として、各カラムに保存する情報を指定する。
            $this->Follow->set(array(
            	'from_id' => $this->Auth->user('id'),
            	'to_id' => $id));

            if($this->Follow->save()){	
				//メッセージをセットしてリダイレクトする
				$this->Flash->set('フォローしました');
				return $this->redirect('follower');
			}
		}
	}


	public function delete($postId = null) {
		$this->loadModel('User');

		$User = $this->Auth->user('id');
		$this->log($User,'access');
		$this->log($postId,'access');

		// $id = sprintf("%",$postId);
		// if($this->request->is('post')) {			
		// 	if($this->Follow->deleteAll(array(
		// 		'conditions' => array(
		// 			'from_id' => $User,
		// 			'to_id' => $postId)))){
		// 		$this->Flash->set('フォロー解除しました');
		// 		return $this->redirect('follow');
		// 	}

		// }

		$id = $this->Follow->find('all',array(
			'conditions' => array(
				'from_id' => $User,
				'to_id' => $postId
				),
			'fields' => 'Follow.id'
			)
		);

		if($this->Follow->delete($id[0]['Follow']['id'])) {
			$this->Flash->set('フォロー解除しました');
			return $this->redirect('follow');
		}
	}
}
?>
