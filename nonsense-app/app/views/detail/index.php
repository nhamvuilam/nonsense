<div class="main-wrap">
    <div id="gag-ads-init-mode"></div>                    
	<section id="list-view-2" class="badge-list-view-element variant-right">
		<div class="badge-entry-collection">
			<?php if(isset($data['posts'])) { ?>
				<article class="badge-entry-container badge-entry-entity">
					<header>
						<h2 class="badge-item-title">
							<a class="badge-evt badge-track" href="javascript:void(0)"> <?php echo $data['posts']['content']['caption']?> </a>
						</h2>
					</header>
					<div class="badge-post-container post-container">
						<a href="<?php echo $data['posts']['post_url']?>" class="badge-animated-cover badge-track badge-track-no-follow" style="max-height:500px;padding-left:32px;"> 							
							<div class="badge-animated-container-static gif-post presenting">
								<img height="<?php echo $data['posts']['content']['images']['medium']['height']?>" width="<?php echo $data['posts']['content']['images']['medium']['width']?>"  class="badge-item-img" src="<?php echo $data['posts']['content']['images']['medium']['url']?>" alt="<?php echo $data['posts']['content']['caption']?>" />
							</div> 
						</a>
					</div>
					<p class="post-meta"> 
						<a class="badge-evt point" id="love-count-aAVP4Go" href="javascript:void(0);"> 
							<span class="badge-item-love-count">0</span> points
						</a> &middot; 
						<a class="comment badge-evt" href="javascript:void(0);">
							<fb:comments-count href="<?php echo $data['posts']['post_url']?>"/></fb:comments-count> comments
						</a>
					</p>
					<div class="badge-item-vote-container post-afterbar-a in-list-view">
						<div class="vote">
							<ul class="btn-vote left">
								<li>
									<a class="badge-item-vote-up up " href="javascript:void(0);">Upvote</a>
								</li>
								<li>
									<a class="badge-item-vote-down down " href="javascript:void(0);">Downvote</a>
								</li>								
							</ul>
						</div>
						<div class="share right">
							<ul>
								<li>
									<a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook" data-share="http://9gag.com/gag/aAVP4Go?ref=fb.s">Facebook</a>
								</li>								
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</article>					
			<?php } ?>			
		</div>		
	</section>
	<section class="post-comment">
		<div class="fb-comments" data-href="<?php echo $data['posts']['post_url']?>" data-numposts="5" data-colorscheme="light"></div>
	</section>
</div>	