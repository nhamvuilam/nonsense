<?php
$itemCount = $this->dataProvider->getItemCount();
$city_id = Core_Map::getParam('city_id');
$country_id = Core_Map::getParam('country_id');
$area_id = Core_Map::getParam('area_id');
$search_type = Core_Map::getParam('search_type');
$keyword = Core_Map::getParam('keyword');
?> 
<div class="span9 ">
    <h5>
        Tìm thấy <span style="color:#00a1f1; font-size:18px;"><?php echo $itemCount; ?></span> khách sạn
        <?php
        if ($search_type == 0) {
            echo ' cho từ khóa "<span style="color:#69C424" title="'.$keyword.'">' . Core_Map::truncate ($keyword,15) . '<span>"';
        } else {
            if (!empty($area_id)) {
                $data = Model_Masterdata::getInstance()->getAreaById($area_id);
                if ($data)
                    echo ' ở khu vực <span style="color:#69C424" title="'.$data["area_translated"].'">' . Core_Map::truncate ($data["area_translated"],30).'</span>';
            }else if (!empty($city_id)) {
                $data = Model_Masterdata::getInstance()->getCityById($city_id);
                if ($data)
                    echo ' ở <span style="color:#69C424" title= "'.$data["city_translated"].'">' . Core_Map::truncate ($data["city_translated"],35).'</span>';
            }else if (!empty($country_id)) {
                $data = Model_Masterdata::getInstance()->getCountryById($country_id);
                if ($data)
                    echo ' ở nước <span style="color:#69C424" title= "'.$data["country_translated"].'">' . Core_Map::truncate ($data["country_translated"],30).'</span>';
            }
        }
        ?>
        <form class="form-inline" style="float:right; width:auto;margin-top:-5px;">
            <label class="checkbox">
                Sắp xếp
            </label>
            <?php $this->widget('Widget_Search_Sort'); ?>
        </form>

    </h5>

    <?php if ($itemCount > 0) { ?>  	      
        <?php
        foreach ($this->dataProvider->getData() as $index => $item) {
            /* if(!empty($item['product_id'])){
              $base = Model_Product::getInstance()->base($item['product_id']);
              if(!empty($base)){
              $item = Core_Map::mergeArray($item, $base);
              }
              } */
            ?>                 
            <?php foreach ($this->columns as $column) { ?>              	
                <?php $column->renderDataCell($index, $item, $itemCount); ?>
            <?php } ?>          
        <?php } ?>                   	
<?php } ?>

    <div class="pagination" style="float:right; margin-top:0px">
<?php $this->renderPager(); ?>
    </div>

</div>