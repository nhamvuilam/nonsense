<?php use Nvl\Cms\App; ?>
<div class="main-wrap">
    <div id="gag-ads-init-mode"></div>
	<section id="individual-post">
		<div class="badge-entry-collection">
			<?php if(isset($post)) { ?>
				<article class="post-page">
					<header>
						<h2 class="badge-item-title"><?php echo $post['content']['caption']?></h2>
						<p class="post-meta">
			                <a href="javascript:void(0);" class="badge-evt point">
		                        <span itemprop="ratingCount" class="badge-item-love-count"><?php echo $post['metas']['like_count']?></span> likes
		                    </a> ·
			                <a href="javascript:void(0);" class="comment badge-evt">
			                    <span class="badge-item-comment-count" id="countComment<?php echo $post['id'];?>"><?php echo $post['metas']['comment_count'];?></span> comments
			                </a>
			            </p>
					</header>
					<div class="badge-toolbar-pre fixed-wrap-post-bar">
						<div class="fb-like" data-href="<?php echo App::config('site', 'site_url').$post['post_url']?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
						<div class="clearfix"></div>
					</div>
					<div class="badge-post-container badge-entry-content post-container">
						<a href="javascript:void(0);">
						    <?php if ($post['type'] === 'image' ) { ?>
                            	<img class="badge-item-img" src="<?php echo $post['content']['images']['medium']['url']; ?>" alt="<?php echo $post['content']['caption']; ?>" />
                            <?php } else if ($post['type'] === 'video') { ?>
                            	<?php echo $post['content']['embedded_code']; ?>
                            <?php } ?>
						</a>
					</div>
					<div class="post-afterbar-a in-post-bot full-width">
						<div class="share">
						    <ul>
						        <li><a onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=<?php echo App::config('site', 'site_url').$post['post_url']?>', 'facebook_share', 'toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=400, width=640, height=400');" href="javascript:void(0);" class="badge-facebook-share badge-facebook-bot-share badge-evt badge-track btn-share facebook">Share on Facebook</a></li>						        
						    </ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</article>
			<?php } ?>
		</div>
	</section>
	<section class="post-comment">
		<div class="fb-comments" data-href="<?php echo App::config('site', 'site_url').$post['post_url']?>" data-numposts="5" data-colorscheme="light"></div>
	</section>
</div>