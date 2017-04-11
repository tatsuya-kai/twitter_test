<!-- app/View/Follows/follower.ctp -->
<div class = "list">
	<div class = "list-header">
	<h3><?= $user['username'] ;?>は<?= count($query); ?>人にフォローされています</h3>
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
					<th>フォローボタン</th>
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
					<?php if($i >= $is): ?>
						<?php break; ?>
					<?php else : ?>
						<td><?=$comment['comment'] ?></td>
						<td><?=$comment['created'] ?></td>
							<?php $i++  ;?>
					<?php endif; ?>
				<?php endforeach ;?>

				<?php foreach($follow as $f) :?>
					<?php if($f['Follow']['from_id'] === $row['User']['id']) : ?>
						<td>
						<?=$this->Form->postButton('フォローする',array(
								'action' => 'add',$row['User']['id']
								)
						);?>
						</td>
					<?php endif ; ?>
				<?php endforeach ; ?>	

			</tr>
			<?php endforeach;?>
			</tbody>
		</table>

<!-- 		<?php foreach($query as $row) {
				echo $row['User']['id'].'<br>';
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

				$p =0;
				foreach($follow as $f){
						if($f['Follow']['from_id'] === $row['User']['id']) {
								echo $this->Form->postButton('フォローする',array(
								'action' => 'add',$row['User']['id']));
						}	
					}
				}?> -->
		</div>
	</div>

<div class = "list-button">
<?= $this->Html->link('ユーザー検索','/users/search') ;?>

<?= $this->Html->link('ログアウト','logout'); ?>

<?= $this->Html->link('ホーム','/comments/tweet') ;?>

<div class = "user">

名前 : <?= $user['username'].'<br>'; ?>
<?= $a.'<br>' ;?>
<?= $this->Html->link('フォローしている','/follows/follow').'<br>' ;?>
<?= count($query).'<br>' ;?>
<?= $this->Html->link('フォローされている','/follows/follower').'<br>'  ;?>
<?= $comment_count.'<br>' ;?>
<?= $this->Form->postLink('投稿数',array('controller' => 'users','action' => 'mypage')) ;?>

</div>