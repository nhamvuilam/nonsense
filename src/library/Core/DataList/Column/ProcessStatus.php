<?php
class Core_DataList_Column_ProcessStatus extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
        
        public $status;

        public function init(){
		parent::init();
	}

	public function renderDataCellContent($row, $data){
            $status = $data[$this->status];
            if($status == -2) {
                echo '<font color="red">Pause</font>';
            } else if(in_array($status, array(-1,1))) {
                echo '<font color="red">'.$data[$this->name].'</font>';
            } else if(in_array($status, array(2))) { //approved
                $rightPercent = round($data['remain_user'] / $data['total_account'], 2)  * 100;
                $leftPercent = 100 - $rightPercent;
                $rightNum = $data['remain_user'];
                $leftNum = $data['total_account'] - $rightNum;
                echo '<div class="bar" data-toggle="tooltip" title="Đã cộng Plus thành công cho '.number_format($leftNum).'/'.number_format($data['total_account']).' tài khoản"><div class="left" style="width: '.$leftPercent.'%; background-color: greenyellow; ">'.number_format($leftNum).'</div><div class="right" style="width: '.$rightPercent.'%; "></div></div>';
            } else if(in_array($status, array(3))) { //done
                echo '<span style="color: green; font-weight: bold;">'.$data[$this->name].'<br>'.$data['time_done'].'</span>';
            } else {
                echo $data[$this->name];
            }
	}
}
