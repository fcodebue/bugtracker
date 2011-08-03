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
					
					<h3><?php echo $project->projectname; ?></h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					<div>
						<h3>#<?php echo $issue->idissue; ?> &#149; 
							<?php
								if($issue->issuetype == 'bug'){ ?>
									<span class="bug"><?php echo $this->lang->line('bug'); ?></span>
								<?php }else{ ?>
									<span class="feature"><?php echo $this->lang->line('feature'); ?></span>
								<?php } ?>
							&#149; <?php echo utf8_decode($issue->issuetitle); ?></h3>
						<small class="extra-info"><?php echo $this->lang->line('by'); ?>: 
						<span class="user-name"> 
							<?php echo anchor("admin/users/profile/$user->iduser", $user->name.' '.$user->surname)?>
						</span> 
						&#149; <span class="date"><?php echo $issue->last_update; ?></span> 
						&#149; <?php
							if($issue->issuetype == 'bug'){ ?>
								<span class="bug"><?php echo $this->lang->line('bug'); ?></span>
							<?php }else{ ?>
								<span class="feature"><?php echo $this->lang->line('feature'); ?></span>
							<?php } ?> 
						<span class="important"> &#149;</small>
							<br/><br/><br/>
						<p>
							<?php echo $issue->issueintro; ?><br/>
							<?php echo nl2br($issue->issuedescription); ?>
						</p>
						<?php if(!empty($issue->issueprint )){ ?>
						<strong>print:</strong><br/>
							<img style="max-width: 700px;" src="issues/<?php echo $issue->issueprint; ?>"/>
						<?php } ?>
						<form action="<?php echo base_url(); ?>index.php/admin/issues/resolve" method="post">
							<input type="hidden" value="<?php echo $issue->idissue; ?>">
							<input class="button resolvebug" type="submit" value="Resolver Bug">
						</form>
						<br/>
						<br/>
						<br/>
						<br/>
						<hr/>
						<h4>Comentários</h4>
						<div class="comment">
							<p><strong>dev. <a href="">Marco Monteiro</a> disse:</strong></p>
							<div style="margin-left: 20px;"><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p><br/><br/>
							<small>12-05-2011 14:32 &#149; <a href="">Responder</a> &#149; <a href="">Editar</a> &#149; <a href="">Apagar</a></small>
							</div>	
						</div>
						<div class="comment" style="padding-left: 50px;">
							<p><strong>web. <a href="">Valter Gonçalves</a> disse:</strong></p>
							<div style="margin-left: 20px;"> <span class="replyto">@Marco Monteiro:</span><br/><br/> <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p><br/><br/>
							<small>12-05-2011 15:12 &#149; <a href="">Responder</a></small>
							</div>	
						</div>
						<div class="comment" style="padding-left: 75px;">
							<p><strong>man. <a href="">Filipe Bernardes</a> disse:</strong></p>
							<div style="margin-left: 20px;"> <span class="replyto">@Valter Gonçalves:</span><br/><br/> <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. <br/> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p><br/><br/>
							<small>12-05-2011 16:15 &#149; <a href="">Responder</a></small>
							</div>	
						</div>
						<div class="comment">
							<p><strong>dev. <a href="">Marco Monteiro</a> disse:</strong></p>
							<div style="margin-left: 20px;"><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p><br/><br/>
							<small>12-05-2011 14:32 &#149; <a href="">Responder</a> &#149; <a href="">Editar</a> &#149; <a href="">Apagar</a></small>
							</div>	
						</div>
						<div class="comment" style="padding-left: 50px;">
							<p><strong>Acc. <a href="">Sara Gomes</a> disse:</strong></p>
							<div style="margin-left: 20px;"> <span class="replyto">@Marco Monteiro:</span><br/><br/> <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</p><br/><br/>
							<small>12-05-2011 15:12 &#149; <a href="">Responder</a></small>
							</div>	
						</div>
						<br/>
						<br/>
						<p><strong>Comentar</strong> &#149; <small> <a href="">Marco Monteiro</a> (Pode usar Html)</small></p>
						<form>
						<textarea class="text-input textarea" id="textarea" name="textfield" cols="79" rows="10">@Sara Gomes Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.</textarea>
						<input style="float:right;" class="button" type="submit" value="Comentar">
						<br/>
						<br/>
						<br/>
						</form>
					
					
					
					
					
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