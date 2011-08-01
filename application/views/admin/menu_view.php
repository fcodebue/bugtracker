<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3><?=$this->lang->line('menus') ?></h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab"><?=$this->lang->line('listing'); ?></a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"> <?=$this->lang->line('add_menu'); ?> </a> <?php endif;?>
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
						<?php if ($this->session->flashdata('flashError')):?>
							<div class="notification error png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang-line('close'); ?>" /></a>
								<div>
									<?=$this->session->flashdata('flashError'); ?>
								</div>
							</div>
						<?php endif;?>	
						<?php if ($this->session->flashdata('flashConfirm')):?>
							<div class="notification success png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang-line('close'); ?>" /></a>
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
								   <th><?=$this->lang->line('name'); ?> </th>
								   <th><?=$this->lang->line('status'); ?> </th>
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
									<?php if ($row->parent == '0' || $row->parent == NULL):?>
										<tr class="menu">
											<!-- <td><input type="checkbox" /></td> -->
											<td><?=$row->idmenu; ?></td>
											<td><strong style="font-size: 14px;"><?=$row->menuname; ?></strong></td>
											<td>
											<?php if($row->menustatus == "active") { 
															echo $this->lang->line('published');
													} 
													elseif( $row->menustatus == "inactive" ) {
															echo "<span style=\"color: red;\">". $this->lang->line('unpublished') ."</span>";
													} ?>
											</td>
											<td>
												<!-- Icons -->
												<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"" .$this->lang->line('edit') . "\" />"; ?>
												<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"" .$this->lang->line('delete') . "\" />"; ?>
												<?=anchor("admin/menus/edit/$row->idmenu", $edit_icon, 'title=" '. $this->lang->line('edit') . '"'); ?>
												<?=anchor("admin/menus/delete/$row->idmenu", $delete_icon, 'title=" '. $this->lang->line('delete') . '" onclick="return confirm(\'' . $this->lang->line('you_sure_del') . '\')"'); ?> 
											</td>
										</tr>
									<?php foreach ($records as $submenu):?>
										<?php if ($row->parent != '0' || $row->parent != NULL):?>
											<?php if($row->idmenu == $submenu->parent):?>
												<tr class="submenu">
													<!-- <td><input type="checkbox" /></td> -->
													<td><?=$submenu->idmenu; ?></td>
													<td>&nbsp;&nbsp;&nbsp;&nbsp;<?=$submenu->menuname; ?></td>
													<td>
													<?php if($submenu->menustatus == "active") { 
															echo $this->lang->line('published');
														} 
														elseif( $submenu->menustatus == "inactive" ) {
															echo "<span style=\"color: red;\">". $this->lang->line('unpublished') ."</span>";
														} ?>
													</td>
													<td>
														<!-- Icons -->
														<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\" " .$this->lang->line('edit') . "\" />"; ?>
														<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\" " .$this->lang->line('delete') . "\" />"; ?>
														<?=anchor("admin/menus/edit/$submenu->idmenu", $edit_icon, 'title=" '. $this->lang->line('edit') . '"'); ?>
														<?=anchor("admin/menus/delete/$submenu->idmenu", $delete_icon, 'title=" '. $this->lang->line('delete') . '" onclick="return confirm(\'' . $this->lang->line('you_sure_del') . '\')"'); ?> 
													</td>
												</tr>
												<?php foreach($records as $subsubmenu):?>
													<?php if($submenu->idmenu == $subsubmenu->parent):?>
														<tr class="subsubmenu">
															<!-- <td><input type="checkbox" /></td> -->
															<td><?=$subsubmenu->idmenu; ?></td>
															<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$subsubmenu->menuname; ?></td>
															<td>
															<?php if($subsubmenu->menustatus == "active") { 
																		echo $this->lang->line('published');
																	} 
																	elseif( $subsubmenu->menustatus == "inactive" ) {
																		echo "<span style=\"color: red;\">". $this->lang->line('unpublished') ."</span>";
																	} ?>
															</td>
															<td>
																<!-- Icons -->
																<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"" .$this->lang->line('edit') . "\" />"; ?>
																<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"" .$this->lang->line('delete') . "\" />"; ?>
																<?=anchor("admin/menus/edit/$subsubmenu->idmenu", $edit_icon, 'title=" '. $this->lang->line('edit') . '"'); ?>
																<?=anchor("admin/menus/delete/$subsubmenu->idmenu", $delete_icon, 'title=" '. $this->lang->line('delete') . '" onclick="return confirm(\'' . $this->lang->line('you_sure_del') . '\')"'); ?> 
															</td>
														</tr>
													<?php endif;?>
												<?php endforeach;?>
											<?php endif;?>
										<?php endif;?>
									<?php endforeach;?>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
							</tbody>
						</table>
					</div> <!-- End #tab1 -->   
					<div class="tab-content <?php if ($action == 'add'):?> default-tab<?php endif;?>" id="tab2">
					<?php 
						$menuname			= array('name' => 'menuname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('menuname'));
						$menudescription	= array('name' => 'menudescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('menudescription'));
						$options_menu 		= array('active' => $this->lang->line('active') , 'inactive' => $this->lang->line('inactive') ); 
						$options_menutype 	= array('static' => $this->lang->line('static') , 'category' => $this->lang->line('category') ); 
						$submit				= array('class' => 'button', 'id' => 'submit_menu', 'value' => $this->lang->line('add') );
					?>
						<?=form_open('admin/menus/add');?>
							<?=form_fieldset($this->lang->line('fieldset_required') ); ?>
								<?=form_label($this->lang->line('name') , 'menuname'); ?>
								<?=form_input($menuname);?> <?=form_error('menuname')?>
								<br/><br/>
								<?=form_label($this->lang->line('type_menu') , 'menutype'); ?>
								<?=form_dropdown('menutype', $options_menutype, 'static', 'id="menutype" class="menutype"'); ?>
								<br/><br/>
								<?=form_label($this->lang->line('article') , 'idarticle'); ?>
									<select name="idarticle">
										<option></option>
										<?php foreach ($articles as $article):?>
											<option value="<?=$article->idarticle;?>"><?=$article->articletitle; ?></option>
										<?php endforeach;?>
									</select>
								<br/><br/>
								<?=form_label($this->lang->line('category') , 'idarticle'); ?>
									<select name="idcategory">
										<option></option>
										<?php foreach ($categories as $category):?>
											<option value="<?=$category->idcategory;?>"><?=$category->categoryname; ?></option>
										<?php endforeach;?>
									</select>
								<br/><br/>
								<?=form_label($this->lang->line('child_of') , 'parent'); ?>
									<select name="parent">
										<option></option>
										<?php foreach ($menus as $menu):?>
												<?php if ($menu->parent == '0' || $menu->parent == NULL):?>
													<option value="<?=$menu->idmenu; ?>"><?=$menu->menuname; ?></option>
												<?php foreach ($menus as $submenu):?>
													<?php if ($row->parent != '0' || $row->parent != NULL):?>
														<?php if($menu->idmenu == $submenu->parent):?>
															<option value="<?=$submenu->idmenu; ?>"><?='&nbsp;&nbsp;&nbsp;&nbsp;'.$submenu->menuname; ?></option>
															<?php foreach($menus as $subsubmenu):?>
																<?php if($submenu->idmenu == $subsubmenu->parent):?>
																	<option value="<?=$subsubmenu->idmenu; ?>"><?='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$subsubmenu->menuname; ?></option>
																<?php endif;?>
															<?php endforeach;?>
														<?php endif;?>
													<?php endif;?>
												<?php endforeach;?>
											<?php endif;?>
										<?php endforeach;?>
									</select>
								<br/><br/>
								<?=form_label($this->lang->line('description') , 'menudescription'); ?>
								<?=form_textarea($menudescription);?>
								<br/><br/>
								<?=form_label($this->lang->line('status') , 'menustatus'); ?>
								<?=form_dropdown('menustatus', $options_menu, 'active'); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab"><?=$this->lang->line('edit')  ?> <?=$this->lang->line('menu')  ?></a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$menuname			= array('name' => 'menuname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('menuname', $menu->menuname));
						$menudescription	= array('name' => 'menudescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('menudescription', utf8_decode($menu->menudescription)));
						$options_menu 		= array('active' => $this->lang->line('active') , 'inactive' => $this->lang->line('inactive') ); 
						$submit				= array('class' => 'button', 'id' => 'submit_menu', 'value' => $this->lang->line('save_changes') );
					?>
						<?=form_open('admin/menus/edit/' . $menu->idmenu);?>
							<?=form_fieldset($this->lang->line('fieldset_required') ); ?>
								<?=form_label($this->lang->line('name') , 'menuname'); ?>
								<?=form_input($menuname);?> <?=form_error('menuname')?>
								<br/><br/>
								<?=form_label($this->lang->line('description') , 'menudescription'); ?>
								<?=form_textarea($menudescription);?>
								<br/><br/>
								<?=form_label($this->lang->line('status') , 'menustatus'); ?>
								<?=form_dropdown('menustatus', $options_menu, utf8_encode($menu->menustatus)); ?>
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