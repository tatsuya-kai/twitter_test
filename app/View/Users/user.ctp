<div class = "main">
	<h3><?= $result[0]['User']['username'] ?>さんのつぶやき一覧</h3>
	<div class = "main-timetable">
		<?php foreach($result as $tweet) : ?>
		<ul><?= $tweet['User']['id'];?></ul>
		<ul><?= $tweet['User']['username'];?></ul>
		<ul><?= $tweet['User']['name'];?></ul>
			<?php foreach($tweet['Comment'] as $comment) : ?>
				<li><?= $comment['comment']; ?></li>
				<ul><?= $comment['created']; ?></ul>
			<?php endforeach ?>
		<?php endforeach ?>
	</div>

	<div class = "main-right">

	</div>
	
	<div class = "list-button">
	<?= $this->Html->link('ユーザー検索','/users/search') ;?>

	<?= $this->Html->link('ログアウト','logout'); ?>

	<?= $this->Html->link('ホーム','/comments/tweet') ;?>
	</div>

</div>