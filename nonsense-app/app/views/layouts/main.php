<!DOCTYPE html>
<html lang="en">       
<?php $this->partial("template/header") ?>
<div id="container">
    <div class="badge-page page ">
    	<?php $this->flashSession->output() ?>
        <?php echo $this->getContent() ?>
        <?php $this->partial("template/slidebar", array(
        	'display' => isset($display_slidebar) ?  $display_slidebar : 0));
    	?>
        <?php $this->partial("template/popup");?>    
        <!--end overlay-container-->
        <div class="clearfix"></div>
  </div>
</div>
<!--end #container-->
<?php $this->partial("template/footer") ?>
</body>
</html>
