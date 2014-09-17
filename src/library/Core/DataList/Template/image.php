<div class="image_manager">
<?php if($this->dataProvider->getItemCount()>0){?>  
    <?php foreach($this->dataProvider->getData() as $index=>$item){?>
		<div class="item">
			<?php foreach($this->columns as $column){ ?>
				<?php $column->renderDataCell($index, $item);?>
			<?php } ?>
		</div>     	
    <?php }?>
  <?php }else{?>
  <div class="empty"><?php echo $this->getEmptyText() ?></div>
  <?php }?>
</div>
<div class="clr"></div>
<div class="pager_content">
	<?php $this->renderPager();?>
</div>