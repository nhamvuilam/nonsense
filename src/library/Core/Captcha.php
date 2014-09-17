<?php
error_reporting(E_ALL & ~E_NOTICE);
header ("Content-type: image/png");
class Core_Captcha{    
	private $sImage = '';
	private $fontsize = '11';
	private $width;
	private $height;
	private $colorText;
	private $colorBg;
	private $font = '';
	private $rec = 1;
	private $trans = 1 ;
	private $oImgSession ;
    function Core_Captcha($width=85,$height=19,$colorText = '#000000',$colorBg = '#ffffff'){		
		$this->sImage =	$this->FetchRegistrationString(6);
		$this->colorText = $colorText;
		$this->colorBg = $colorBg;
		$this->width = $width;
		$this->height = $height;
		$this->font		= "font/font.ttf";	
    }    
	function FetchRegistrationString($nLength=6)
	{
		$sChars = 'ABCDEFGHJKLMNPRTWXYZ';
		for ($i = 1; $i <= $nLength; $i++){
			$nNumber = rand(1, strlen($sChars));
			$sWord .= substr($sChars, $nNumber - 1, 1);
	 	}
	 	return $sWord;
	}
	function setImage($text='abc123'){
		$this->sImage =	$text;
	}
	function show_image($text=''){		
		$val = $this->colorBg;
		$red = hexdec(substr($val, 1 , 2));
		$green = hexdec(substr($val, 3 , 2));
		$blue = hexdec(substr($val, 5 , 2));		
		// Mau text
		$val_txt = $this->colorText;
		$red_txt = hexdec(substr($val_txt, 1 , 2));
		$green_txt = hexdec(substr($val_txt, 3 , 2));
		$blue_txt = hexdec(substr($val_txt, 5 , 2));		
		/// Kiem tra neu la background color
		if (substr($this->colorBg,0,1)=='#')
			$im    = imagecreate($this->width,$this->height);
		else
			$im    = imagecreatetruecolor($this->width,$this->height);				
		$white = imagecolorallocate($im, $red,$green,$blue);		
		$black = imagecolorallocate($im, $red_txt,$green_txt,$blue_txt);
		
		if ($this->trans)
			imagecolortransparent($im,$white);
		/// Tao backgound image		
		if (substr($this->colorBg,0,1)!='#'){		
			$bg =   $this->colorBg;			
			$imgbg_ext = strtolower(substr($bg,-3));			
			switch($imgbg_ext){
				case "jpg" : $imbg = imagecreatefromjpeg("$bg");  break;
				case "epg" : $imbg = imagecreatefromjpeg("$bg");  break;
				case "gif" : $imbg = imagecreatefromgif("$bg");  break;
				case "png" : $imbg = imagecreatefrompng("$bg");  break;
			}			
			list($w_bg,$h_bg) = getimagesize($bg);
			
			imagecolortransparent($im,$imbg);
			imagecopy($im,$imbg,0,0,0,0,$w_bg,$h_bg);		
		}
		/// Show binh thuong
		if (!$this->rec)			
			imagettftext($im, $this->fontsize, 0, 0, 16, $black,$this->font,$this->sImage);
		/// Dance text		
		else{		
			settype($this->sImage,"STRING");
			for ($ic =0; $ic <strlen($this->sImage);$ic++){			  
			  imagefttext($im,$this->fontsize,rand(-45,45),(($this->width /strlen($this->sImage)) * ($ic))+ 5, 
			  				$this->height - (($this->height - $this->fontsize) / 2), $black,$this->font,$this->sImage{$ic},array());
			}		
		}
		imagepng($im);
		imagedestroy($im);
	}
}
?>