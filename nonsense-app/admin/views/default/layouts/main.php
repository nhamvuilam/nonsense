<!DOCTYPE html>
<html>
<head>
<style type="text/css">
input,select, button {
	height: 20px;
}
</style>
</head>
<body>
<div id="menu">
<a href="/">Site</a>
<a href="/nghiemtuc/post">Post</a>
</div>
<div id="main">
<?php echo $this->getContent(); ?>
</div>
</body>
</html>