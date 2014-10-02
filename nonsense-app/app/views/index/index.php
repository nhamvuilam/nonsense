<div class="main-wrap">
    <div id="gag-ads-init-mode"></div>
	<section id="list-view-2" class="badge-list-view-element variant-right">
		<div class="badge-entry-collection">
			<?php if(isset($posts['posts'])) {
				foreach($posts['posts'] as $post) {?>
					<article class="badge-entry-container badge-entry-entity">
						<header>
							<h2 class="badge-item-title">
							  <a class="badge-evt badge-track" href="<?php echo $post['post_url']; ?>">
							     <?php echo $post['content']['caption']?>
							  </a>
							</h2>
						</header>
						<div class="badge-post-container post-container">
							<a href="<?php echo $post['post_url']; ?>">
                                <img class="badge-item-img" src="<?php echo ($post['type'] == 'image' ? $post['content']['images']['medium']['url'] : $post['content']['image_url']) ?>" alt="<?php echo $post['image']['caption']?>" />
							</a>
						</div>
						<p class="post-meta">
							<a class="badge-evt point" id="love-count-aAVP4Go" href="<?php echo $post['post_url']?>" target="_blank"
							data-evt="EntryAction,VotePointLinkUnderTitle,ListPage"> <span class="badge-item-love-count">0</span> points</a> &middot;
							<a class="comment badge-evt" href="/" target="_blank"
								data-evt="EntryAction,CommentLinkUnderTitle,ListPage" >
								<fb:comments-count href="<?php echo $post['post_url']?>"/></fb:comments-count> comments
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
									<li>
										<a class="comment badge-evt badge-item-comment" target="_blank" href="/gag/aAVP4Go#comment"
										data-evt="EntryAction,CommentButtonClicked,ListPage">Comment</a>
									</li>
								</ul>
							</div>
							<div class="share right">
								<ul>
									<li>
										<a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook"
										data-track="social,fb.s,,,d,aAVP4Go,l"
										data-evt="Facebook-Share,ListClicked,http://9gag.com/gag/aAVP4Go"
										data-share="http://9gag.com/gag/aAVP4Go?ref=fb.s">Facebook</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="badge-twitter-share badge-evt badge-track btn-share twitter"
										data-track="social,t.s,,,d,aAVP4Go,l"
										data-evt="Twitter-Share,ListClicked,http://9gag.com/gag/aAVP4Go"
										data-title="How%20to%20properly%20text%20in%20class"
										data-share="http://9gag.com/gag/aAVP4Go?ref=t">Twitter</a>
									</li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
					</article>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="loading">
			<a class="btn badge-load-more-post" href="/?id=aMbwODP%2CanX1w9q%2CamLzeoV&c=10" data-loading-text="Loading more posts..." data-load-count-max="30">Load more posts</a>
		</div>
		<span id="jsid-gat-interval" data-post-interval="-1" class="hide">1410500109</span><span id="jsid-latest-entries" class="hide">aAVP4Go,awbVLDW,a49Z766,aRgeDYj,aDwG7wx,a6dQ35N,aVQDRq2,amLzeoV,anX1w9q,aMbwODP</span>
	</section>
</div>