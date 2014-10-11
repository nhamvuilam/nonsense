<?php use Nvl\Cms\App; ?>
<div class="main-wrap">
    <div id="gag-ads-init-mode"></div>
	<section id="list-view-2" class="badge-list-view-element variant-right">
		<div class="badge-entry-collection" id="loadPosts">
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
                                <img class="badge-item-img" src="<?php echo ($post['type'] == 'image' ? $post['content']['images']['medium']['url'] : $post['content']['image_url']) ?>" alt="<?php echo $post['content']['caption']?>" />
							</a>
						</div>
						<p class="post-meta">
							<a class="badge-evt point" href="javascript:void(0)"><span class="badge-item-love-count" id="countLike<?php echo $post['id'];?>"><?php echo $post['metas']['like_count'];?></span> likes</a> &middot;
							<a target="_blank" href="<?php echo $post['post_url']?>" class="comment badge-evt"><?php echo $post['metas']['comment_count'];?> comments</a>							
						</p>
						<div class="badge-item-vote-container post-afterbar-a in-list-view  ">
							<div class="vote">
								
								<ul class="btn-vote left">
									<li>
										<div class="fb-like" data-href="<?php echo App::config('site', 'site_url').$post['post_url']?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
									</li>									
									<li>
										<a class="comment badge-evt badge-item-comment" target="_blank" href="<?php echo $post['post_url']?>">Comment</a>
									</li>
								</ul>
							</div>
							<div class="share right">
								<ul>
									<li>
										<a onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=<?php echo App::config('site', 'site_url').$post['post_url']?>', 'facebook_share', 'toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=400, width=640, height=400');" href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook">Facebook</a>
									</li>									
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
					</article>
				<?php } ?>
			<?php } ?>
		</div>		
	</section>	
</div>
<script type="text/javascript">
	var domainPath = '<?php echo App::config('site', 'site_url');?>';
	jQuery(document).ready(function() {
		var track_load = 10; //total loaded record group(s)
		var loading  = false; //to prevents multipal ajax loads
		var total_groups = <?php echo $posts['total'] ?>; //total record group(s) 
		
		if (track_load > total_groups)
			track_load = total_groups;
		
		jQuery(window).scroll(function() { //detect page scroll
						
			// check scroll for load more post
			if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height())  //user scrolled to bottom of the page?
			{				
				if(track_load <= total_groups && loading == false) //there's more data to load
				{														
					loading = true; //prevent further ajax loading
					$.ajax({
			            type: 'GET',dataType: 'json',url: "/load",
			            data: {'limit': 10,'offset': track_load},
			            success: function(response) {
			            	var posts = response.posts;
			            	var html = '';
			            	if (posts != '') {
			            		$.each(posts, function(index) {			            			
			            			html+=getPostItem(posts[index]);									
								});
								jQuery("#loadPosts").append(html);
			            	}
			            }
			        });
			        track_load += 10;
			        loading = false;
				}
			}
		});
		$(document).ajaxComplete(function(){
		    try{
		        FB.XFBML.parse(); 
		    }catch(ex){}
		});
	});	
	function getPostItem(post){		
		var html = '<article class="badge-entry-container badge-entry-entity">';
				html +='<header><h2 class="badge-item-title"><a class="badge-evt badge-track" href="'+post.post_url+'">' + post.content['caption'] + '</a></h2></header>';
				html +='<div class="badge-post-container post-container">';
					html +='<a href="'+post.post_url+'">';
						if (post.type == 'image') {
							html +='<img class="badge-item-img" src="'+post.content['images']['medium']['url']+'" alt="'+post.content['caption']+'" />';
						} else {
							html +='<img class="badge-item-img" src="'+post.content['image_url']+'" alt="'+post.content['caption']+'" />';
						}              
					html +=	'</a>';
				html +=	'</div>';
				html +=	'<p class="post-meta">';					
					html +=	'<a class="badge-evt point" href="javascript:void(0)"><span class="badge-item-love-count" id="countLike'+post.id+'" >'+post.metas['like_count']+'</span> likes</a> &middot; ';					
					html +=	'<a class="comment badge-evt" href="'+post.post_url+'"> '+post.metas['comment_count']+' comments </a>';						
				html +=	'</p>';
				html +=	'<div class="badge-item-vote-container post-afterbar-a in-list-view ">';
					html +=	'<div class="vote">';
						html +=	'<ul class="btn-vote left">';							
							html +=	'<li><div class="fb-like" data-href="'+domainPath + post.post_url+'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div> </li>';							
							html +=	'<li><a class="comment badge-evt badge-item-comment" target="_blank" href="'+post.post_url+'">Comment</a></li>';									
						html +=	'</ul>';
					html +=	'</div>';					
					html +=	'<div class="share right">';
						html +=	'<ul><li><a onclick="window.open(\'http://www.facebook.com/sharer/sharer.php?u='+ domainPath + post.post_url +'\', \'facebook_share\', \'toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=400, width=640, height=400\' )" href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook">Facebook</a></li></ul>';							
					html +=	'</div>';
					html +=	'<div class="clearfix"></div>';
				html +=	'</div>';
			html +=	'</article>';
		return html;
	}
</script>