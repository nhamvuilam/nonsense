<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <link rel="stylesheet" href="<?php echo Core_Global::getApplicationIni()->static_url ?>/css/style.css"></link>
        <script  src="<?php echo Core_Global::getApplicationIni()->static_url ?>/js/jquery.js"></script>
        <script  src="<?php echo Core_Global::getApplicationIni()->static_url ?>/js/jquery.blockUI.js"></script>
        <script  src="<?php echo Core_Global::getApplicationIni()->static_url ?>/js/site.js"></script>
        <title><?php echo Model_Head::getInstance()->getTitle() ?></title>
        <meta content="<?php echo Model_Head::getInstance()->getDescription() ?>" name="description"/>
        <meta content="<?php echo Model_Head::getInstance()->getKeyword() ?>" name="keywords"/>
        <meta property="og:title" content="<?php echo Model_Head::getInstance()->getTitle() ?>" />
        <meta property="og:description" content="<?php echo Model_Head::getInstance()->getDescription() ?>" />
        <?php
        foreach (Model_Head::getInstance()->getCssFiles() as $file) {
            echo '<link rel="stylesheet" href="'.$file.'"></link>';
        }
        foreach (Model_Head::getInstance()->getJsFiles() as $file) {
            echo '<script  src="'.$file.'"></script>';
        }
	foreach (Model_Head::getInstance()->getHeadFiles() as $path) {
            echo $this->render($path);
        }
        ?>
    </head>
    <body>
    <center>
        <div id="wrapper">
            <div id="head">
                
            </div>
            <div id="content">
                <?php echo $this->layout()->content; ?>
            </div>
            <div id="footer">
                <a href="/" style="color: #fff;text-decoration: none"><?php echo SITE_TITLE ?> </a>
            </div>
        </div>
    </center>
    </body>
</html>
