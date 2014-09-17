<table id="expandable" cellspacing="0" cellpadding="0" border="0">    
  <?php if($this->dataProvider->getItemCount()>0){?>
  <tbody>
  	<tr data-tt-id="774">
    	<td>Gia dụng</td>    	      
    </tr>  	
    <?php foreach($this->dataProvider->getData() as $index=>$item){?>
    <tr data-tt-id="<?php echo $item['category_id']?>" data-tt-parent-id="<?php echo $item['p_category_id']?>">
    	<td><?php echo $item['category_name']?></td>    	      
    </tr>
    <?php }?>
  </tbody>
  <?php }else{?>
  <tr>
    <td colspan="<?php echo count($this->columns);?>"><?php echo $this->getEmptyText() ?></td>
  </tr>
  <?php }?>
</table>