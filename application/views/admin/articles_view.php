w<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3><?=$this->lang->line('articles'); ?></h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab"><?=$this->lang->line('listing'); ?></a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"><?=$this->lang->line('add_article'); ?></a> <?php endif;?>
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
						<?php if ($this->session->flashdata('flashError')):?>
							<div class="notification error png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close') ?>" /></a>
								<div>
									<?=$this->session->flashdata('flashError'); ?>
								</div>
							</div>
						<?php endif;?>	
						<?php if ($this->session->flashdata('flashConfirm')):?>
							<div class="notification success png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="<?=$this->lang->line('close_notify'); ?>" alt="<?=$this->lang->line('close') ?>" /></a>
								<div>
									<?=$this->session->flashdata('flashConfirm'); ?>
								</div>
							</div>
						<?php endif;?>
						
							<?php echo form_open('admin/articles');?>
							<p> <?=$this->lang->line('filter'); ?>
							<select name="by_cat" onChange="this.form.submit();">
								<option value="0"><?=$this->lang->line('all'); ?></option>
								<?php foreach ($categories as $cat): ?>
								<option <?php if($selectedcat == $cat->idcategory):?>selected="selected"<?php endif;?> value="<?php echo $cat->idcategory;?>"><?php echo $cat->categoryname; ?></option>
								<?php endforeach;?>
							</select>
							</p>
						<?php echo form_close();?>
						<?php if($selectedcat != 0):?>
							<a href="<?=base_url();?>index.php/admin/articles/order/<?=$selectedcat; ?>" class="button" style="float: right; margin-top: -25px;"><?=$this->lang->line('order'); ?></a>
						<?php endif;?>
						
						<?php echo form_open('admin/articles/all'); ?>
						<script LANGUAGE="JavaScript">
							function confirmSubmit(){
							var agree=confirm("<?=$this->lang->line('_cont'); ?>");
							if (agree)
								return true ;
							else
								return false ;
							}
						</script>			
						<table id="list-elements">
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>ID</th>
								   <th><?=$this->lang->line('title'); ?></th>
								   <th><?=$this->lang->line('category'); ?></th>								   
								   <th><?=$this->lang->line('modification'); ?></th>
								   <th><?=$this->lang->line('status'); ?></th>
								   <th><?=$this->lang->line('actions'); ?></th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											<select name="dropdown">
												<option disabled="disabled"><?=$this->lang->line('choose_option'); ?></option>
												<option value="publish"><?=$this->lang->line('publish'); ?></option>
												<option value="unpublish"><?=$this->lang->line('unpublished'); ?></option>
												<option value="delete"><?=$this->lang->line('delete'); ?></option>
											</select>
											<?php $submit_all = array('value' => $this->lang->line('apply_all'), 'class' => 'button', 'onClick' => 'return confirmSubmit()');?>
											<?php echo form_submit($submit_all);?>
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
							<?php if(!empty($new_order)):?>
								<tbody id="reorder">
							<?php else: ?>
								<tbody>
							<?php endif;?>
							<?php if(isset($records) && is_array($records) && count($records) > 0): ?>
								<?php foreach ($records as $row):?>
									<tr id="item-<?php echo $row->idarticle; ?>">
										<td><input name="check[<?=$row->idarticle; ?>]" type="checkbox" value="<?=$row->idarticle; ?>"/></td>
										<td><?=$row->idarticle; ?></td>
										<td><?=utf8_decode($row->articletitle); ?></td>
										<td>
										<?php foreach ($categories as $category):?>
												<?php if ($row->idcategory == $category->idcategory):?>
														<?=$category->categoryname; ?>
												<?php endif;?>
										<?php endforeach;?>
										</td>
										<td><?php echo $row->articletimestamp; ?></td>
										<td>
										<?php if ($row->articlestatus == 'active') {
											echo $this->lang->line('published'); 
										}
										elseif ($row->articlestatus == 'inactive'){
											echo "<span style=\"color: red;\">". $this->lang->line('unpublished') ."</span>";
										}
										?>
										</td>
										<td>
											<!-- Icons -->
											<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"" .$this->lang->line('edit') . "\" />"; ?>
											<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"" .$this->lang->line('delete') . "\" />"; ?>
											<?=anchor("admin/articles/edit/$row->idarticle", $edit_icon, 'title="'. $this->lang->line('edit') .'"'); ?>
											<?=anchor("admin/articles/delete/$row->idarticle", $delete_icon, 'title="'. $this->lang->line('delete') .' " onclick="return confirm(\''.$this->lang->line('you_sure_del').'\')"'); ?> 
										</td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<tr><td colspan="7"><?=$this->lang->line('no_results'); ?></td></tr>
							<?php  endif;?>
							</tbody>							
						</table>
						<?php echo form_close();?>
					</div> <!-- End #tab1 -->   
					<div class="tab-content <?php if ($action == 'add'):?> default-tab<?php endif;?>" id="tab2">
					<?php 
						$articletitle			= array('name' => 'articletitle', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('articletitle'));
						$articledate			= array('name' => 'articledate', 'class' => 'text-input small-input', 'id'=>'date', 'value' => set_value('articledate') );
						
						$articleintro			= array('name' => 'articleintro', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articleintro'));
						$articledescription		= array('name' => 'articledescription', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articledescription'));
						$options_article 		= array('active' => $this->lang->line('active'), 'inactive' => $this->lang->line('inactive')); 
						$articleimage			= array('name' => 'userfile');
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => $this->lang->line('add'));
					?>
						<?=form_open_multipart('admin/articles/add');?>
							<?=form_fieldset($this->lang->line('fieldset_required')); ?>
								<?=form_label('Categoria', 'idcategory'); ?>
									<select name="idcategory">
								 	 	<option value="0"><?=$this->lang->line('no_category'); ?></option>
								 	 	<?php foreach ($categories as $category):?>
								 	 	<option value="<?=$category->idcategory; ?>"><?=$category->categoryname; ?></option>	
								 	 	<?php endforeach;?>
									</select>
									<br/><br/>
								<?=form_label($this->lang->line('title'), 'articletitle'); ?>
								<?=form_input($articletitle);?> <?=form_error('articletitle')?>
								<br/><br/>
								<script language="Javascript" >
									$(document).ready(function() {	 

									<?php if($this->session->userdata('language') == 'pt') :?>
										/* Protuguese initialisation for the jQuery UI date picker plugin. */
										/* Written by Tiago Laranjeiro Carvalho (tiagocarvalho640@gmail.com). */
										jQuery(function($){
											$.datepicker.regional['pt-PT'] = {
												closeText: 'Fechar',
												prevText: 'Anterior',//&#x3c;
												nextText: 'Pr&oacute;ximo',//&#x3e;
												currentText: 'Hoje',
												monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
												'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
												monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
												'Jul','Ago','Set','Out','Nov','Dez'],
												dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','S&aacute;bado'],
												dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
												dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
												weekHeader: 'Sm',
												firstDay: 0,
												isRTL: false,
												showMonthAfterYear: false,
												yearSuffix: ''};
											$.datepicker.setDefaults($.datepicker.regional['pt-PT']);
										}); 
										<?php endif;?>
										$("#date").datepicker();
										$("#date").datepicker('option','changeMonth', true);
										$("#date").datepicker('option','changeYear', true);
										$("#date").datepicker('option','dateFormat', 'dd-mm-yy');
										
										 });
								</script>		
								<?=form_label($this->lang->line('date'), 'articledate'); ?> 
								<?=form_input($articledate);?><?=form_error('articledate')?>
								<br/><br/>
								<?=form_label($this->lang->line('intro'), 'articleintro'); ?> 
								<?=form_textarea($articleintro);?><?=form_error('articleintro')?>
								<br/><br/>
								<?=form_label($this->lang->line('description'), 'articledescription'); ?>
								<?=form_textarea($articledescription);?>
								<br/><br/>
								<?=form_label($this->lang->line('status'), 'articlestatus'); ?>
								<?=form_dropdown('articlestatus', $options_article, 'active'); ?>
								<br/><br/>
								<?=form_label( $this->lang->line('image'), 'userfile');?>
								<?=form_upload($articleimage);?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab"><?=$this->lang->line('edit'); ?> <?=$this->lang->line('article'); ?></a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$articletitle			= array('name' => 'articletitle', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('articletitle', utf8_decode($article->articletitle) ));
						$articleintro			= array('name' => 'articleintro', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articleintro', utf8_decode($article->articleintro)));
						
						$new_date = new DateTime( $article->articledate );
						$new_date = date_format( $new_date ,"d-m-Y");
						
						$articledate			= array('name' => 'articledate', 'class' => 'text-input small-input', 'id'=>'date', 'value' => set_value('articledate', $new_date ) );
						$articledescription		= array('name' => 'articledescription', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articledescription', utf8_decode($article->articledescription)));
						$options_article 		= array('active' => $this->lang->line('active'), 'inactive' => $this->lang->line('inactive')); 
						$articleimage			= array('name' => 'userfile');
						$submit					= array('class' => 'button', 'id' => 'submit_article', 'value' => $this->lang->line('save_changes') );
					?>
						<?=form_open_multipart('admin/articles/edit/' . $article->idarticle);?>
							<?=form_fieldset($this->lang->line('fieldset_required')); ?>
							<?=form_label('Categoria', 'idcategory'); ?>
									<select name="idcategory">
								 	 	<option value="0"><?=$this->lang->line('no_category'); ?></option>
								 	 	<?php foreach ($categories as $category):?>
								 	 	<option value="<?=$category->idcategory; ?>"<?php if ($category->idcategory == $article->idcategory):?> selected="selected" <?php endif;?>><?=$category->categoryname; ?></option>	
								 	 	<?php endforeach;?>
									</select>
								<br/><br/>
								<?=form_label($this->lang->line('title'), 'articletitle'); ?>
								<?=form_input($articletitle);?> <?=form_error('articletitle')?>
								<br/><br/>
								<script language="Javascript" >
									$(document).ready(function() {	 

									<?php if($this->session->userdata('language') == 'pt') :?>
										/* Protuguese initialisation for the jQuery UI date picker plugin. */
										/* Written by Tiago Laranjeiro Carvalho (tiagocarvalho640@gmail.com). */
										jQuery(function($){
											$.datepicker.regional['pt-PT'] = {
												closeText: 'Fechar',
												prevText: 'Anterior',//&#x3c;
												nextText: 'Pr&oacute;ximo',//&#x3e;
												currentText: 'Hoje',
												monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
												'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
												monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
												'Jul','Ago','Set','Out','Nov','Dez'],
												dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','S&aacute;bado'],
												dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
												dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b'],
												weekHeader: 'Sm',
												firstDay: 0,
												isRTL: false,
												showMonthAfterYear: false,
												yearSuffix: ''};
											$.datepicker.setDefaults($.datepicker.regional['pt-PT']);
										}); 
										<?php endif;?>
										$("#date").datepicker();
										$("#date").datepicker('option','changeMonth', true);
										$("#date").datepicker('option','changeYear', true);
										$("#date").datepicker('option','dateFormat', 'dd-mm-yy');
										
										 });
								</script>
								<?=form_label($this->lang->line('date'), 'articledate'); ?> 
								<?=form_input($articledate);?><?=form_error('articledate')?>
								<br/><br/>
								<?=form_label($this->lang->line('intro'), 'articleintro'); ?>
								<?=form_textarea($articleintro);?> <?=form_error('articleintro')?>
								<br/><br/>
								<?=form_label($this->lang->line('description'), 'articledescription'); ?>
								<?=form_textarea($articledescription);?>
								<br/><br/>
								<?=form_label($this->lang->line('status'), 'articlestatus'); ?>
								<?=form_dropdown('articlestatus', $options_article, utf8_encode($article->articlestatus)); ?>
								<br/><br/>
								<? if($article->articleimage) : ?>
									<img width="200" src="<?=base_url(); ?>public/images/articles/<?=$article->articleimage; ?>"/>
								<?php endif; ?>	
								<br/>
								<?=form_label($this->lang->line('change_image') , 'userfile');?>
								<?=form_upload($articleimage);?>
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
	<script type="text/javascript">
		$(document).ready(function () {
			$('#reorder').sortable({
				opacity: '0.5',
				update: function(e, ui){
					newOrder = $(this).sortable("serialize");
					console.log(newOrder);
					$.ajax({
						url: "<?php echo base_url();?>index.php/admin/articles/reorder",
						type: "POST",
						data: newOrder,
						success: function(feedback){
							 $("#feedback").html(feedback);
						}
					});
				}
			});
		});
	</script>
</body>