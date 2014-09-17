<?php 
$itemCount = $this->dataProvider->getItemCount();
?>

<div class="grid_8 z-hotel-list">
    <?php
    if ($itemCount > 0) {
        foreach ($this->dataProvider->getData() as $index => $item) {
            foreach ($this->columns as $column) {
                $column->renderDataCell($index, $item, $itemCount);
            }
        }
    }
    ?>
    
    <div class="z-paging">
        <?php $this->renderPager(); ?>
    </div>
</div>