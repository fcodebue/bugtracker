<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3><?=$this->lang->line('trash'); ?></h3>
					<?php if ($action == 'list'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab"><?=$this->lang->line('listing'); ?></a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<?php echo form_open('admin/trash');?>
						<select name="type" onChange="this.form.submit();">
							<option value="articles" <?php if($type == 'articles'): ?>selected="selected"<?php endif;?>><?=$this->lang->line('articles'); ?></option>
							<option value="category" <?php if($type == 'category'): ?>selected="selected"<?php endif;?>><?=$this->lang->line('categories'); ?></option>
							<option value="users" <?php if($type == 'users'): ?>selected="selected"<?php endif;?>><?=$this->lang->line('users'); ?></option>
						</select>
					<?php echo form_close();?>
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
						<?php if ($this->session->flashdata('flashError')):?>
							<div class="notification error png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang-line('close') ?>"/></a>
								<div>
									<?=$this->session->flashdata('flashError'); ?>
								</div>
							</div>
						<?php endif;?>	
						<?php if ($this->session->flashdata('flashConfirm')):?>
							<div class="notification success png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang-line('close') ?>"/></a>
								<div>
									<?=$this->session->flashdata('flashConfirm'); ?>
								</div>
							</div>
						<?php endif;?>
						<?php if($type == 'articles'){ ?>		
						<table id="list-elements">
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>ID</th>
								   <th><?=$this->lang->line('name'); ?></th>
								   <th><?=$this->lang->line('status'); ?></th>
								   <th><?=$this->lang->line('modification'); ?></th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" href="#"><?=$this->lang->line('recovery_selected'); ?></a>
										</div>
										<?php if(isset($pagination)): ?>
											<div class="pagination">
												<?=$pagination; ?>
											</div>
										<?php endif;?>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
							<tbody>	
							<?php if(isset($records) && is_array($records) && count($records) > 0): ?>
								<?php foreach ($records as $row):?>
									<tr>
										<td><input type="checkbox" /></td>
										<td><?=$row->idarticle; ?></td>
										<td><?=$row->articletitle; ?></td>
										<td><?php if($row->articlestatus == 'deleted') { echo $this->lang->line('deleted'); } ; ?></td>
										<td><?=$row->articletimestamp; ?></td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<tr><td colspan="4" ><?=$this->lang->line('no_results'); ?></td><tr> 
							<?php  endif;?>
							</tbody>
						</table>
						<?php } elseif($type == 'category'){?>
						<table id="list-elements">
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>ID</th>
								   <th><?=$this->lang->line('name'); ?></th>
								   <th><?=$this->lang->line('status'); ?></th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" href="#"><?=$this->lang->line('recovery_selected'); ?></a>
										</div>
										<?php if(isset($pagination)): ?>
											<div class="pagination">
												<?=$pagination; ?>
											</div>
										<?php endif;?>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
							<tbody>	
							<?php if(isset($records) && is_array($records) && count($records) > 0): ?>
								<?php foreach ($records as $row):?>
									<tr>
										<td><input type="checkbox" /></td>
										<td><?=$row->idcategory; ?></td>
										<td><?=$row->categoryname; ?></td>
										<td><?php if ($row->categorystatus == 'deleted') { echo $this->lang->line('deleted'); } ; ?></td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<tr><td colspan="4" ><?=$this->lang->line('no_results'); ?></td><tr>
							<?php  endif;?>
							</tbody>
						</table>
						<?php }elseif($type == 'users'){?>
							<table id="list-elements">
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>ID</th>
								   <th><?=$this->lang->line('username') ?></th>
								   <th><?=$this->lang->line('email') ?></th>
								   <th><?=$this->lang->line('name') ?></th>
								   <th><?=$this->lang->line('surname') ?></th>
								   <th><?=$this->lang->line('type_user') ?></th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<a class="button" href="#"><?=$this->lang->line('recovery_selected'); ?></a>
										</div>
										<?php if(isset($pagination)): ?>
											<div class="pagination">
												<?=$pagination; ?>
											</div>
										<?php endif;?>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
							<tbody>	
							<?php if(isset($records) && is_array($records) && count($records) > 0): ?>
								<?php foreach ($records as $row):?>
									<tr>
										<td><input type="checkbox" /></td>
										<td><?=$row->iduser; ?></td>
										<td><?=utf8_decode($row->username); ?></td>
										<td><?=$row->email; ?></td>
										<td><?=utf8_decode($row->name); ?></td>
										<td><?=utf8_decode($row->surname); ?></td>
										<td><?=$row->type_2; ?></td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<tr><td colspan="7"><?=$this->lang->line('no_results'); ?></td><tr> 
							<?php  endif;?>
							</tbody>
						</table>
						<?php }?>
					</div> <!-- End #tab1 -->   
			<?php endif;?>
		</div>
	</div>
</body>