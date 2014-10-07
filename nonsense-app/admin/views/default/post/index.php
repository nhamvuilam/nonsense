<?php
use Nvl\Cms\Domain\Model\Post\Post;
foreach ($paginatedPost['posts'] as $post) { ?>
    <section>

        <h1><?php echo $post['content']['caption']; ?></h1>
        <div class="content">
            <?php if ($post['type'] === 'image') { ?>
            <img src="<?php echo $post['content']['images']['medium']['url']; ?>"/>
            <?php } else if ($post['type'] === 'video') { ?>
            <?php echo $post['content']['embedded_code']; ?>
            <?php } ?>
        </div>

        <div class="action">

            <?php if ($post['status'] == Post::STATUS_PENDING_REVIEW) { ?>
                <form action="/nghiemtuc/post/<?php echo $post['id'] ?>" method="post">
                    <input type="hidden" name="status" value="<?php echo Post::STATUS_PUBLISHED; ?>" />
                    <input type="submit" value="Publish"/>
                </form>
            <?php } else if ($post['status'] === Post::STATUS_PUBLISHED) { ?>
                <form action="/nghiemtuc/post/<?php echo $post['id'] ?>" method="post">
                    <input type="hidden" name="status" value="<?php echo Post::STATUS_PENDING_REVIEW; ?>" />
                    <input type="submit" value="Pending"/>
                </form>
            <?php }?>

            <form action="/nghiemtuc/post/<?php echo $post['id'] ?>" method="post">
                <input type="hidden" name="status" value="<?php echo Post::STATUS_DELETED; ?>" />
                <input type="submit" value="Trash"/>
            </form>

        </div>
    </section>

<?php } ?>
