<div style="float:right;padding:5px;"><?php $this->renderSummary();?> </div>
<br style="clear:both;"/>
<table class="grid-view">
  <thead>
    <tr class="head">
		<?php foreach ($this->columns as $column){ ?>
			<?php echo $column->renderHeaderCell() ?>
		<?php } ?>
	</tr>
  </thead>
  <?php
		$i = 0;
		$class = array('even', 'odd');
  ?>
  <?php if($this->dataProvider->getItemCount()>0){?>
  <tbody>
    <?php foreach ($this->dataProvider->getData() as $index => $item){?>
    <tr class="<?php echo $class[$i++%2];?>">
      <?php foreach($this->columns as $column){ ?>
      <?php     $column->renderDataCell($index, $item);?>
      <?php } ?>
    </tr>
    <?php }?>
  </tbody>
  <?php }else{?>
  <tr>
    <td colspan="<?php echo count($this->columns);?>"><?php echo $this->getEmptyText() ?></td>
  </tr>
  <?php }?>
</table>
<div class="pager_content">
<?php $this->renderPager();?>
</div>