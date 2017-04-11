<div class = "tweet">
	<?= $this->Form->create('Comment',array(
		'url' => array('controller' => 'comments','action' => 'add'),
		'id' => 'CommentsAdd')); ?>
	<fieldset>
		<legend>いまなにしてる？</legend>
		<?= $this->Form->input('comment',array(
		'label' => '140文字で入力してください。※半角、全角問わず')); ?>
		最新のつぶやき：
		<?php foreach($query as $row) :?>
			<?= $row['Comment']['comment']; ?>
			<?= $row['Comment']['created']; ?>
		<?php endforeach ?>
	</fieldset>
	<?= $this->Form->end(__('投稿する')); ?>
</div>

<div class = "timetable">
<h3>ホーム</h3>
	<div class = "timetable_tweet">
		<?php foreach($result as $tweet) : ?>
		<ul><?= $this->Form->postLink($tweet['User']['username'],array('controller' => 'users','action' => 'user',$tweet['User']['id']))?></ul>
		<li><?= $tweet['Comment']['comment']; ?></li>
		<?php if($users['id'] === $tweet['User']['id']): ?>
		<?php echo $this->Form->postButton('削除',array('action' => 'delete',$tweet['Comment']['id'])); ?>
		<?php endif; ?>
		<?php endforeach ?>
	</div>
</div>

<div class = "user">
	<div class = "user-main">

	</div>
	<div class = "user-follow">
	<?= $follow ;?>
	<br>
	<?= $this->Html->link('フォローしている','/follows/follow') ;?>
	</div>
	<div class = "user-follower">
	<?= $follower ;?>
	<br>
	<?= $this->Html->link('フォローされている','/follows/follower')  ;?>
	</div>
	<div class = "user-tweet">
	<?= $comment_count ;?>
	<br>
	<?= $this->Form->postLink('投稿数',array('controller' => 'users','action' => 'mypage')) ;?>
	</div>
</div>

<?= $this->Html->link('ユーザー検索','/users/search') ;?>

<?= $this->Html->link('ログアウト','logout'); ?>

<pre>
<?= var_dump($users); ?>
</pre>