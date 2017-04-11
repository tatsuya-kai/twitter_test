<!-- app/View/Follows/follow.ctp -->
<div class = "list">
	<div class = "list-header">
	<h3><?= $user['username'] ;?>は<?= count($query); ?>人をフォローしています</h3>
	<br><br><br><br>

	<div class = "list-left">
	ユーザー名 / 名前
	<div class = "list-right">
	操作	

	<div class = "list-center">
		<div class = "list-main">
		<table>
			<thead>
				<tr>
					<th>id</th>
					<th>ユーザ名</th>
					<th>名前</th>
					<th>つぶやき</th>
					<th>投稿日</th>
					<th>リムボタン</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($query as $row):?>
			<tr>
				<td><?=$row['User']['id']?></td>
				<td><?= $this->Form->postLink($row['User']['username'],array('controller' => 'users','action' => 'user',$row['User']['id']))?></td>
				<td><?=$row['User']['name']?></td>
					<?php $i = 0; ?>
					<?php $is = 1; ?>
				<?php foreach($row['Comment'] as $comment): ?>
					<?php if(!isset($comment)) : ?>
						<td>何も投稿してないよ</td>
						<td>何も投稿してないよ</td>
					<?php elseif($i >= $is): ?>
						<?php break; ?>
					<?php else : ?>
						<td><?=$comment['comment'] ?></td>
						<td><?=$comment['created'] ?></td>
							<?php $i++  ;?>
					<?php endif; ?>
				<?php endforeach ;?>
				<td><?=$this->Form->postButton('フォローを解除',array(
					'action' => 'delete',$row['User']['id'])); ?></td>
			</tr>
			<?php endforeach;?>
			</tbody>
		</table>
















	<!-- 	<?php foreach($query as $row) {
				echo $row['User']['username'].'<br>';
				echo $row['User']['name'].'<br>';

				$i = 0;
				$is = 1;
				// $row の中の'Comment'部分は配列として出力されるため、再度foreachで回す。
				foreach($row['Comment'] as $comment) {
					if($i >= $is){
						break;
					}else{
						echo $comment['comment'].'<br>';
						echo $comment['created'].'<br>';
						$i++;
					}
				}

				echo $this->Form->postButton('フォローを解除',array(
					'action' => 'delete',$row['User']['id']));


			}?> -->
		</div>
	</div>

		<div class = "list-button">
<?= $this->Html->link('ユーザー検索','/users/search') ;?>

<?= $this->Html->link('ログアウト','logout'); ?>

<?= $this->Html->link('ホーム','/comments/tweet') ;?>

<div class = "user">

名前 : <?= $user['username'].'<br>'; ?>
<?= count($query).'<br>' ;?>
<?= $this->Html->link('フォローしている','/follows/follow').'<br>' ;?>
<?= $follower.'<br>' ;?>
<?= $this->Html->link('フォローされている','/follows/follower').'<br>'  ;?>
<?= $comment_count.'<br>' ;?>
<?= $this->Form->postLink('投稿数',array('controller' => 'users','action' => 'mypage')) ;?>

</div>