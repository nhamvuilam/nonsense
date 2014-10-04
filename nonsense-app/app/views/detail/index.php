<div class="main-wrap">
    <div id="gag-ads-init-mode"></div>
	<section id="list-view-2" class="badge-list-view-element variant-right">
		<div class="badge-entry-collection">
			<?php if(isset($data['post'])) { ?>
				<article class="badge-entry-container badge-entry-entity">
					<header>
						<h2 class="badge-item-title">
						  <a class="badge-evt badge-track" href="javascript:void(0);">
						     <?php echo $data['post']['content']['caption']?>
						  </a>
						</h2>
					</header>
					<div class="badge-post-container post-container">
						<a href="javascript:void(0);">
						    <?php if ($data['post']['type'] === 'image' ) { ?>
                            <img class="badge-item-img" src="<?php echo $data['post']['content']['images']['medium']['url']; ?>" alt="<?php echo $data['post']['image']['caption']; ?>" />
                            <?php } else if ($data['post']['type'] === 'video') { ?>
                            <?php echo $data['post']['content']['embedded_code']; ?>
                            <?php }?>
						</a>
					</div>
					<p class="post-meta">
						<a class="badge-evt point" href="javascript:void(0)"><span class="badge-item-love-count">0</span> points</a> &middot;
						<a class="comment badge-evt" href="javascript:void(0);">
							<fb:comments-count href="<?php echo $data['post']['post_url']?>"/></fb:comments-count> comments
						</a>
					</p>
					<div class="badge-item-vote-container post-afterbar-a in-list-view  ">
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
									<a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook" data-share="https://www.facebook.com/pages/G%C3%B3c-H%C3%A0i/281158712077617">Facebook</a>
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
		<div class="fb-comments" data-href="<?php echo $data['post']['post_url']?>" data-numposts="5" data-colorscheme="light"></div>
	</section>
</div>