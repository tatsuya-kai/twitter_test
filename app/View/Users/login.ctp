<!-- //app/view/Users/login.ctp -->
<div class="users-form">
<!-- フラッシュメッセージの表示 -->
<?php echo $this->Flash->render('auth'); ?>
<!-- フォームの作成 -->
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('ログイン'); ?></legend>
		<?php echo $this->Form->input('User.username',array(
			'label' => 'ユーザーID')); ?>
		<?php echo $this->Form->input('User.password',array(
			'label' => 'パスワード')); ?>
	</fieldset>
	<?php echo $this->Form->end(__('ログイン')); ?>
</div>

<div class="users-contents">
	<?php echo $this->Html->link('ユーザー登録','/users/add'); ?>