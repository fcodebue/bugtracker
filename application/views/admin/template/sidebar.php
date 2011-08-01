	<div id="sidebar">
		<div id="sidebar-wrapper">
			<h1 id="sidebar-title"><a href="#">ADMIN</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="<?=base_url(); ?>public/backend/images/logo.png" alt="Admin logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
				<?php echo $this->lang->line('welcome');?>, <a href="<?=base_url();?>index.php/admin/users/edit/<?=$this->session->userdata('iduser'); ?>" title="Edit your profile"><?=$this->session->userdata('username'); ?></a><br /> 
			 	tem <a href="#messages" rel="modal" >3 Messages</a> 
				<br />
				<br />
				<a href="#" title="View the Site"><?php echo $this->lang->line('see_website');?></a> | <?=anchor('admin/login/logout', $this->lang->line('logout'), 'title="Sign Out"') ?>
			</div>        
			<ul id="main-nav">
				<li>
					<?php $dashboard = array('class' => 'nav-top-item no-submenu');?>
					<?=anchor('admin/manage', $this->lang->line('dashboard'), $dashboard); ?>     
				</li>
				<li> 
				<?php if(isset($current_page) && $current_page == 'articles'):?>
					<?php $articles = array('class' => 'nav-top-item current');?>
				<?php else:?>
					<?php $articles = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', $this->lang->line('articles'), $articles); ?>
					<ul>
						<li><?=anchor('admin/articles/add', $this->lang->line('add_article')); ?></li>
						<li><?=anchor('admin/articles', $this->lang->line('view_articles')); ?></li>
					</ul>
				</li>
				<li>
				<?php if(isset($current_page) && $current_page == 'category'):?>
					<?php $menus = array('class' => 'nav-top-item current');?>
				<?php else: ?>
					<?php $menus = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', $this->lang->line('categories'), $menus); ?>
					<ul>
						<li><?=anchor('admin/category/add', $this->lang->line('add_category')); ?></li>
						<li><?=anchor('admin/category', $this->lang->line('view_categories')); ?></li>
					</ul>
				</li>
				<li>
				<?php if(isset($current_page) && $current_page == 'menus'):?>
						<?php $menus = array('class' => 'nav-top-item current');?>
				<?php else: ?>
						<?php $menus = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', $this->lang->line('menus'), $menus); ?>
					<ul>
						<li><?=anchor('admin/menus/add', $this->lang->line('add_menu')); ?></li>
						<li><?=anchor('admin/menus', $this->lang->line('view_menus')); ?></li>
					</ul>
				</li>
				
				<li>
					<?php if(isset($current_page) && $current_page == 'users'):?>
						<?php $users = array('class' => 'nav-top-item current');?>
					<?php else:?>
						<?php $users = array('class' => 'nav-top-item');?>
					<?php endif;?>
					<?=anchor('', $this->lang->line('users'), $users); ?>
					<ul>
						<li><?=anchor('admin/users/add', $this->lang->line('add_user')); ?></li>
						<li><?=anchor('admin/users/', $this->lang->line('view_users')); ?></li>
					</ul>
				</li>
				
				<li>
					<?php if(isset($current_page) && $current_page == 'files'):?>
						<?php $files = array('class' => 'nav-top-item current');?>
					<?php else:?>
						<?php $files = array('class' => 'nav-top-item');?>
					<?php endif;?>
						<?=anchor('', $this->lang->line('files'), $files); ?>
					<ul>
						<li><?=anchor('admin/files/', $this->lang->line('manage_files')); ?></li>
					</ul>
				</li>
			</ul> <!-- End #main-nav -->	
			
			
		<p style="text-align: right; padding: 5px;">powered by: <a href="http://www.bloo.pt" target="_blank">Bloo</a></p>
		</div>
	</div> <!-- End #sidebar -->

<div id="messages" style="display: none">
	<!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->

	<h3>3 Messages</h3>

	<p>
		<strong>17th May 2009</strong> by Admin<br> Lorem ipsum dolor sit
		amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis
		aliquet congue. <small><a href="#" class="remove-link"
			title="Remove message">Remove</a> </small>
	</p>

	<p>
		<strong>2nd May 2009</strong> by Jane Doe<br> Ut a est eget ligula
		molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis
		mollis, tellus est malesuada tellus, at luctus turpis elit sit amet
		quam. Vivamus pretium ornare est. <small><a href="#"
			class="remove-link" title="Remove message">Remove</a> </small>
	</p>

	<p>
		<strong>25th April 2009</strong> by Admin<br> Lorem ipsum dolor sit
		amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis
		aliquet congue. <small><a href="#" class="remove-link"
			title="Remove message">Remove</a> </small>
	</p>
		<?php  
			$usermessage	= array('name' => 'usermessage', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '10', 'value' => set_value('usermessage'));
			$submit			= array('class' => 'button', 'id' => 'submit_message', 'value' => $this->lang->line('send') );
		 	$this->load->model('users_model'); 
		 	$users = $this->users_model->GetUsers();
		?>
		
	<?=form_open('users/addmessage'); ?>	
		<h4>New Message</h4>
	
			<?=form_textarea($usermessage); ?>
			<?=form_label('Utilizadores', 'users'); ?>
			<select name="users" class="small-input">
				<?php foreach ($users as $user) : ?>
					<option value="option<?=$user->iduser; ?>"><?=$user->username; ?></option>
				<?php endforeach; ?>
			</select>
			
			
			
			<?=form_submit($submit); ?>

	<?php form_close(); ?>

</div>
