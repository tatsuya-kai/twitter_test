<!-- app/View/Users/result.ctp -->
<div class="result">
	<fieldset>
		<legend><?php echo __('ついったーに参加しました。'); ?></legend>
		<?php echo $username; ?>さんはついったーに参加されました。<br>
		ログインをクリックしてログインしつぶやいてください。<br>
	</fieldset>
	<?php
	echo $this->Html->link('twitterにログイン','login');
	?>

</div>