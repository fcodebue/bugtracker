<body id="login">
	<div id="login-wrapper" class="png_bg">
		<div id="login-top">
		
			<h1><?=$this->lang->line('log_title'); ?></h1>
			<!-- Logo (221px width) -->
			<img id="logo" src="<?=base_url();?>public/backend/images/logo.png" alt="Admin" />
		</div> <!-- End #logn-top -->
		
		<div id="login-content">
			
			<?=form_open('admin/login'); ?>
			
				<div class="notification information png_bg">
					<div>
						<?=$this->lang->line('insert_log'); ?>
					</div>
				</div>
				<p>
					<?php $email = array(
							'class' 	=> 'text-input', 
							'name' 		=> 'email',
							'value' 	=> set_value('email') ); ?>
					<?=form_label($this->lang->line('email'), 'email'); ?>
					<?=form_input($email);?>
				</p>
				<div class="clear"></div>
				<p>
					<?php $password = array('class' => 'text-input', 'name' => 'password');?>
					<?=form_label($this->lang->line('password'), 'password'); ?>
					<?=form_password($password);?>
				</p>
				<div class="clear"></div>
				<?php $error_email 		= form_error('email');?>
				<?php $error_password 	= form_error('password');?>
				<?php if (!empty($error_email)):?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close'); ?>" /></a>
						<div>
							<?=form_error('email'); ?>
							<?=form_error('password'); ?>
						</div>
					</div>
				<?php elseif (!empty($error_password)):?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close'); ?>" /></a>
						<div>
							<?=form_error('email'); ?>
							<?=form_error('password'); ?>
						</div>
					</div>
				<?php endif;?>
				<?php if ($this->session->flashdata('flashError')):?>
					<div class="notification error png_bg">
						<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close'); ?>" /></a>
						<div>
							<?=$this->session->flashdata('flashError'); ?>
						</div>
					</div>
				<?php endif;?>
				<p class="lang-pick">
					<?=form_label($this->lang->line('language'), 'language'); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="language">
						<option value="pt">PT</option>
						<option value="en">EN</option>
					</select>
				</p>
				<p>
					<?php $submit = array('class' => 'button', 'name' => 'login', 'value' => $this->lang->line('login') );?>
					<?=form_submit($submit); ?>
				</p>
			<?=form_close(); ?>
		</div>
	</div>
 </body>