<!--app/View/Users/add.ctp -->
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('ついったーに参加しましょう'); ?></legend>
		<?php echo $this->Form->input('name',array(
			'label' => '名前'));
		echo $this->Form->input('username',array(
			'label' => 'ユーザー名'));
		echo $this->Form->input('password',array(
			'label' => 'パスワード'));
		echo $this->Form->input('pass',array(
			'type' => 'password',
			'label' => 'パスワード(確認)'));
		echo $this->Form->input('email',array(
			'label' => 'メールアドレス'));
		echo $this->Form->input('secret',array(
			'type' => 'checkbox',
			'label' => 'つぶやきを非公開にする'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('アカウントを作成する')); ?>
</div>
