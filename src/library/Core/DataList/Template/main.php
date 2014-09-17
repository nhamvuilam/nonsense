<div class="row">
<div class="col-sm-12" style="overflow:auto;">
<div class="">
    <div class="pull-left">
        <div class="dataTables_info" id="datatable2_info"><?php $this->renderSummary();?></div>
    </div>
    <div class="pull-right">
        <div class="dataTables_paginate paging_bs_normal">
        <?php $this->renderPager();?>
        </div>
    </div>
    <div class="clear-fix"></div>
</div>
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
<div class="">
    <div class="pull-left">
        <div class="dataTables_info" id="datatable2_info"><?php $this->renderSummary();?></div>
    </div>
    <div class="pull-right">
        <div class="dataTables_paginate paging_bs_normal">
        <?php $this->renderPager();?>
        </div>
    </div>
    <div class="clear-fix"></div>
</div>
</div>
</div>
