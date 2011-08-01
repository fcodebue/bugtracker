<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3><?=$this->lang->line('categories'); ?></h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab"><?=$this->lang->line('listing'); ?></a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"><?=$this->lang->line('add_category'); ?></a> <?php endif;?>
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
						<?php if ($this->session->flashdata('flashError')):?>
							<div class="notification error png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close'); ?>" /></a>
								<div>
									<?=$this->session->flashdata('flashError'); ?>
								</div>
							</div>
						<?php endif;?>	
						<?php if ($this->session->flashdata('flashConfirm')):?>
							<div class="notification success png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close'); ?>" /></a>
								<div>
									<?=$this->session->flashdata('flashConfirm'); ?>
								</div>
							</div>
						<?php endif;?>			
						<table id="list-elements">
							<thead>
								<tr>
								   <!-- <th><input class="check-all" type="checkbox" /></th> -->
								   <th>ID</th>
								   <th><?=$this->lang->line('name'); ?></th>
								   <th><?=$this->lang->line('status'); ?></th>
								   <th><?=$this->lang->line('actions'); ?></th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<!-- <div class="bulk-actions align-left">
											<select name="dropdown">
												<option value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>
										</div> -->
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
										<!-- <td><input type="checkbox" /></td> -->
										<td><?=$row->idcategory; ?></td>
										<td><?=$row->categoryname; ?></td>
										<td>
										<?php if($row->categorystatus == "active") { 
												echo $this->lang->line('published');
												} 
											elseif( $row->categorystatus == "inactive" ) {
												echo "<span style=\"color: red;\">". $this->lang->line('unpublished') ."</span>"; 
											} ?>
										</td>
										<td>
											<!-- Icons -->
											<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"" .$this->lang->line('edit') . "\" />"; ?>
											<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"" .$this->lang->line('delete') . "\" />"; ?>
											<?=anchor("admin/category/edit/$row->idcategory", $edit_icon, 'title=" '. $this->lang->line('edit') . '"'); ?>
											<?=anchor("admin/category/delete/$row->idcategory", $delete_icon, 'title="Apagar" onclick="return confirm(\' ' . $this->lang->line('you_sure_del') . '\')"'); ?> 
										</td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<tr><td colspan="5"><?=$this->lang->line('no_results'); ?></td></tr>
							<?php  endif;?>
							</tbody>
						</table>
					</div> <!-- End #tab1 -->   
					<div class="tab-content <?php if ($action == 'add'):?> default-tab<?php endif;?>" id="tab2">
					<?php 
						$categoryname			= array('name' => 'categoryname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('categoryname'));
						$categorydescription	= array('name' => 'categorydescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('categorydescription'));
						$options_category 		= array('active' => $this->lang->line('active'), 'inactive' => $this->lang->line('inactive')); 
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => $this->lang->line('add') );
					?>
						<?=form_open('admin/category/add');?>
							<?=form_fieldset($this->lang->line('fieldset_required')); ?>
								<?=form_label($this->lang->line('name') , 'categoryname'); ?>
								<?=form_input($categoryname);?> <?=form_error('categoryname')?>
								<br/><br/>
								<?=form_label($this->lang->line('description'), 'categorydescription'); ?>
								<?=form_textarea($categorydescription);?> <?=form_error('categorydescription')?>
								<br/><br/>
								<?=form_label($this->lang->line('status'), 'categorystatus'); ?>
								<?=form_dropdown('categorystatus', $options_category, 'active'); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab"><?=$this->lang->line('add'); ?>  <?=$this->lang->line('category')  ?></a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$categoryname			= array('name' => 'categoryname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('categoryname', $category->categoryname));
						$categorydescription	= array('name' => 'categorydescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('categorydescription', utf8_decode($category->categorydescription)));
						$options_category 		= array('active' => $this->lang->line('active'), 'inactive' => $this->lang->line('inactive')); 
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => $this->lang->line('save_changes'));
					?>
						<?=form_open('admin/category/edit/' . $category->idcategory);?>
							<?=form_fieldset($this->lang->line('fieldset_required')); ?>
								<?=form_label($this->lang->line('name') , 'categoryname'); ?>
								<?=form_input($categoryname);?> <?=form_error('categoryname')?>
								<br/><br/>
								<?=form_label($this->lang->line('description'), 'categorydescription'); ?>
								<?=form_textarea($categorydescription);?> <?=form_error('categorydescription')?>
								<br/><br/>
								<?=form_label($this->lang->line('status'), 'categorystatus'); ?>
								<?=form_dropdown('categorystatus', $options_category, utf8_encode($category->categorystatus)); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</body>