<style> 
.xlText { mso-number-format: "\@"; }
th,td { border:solid 0.1pt #000000; }
body { border:solid 0.1pt #000000; }

</style>
<table class="grid-view table-bordered dataTable hover">
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
    <?php foreach($this->dataProvider->getData() as $index=>$item){?>
    <tr class="<?php echo $class[$i++%2];?>">
      <?php foreach($this->columns as $column){ ?>
      <?php $column->renderDataCell($index, $item);?>
      <?php } ?>
    </tr>
    <?php } ?>
  </tbody>
  <?php } else { ?>
  <tr>
    <td colspan="<?php echo count($this->columns);?>"><?php echo $this->getEmptyText() ?></td>
  </tr>
  <?php } ?>
</table>
