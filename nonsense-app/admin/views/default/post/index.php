<?php
use Nvl\Cms\Domain\Model\Post\Post;
if (!empty($paginatedPost['posts'])) {
    foreach ($paginatedPost['posts'] as $post) { ?>
    <section style="width:800px">
    <form action="/nghiemtuc/post/<?php echo $post['id'] ?>" method="post">
        <div class="container" style="overflow:hidden">
            <h1><?php echo $post['content']['caption']; ?></h1>
            <div class="content" style="float:left; width:400px; overflow:hidden">
                <?php if ($post['type'] === 'image') { ?>
                <a href="/nghiemtuc/post/<?php echo $post['id']; ?>"><img src="<?php echo $post['content']['images']['medium']['url']; ?>"/></a>
                <?php } else if ($post['type'] === 'video') { ?>
                <?php echo $post['content']['embedded_code']; ?>
                <?php } ?>
            </div>
            <div class="info" style="float:left">
            <div class="meta">
                <p><em>Posted on:</em> <?php echo date('Y-m-d H:i:s', ''.$post['timestamp']); ?>
                <p><em>Author:</em> <?php echo $post['author']['username']; ?>
                <p><em>Source:</em> <?php echo $post['metas']['additional_data']['source_url']; ?>
                <p>Title<br/><input type="text" value="<?php echo $post['content']['caption']; ?>" style="display:block; height: 20px; font-size: 16px; margin: 10px 0px;"/>
                <p>Tags<br/><input type="text" name="tags" value="<?php echo implode(', ', $post['metas']['tags']); ?>" style="display:block"/>
                <p>Status<br/><select name="status">
                    <?php foreach (Post::$ALLOWED_STATUS as $status) { ?>
                    <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                    <?php } ?>
                </select>
                <p><input type="submit" value="Save"/>
            </div>



            </div>
        </div>

    </form>
    </section>
    <?php } ?>

<?php } else { ?>
<p>No post
<?php } ?>