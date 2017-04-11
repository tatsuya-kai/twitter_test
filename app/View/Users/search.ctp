<!-- app/View/Users/search.ctp -->
<div class = "find">
<fieldset>
	<?= $this->Form->create('User',array('url' => 'search')); ?>
	<legend>友達を見つけて、フォローしましょう！</legend>
	<br><br><br>
	ついったーに登録済みの友達を検索できます。<br>
	<?= $this->Form->input('user',array(
		'label' => '誰を検索しますか？'));?>
	<?= 'ユーザー名や名前で検索' ;?>
</fieldset>
	<?= $this->Form->end(__('検索'));?><br>
</div>

<div class = "Result">
<table>
	<thead>
		<tr>
			<th>username</th>
			<th>name</th>
			<th>comment</th>
			<th>created</th>
			<th>follow</th>
		</tr>
	</thead>

	<tbody>
	<!-- 検索結果のツイートを順次表示する -->
	<?php if(isset($find)) : ?>
	<?php foreach($find as $row) : ?>
		<tr>
		<td><?= $this->Form->postLink($row['User']['username'],array('controller' => 'users','action' => 'user',$row['User']['id'])).'&nbsp;'; ?></td>
		<td><?= $row['User']['name'].'<br>'; ?></td>
		<!-- $row の'Comment'のforeachを一周で終わらせるために、$iに初期値、$isに上限回数を代入する。 -->
		<?php $i = 0; ?>
		<?php $is = 1; ?>
		<!-- $row の中の'Comment'部分は配列として出力されてるため、再度foreachで回す必要がある。 -->
		<?php foreach ($row['Comment'] as $comment) : ?>
			<!-- 処理が終わる毎に$iに1ずつ足していき、$is(上限回数)を超えたタイミングで処理を終了させる。 -->
			<?php if($i >= $is) : ?>
				<?php break; ?>
			<?php else :?>
				<td><?= $comment['comment'].'<br>'; ?></td>
				<td><?= $comment['created'].'<br>'; ?></td>
				<?php $i++; ?>
			<?php endif ?>
		<?php endforeach ?>

		<?php foreach($d as $s) : ?>
			<!-- $row内のUser.idと$S(フォローしてない人)のUser.idが一致している時は'true'。 -->
			<?php if($row['User']['id'] == $s['User']['id']) :?>
				<td><?= $this->Form->postButton('Follow',array('action' => 'follow',$row['User']['id'])); ?></td>
			<?php endif ?>
		<?php endforeach ?>
		</tr>
	<?php endforeach ?>		
	<?php endif?>
	</tbody>
</table>

</div>

<?= $this->Html->link('ユーザー検索','/users/search') ;?>

<?= $this->Html->link('ログアウト','logout'); ?>

<?= $this->Html->link('ホーム','/comments/tweet') ;?>

