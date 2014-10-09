<?php use Nvl\Cms\App;?>
<?php if (isset($data_seo) && !empty($data_seo)) { ?>
	<title><?php echo $data_seo['content']['caption']?></title>
	<meta name="keywords" content="<?php echo implode(",", $data_seo['metas']['tags']);?>" />
	<meta name="description" content="Nham VL, vui lam, nham vui lam" />
	<meta property="og:title" content="<?php echo $data_seo['content']['caption']?>" />
	<meta property="og:site_name" content="nhamvl.com" />
	<meta property="og:url" content="<?php echo App::config('site', 'site_url').$data_seo['post_url']; ?>" />
	<meta property="og:description" content="Nham VL, vui lam, nham vui lam, <?php echo $data_seo['content']['caption']?>" />
	<meta property="og:image" content="<?php echo $data_seo['type']==='image' ? $data_seo['content']['images']['medium']['url'] :  $data_seo['content']['image_url']; ?>" />
	<meta property="og:type" content="blog" />
<?php } else { ?>
	<title>Nham VL</title>
	<meta name="keywords" content="Nham VL" />
	<meta name="description" content="Nham VL, vui lam, nham vui lam" />
	<meta property="og:title" content="Nhảm vui lắm" />
	<meta property="og:site_name" content="nhamvl.com" />
	<meta property="og:url" content="<?php echo App::config('site', 'site_url'); ?>" />
	<meta property="og:description" content="Nham VL, vui lam, nham vui lam" />
	<meta property="og:type" content="blog" />
<?php } ?>

