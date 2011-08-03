<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Ativism.pt</h3>
					
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">Por Resolver</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">Resolvidos</a></li>
					</ul>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						<table>
							
							<thead>
								<tr>
								   <th></th>
									<th></th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<!-- 
										<div class="pagination">
											<!--<a href="#" title="First Page">&laquo; Primeira P‡gina</a><a href="#" title="Previous Page">&laquo; Anterior</a>
											<!--<a href="#" class="number" title="1">1</a>
											<a href="#" class="number" title="2">2</a>
											<a href="#" class="number current" title="3">3</a>
											<a href="#" class="number" title="4">4</a>
											<a href="#" title="Next Page">Seguinte &raquo;</a><!--<a href="#" title="Last Page">òltima P‡gina &raquo;</a>
										</div> <!-- End .pagination -->
									
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
								<?php foreach ($active_issues as $issue) { ?>
									<tr>
										<?php if($issue->issuetype == 'bug'){ ?>
											<td class="bugid"><span class="idbug">
										<?php }elseif($issue->issuetype == 'feature'){ ?>
											<td class="bugid">
												<span class="idfeature"><?php } ?>
													<?php echo $issue->idissue;?>
												</span>
											</td>
										<td class="bugid">
											<strong>
												<?php echo utf8_decode($issue->issuetitle); ?>
											</strong><br/> 
											<?php echo utf8_decode($issue->issueintro); ?><br/>
										<small class="extra-info">
											<?php echo $this->lang->line('by');?>: 
										<span class="user-name">
											<?php
											foreach($users as $user){
												if($user->iduser == $issue->iduser){
													echo $user->name . " " . $user->surname;
												}
											} 
											?>
										</span> &#149; <span class="date">
											<?php echo $issue->last_update; ?>
										</span> &#149; 
										<?php if($issue->issuetype == 'bug'){ ?>
												<span class="bug">
													<?php echo $this->lang->line('bug'); ?>
												</span><?php }
											elseif($issue->issuetype == 'feature'){ ?>
												<span class="feature">
													<?php echo $this->lang->line('feature'); ?>
												</span>
											<?php } ?>			
										<span class="important"> &#149; 
											<?php $atributs = array('class' => 'comment');?> 
											<?php echo anchor("admin/issues/comment/$issue->idissue", $this->lang->line('comment'), $atributs); ?>
										</span>
										</small>
										</td>
									</tr>
								<?php }?>
							</tbody>
							
						</table>
						
					</div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
					
					
					
					
					
					
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
			</div> <!-- End .content-box -->
			
			<!-- End Notifications -->
			
			<div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
						&#169; Copyright 2011 BugTracker | by <a href="">marcomonteiro.net</a> | <a href="#">Top</a>
				</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
	</div>
</body>