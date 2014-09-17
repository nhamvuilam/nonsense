<?php
class Core_DataList_Html
{	
	public static function encode($text)
	{
		return htmlspecialchars($text,ENT_QUOTES);
	}

	/**
	 * Decodes special HTML entities back to the corresponding characters.
	 * This is the opposite of {@link encode()}.
	 * @param string $text data to be decoded
	 * @return string the decoded data
	 * @see http://www.php.net/manual/en/function.htmlspecialchars-decode.php
	 * @since 1.1.8
	 */
	public static function decode($text)
	{
		return htmlspecialchars_decode($text,ENT_QUOTES);
	}

	/**
	 * Encodes special characters in an array of strings into HTML entities.
	 * Both the array keys and values will be encoded if needed.
	 * If a value is an array, this method will also encode it recursively.
	 * The {@link CApplication::charset application charset} will be used for encoding.
	 * @param array $data data to be encoded
	 * @return array the encoded data
	 * @see http://www.php.net/manual/en/function.htmlspecialchars.php
	 * @since 1.0.4
	 */
	public static function encodeArray($data)
	{
		$d=array();
		foreach($data as $key=>$value)
		{
			if(is_string($key))
				$key=htmlspecialchars($key,ENT_QUOTES,Yii::app()->charset);
			if(is_string($value))
				$value=htmlspecialchars($value,ENT_QUOTES,Yii::app()->charset);
			else if(is_array($value))
				$value=self::encodeArray($value);
			$d[$key]=$value;
		}
		return $d;
	}

	/**
	 * Generates an HTML element.
	 * @param string $tag the tag name
	 * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
	 * Since version 1.0.5, if an 'encode' attribute is given and its value is false,
	 * the rest of the attribute values will NOT be HTML-encoded.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * @param mixed $content the content to be enclosed between open and close element tags. It will not be HTML-encoded.
	 * If false, it means there is no body content.
	 * @param boolean $closeTag whether to generate the close tag.
	 * @return string the generated HTML element tag
	 */
	public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true)
	{
		$html='<' . $tag . self::renderAttributes($htmlOptions);
		if($content===false)
			return $closeTag ? $html.' />' : $html.'>';
		else
			return $closeTag ? $html.'>'.$content.'</'.$tag.'>' : $html.'>'.$content;
	}

	/**
	 * Generates an open HTML element.
	 * @param string $tag the tag name
	 * @param array $htmlOptions the element attributes. The values will be HTML-encoded using {@link encode()}.
	 * Since version 1.0.5, if an 'encode' attribute is given and its value is false,
	 * the rest of the attribute values will NOT be HTML-encoded.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * @return string the generated HTML element tag
	 */
	public static function openTag($tag,$htmlOptions=array())
	{
		return '<' . $tag . self::renderAttributes($htmlOptions) . '>';
	}

	/**
	 * Generates a close HTML element.
	 * @param string $tag the tag name
	 * @return string the generated HTML element tag
	 */
	public static function closeTag($tag)
	{
		return '</'.$tag.'>';
	}

	/**
	 * Encloses the given string within a CDATA tag.
	 * @param string $text the string to be enclosed
	 * @return string the CDATA tag with the enclosed content.
	 */
	public static function cdata($text)
	{
		return '<![CDATA[' . $text . ']]>';
	}
	
	public static function getIdByName($name)
	{
		return str_replace(array('[]', '][', '[', ']'), array('', '_', '_', ''), $name);
	}
	
	public static function link($text,$url='#',$htmlOptions=array())
	{
		if($url!=='')
			$htmlOptions['href']=$url;
		
		return self::tag('a',$htmlOptions,$text);
	}
	
	
	
	public static function image($src,$alt='',$htmlOptions=array())
	{
		$htmlOptions['src']=$src;
		$htmlOptions['alt']=$alt;
		return self::tag('img',$htmlOptions);
	}
	
	public static function checkBox($name,$checked=false,$htmlOptions=array())
	{
		if($checked)
			$htmlOptions['checked']='checked';
		else
			unset($htmlOptions['checked']);
			
		$value=isset($htmlOptions['value']) ? $htmlOptions['value'] : 1;

		
		// add a hidden field so that if the checkbox  is not selected, it still submits a value
		return self::inputField('checkbox',$name,$value,$htmlOptions);
	}
	
	public static function radio($name,$checked=false,$htmlOptions=array())
	{
		if($checked)
			$htmlOptions['checked']='checked';
		else
			unset($htmlOptions['checked']);
			
		$value=isset($htmlOptions['value']) ? $htmlOptions['value'] : 1;

		
		// add a hidden field so that if the checkbox  is not selected, it still submits a value
		return self::inputField('radio',$name,$value,$htmlOptions);
	}
	
	public static function inputField($type,$name,$value,$htmlOptions)
	{
		$htmlOptions['type']=$type;
		$htmlOptions['value']=$value;
		$htmlOptions['name']=$name;
		if(!isset($htmlOptions['id']))
			$htmlOptions['id']=self::getIdByName($name);
		else if($htmlOptions['id']===false)
			unset($htmlOptions['id']);
		return self::tag('input',$htmlOptions);
	}
	
	
	
	/**
	 * Renders the HTML tag attributes.
	 * Since version 1.1.5, attributes whose value is null will not be rendered.
	 * Special attributes, such as 'checked', 'disabled', 'readonly', will be rendered
	 * properly based on their corresponding boolean value.
	 * @param array $htmlOptions attributes to be rendered
	 * @return string the rendering result
	 * @since 1.0.5
	 */
	public static function renderAttributes($htmlOptions)
	{
		static $specialAttributes=array(
			'checked'=>1,
			'declare'=>1,
			'defer'=>1,
			'disabled'=>1,
			'ismap'=>1,
			'multiple'=>1,
			'nohref'=>1,
			'noresize'=>1,
			'readonly'=>1,
			'selected'=>1,
		);

		if($htmlOptions===array())
			return '';

		$html='';
		if(isset($htmlOptions['encode']))
		{
			$raw=!$htmlOptions['encode'];
			unset($htmlOptions['encode']);
		}
		else
			$raw=false;

		if($raw)
		{
			foreach($htmlOptions as $name=>$value)
			{
				if(isset($specialAttributes[$name]))
				{
					if($value)
						$html .= ' ' . $name . '="' . $name . '"';
				}
				else if($value!==null)
					$html .= ' ' . $name . '="' . $value . '"';
			}
		}
		else
		{
			foreach($htmlOptions as $name=>$value)
			{
				if(isset($specialAttributes[$name]))
				{
					if($value)
						$html .= ' ' . $name . '="' . $name . '"';
				}
				else if($value!==null)
					$html .= ' ' . $name . '="' . self::encode($value) . '"';
			}
		}
		return $html;
	}
	
	public static function listData($models,$valueField,$textField,$groupField='')
	{
		$listData=array();
		if($groupField==='')
		{
			foreach($models as $model)
			{
				$value=self::value($model,$valueField);
				$text=self::value($model,$textField);
				$listData[$value]=$text;
			}
		}
		else
		{
			foreach($models as $model)
			{
				$group=self::value($model,$groupField);
				$value=self::value($model,$valueField);
				$text=self::value($model,$textField);
				$listData[$group][$value]=$text;
			}
		}
		return $listData;
	}
	
	public static function value($model,$attribute,$defaultValue=null)
	{
		foreach(explode('.',$attribute) as $name)
		{
			if(is_object($model))
				$model=$model->$name;
			else if(is_array($model) && isset($model[$name]))
				$model=$model[$name];
			else
				return $defaultValue;
		}
		return $model;
	}
}
?>