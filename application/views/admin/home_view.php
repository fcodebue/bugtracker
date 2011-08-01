<body>
	<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<ul class="shortcut-buttons-set">
				<!--<li>
					<a class="shortcut-button" href="<?php echo base_url();?>index.php/admin/news/add">
						<span>
							<img src="<?php echo base_url();?>public/backend/images/icons/news-icon.jpg" alt="icon" /><br />
							Adicionar notícia
						</span>
					</a>
				</li>
				<li>
					<a class="shortcut-button" href="<?php echo base_url();?>index.php/admin/products/add">
						<span>
							<img src="<?php echo base_url();?>public/backend/images/icons/product.png" alt="icon" /><br />
							Adicionar produto
						</span>
					</a>
				</li>
				<li>
					<a class="shortcut-button" href="<?php echo base_url();?>index.php/admin/products/addspecial">
						<span>
							<img src="<?php echo base_url();?>public/backend/images/icons/product_special.png" alt="icon" /><br />
							Adicionar produto especial
						</span>
					</a>
				</li>-->
				<li>
					<a class="shortcut-button" href="#messages" rel="modal">
						<span>
							<img src="<?php echo base_url();?>public/backend/images/icons/comment_48.png" alt="icon" /><br />
							Mensagens
						</span>
					</a>
				</li> 
				<li>
					<a class="shortcut-button" href="<?php echo base_url();?>index.php/admin/trash">
						<span>
							<img src="<?php echo base_url();?>public/backend/images/icons/trashicon.png" alt="icon" /><br />
							<?=$this->lang->line('trash'); ?>
						</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</body>