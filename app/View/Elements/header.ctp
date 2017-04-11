<?php
echo $this->Html->css('header');
?>

<div class = "header">
	<div class = "header-logo">
		<?php 
		echo $this->Html->image('twitter_logo.jpg',array('url'=>array('controller'=>'comment','action'=>'tweet'))); ?>
	</div>
	<div class = "header-list">
		<ul>
			<li>ホーム</li>
			<li>友達を検索</li>
			<li>ログアウト</li>
		</ul>
<!-- 
		<ul>
			<li>ホーム</li>
			<li>友達を検索</li>
			<li>ログイン</li> -->

