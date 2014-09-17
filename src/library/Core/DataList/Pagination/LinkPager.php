<?php
class Core_DataList_Pagination_LinkPager extends Core_DataList_Pagination_Abstract
{
	const CSS_FIRST_PAGE='first';
	const CSS_LAST_PAGE='last';
	const CSS_PREVIOUS_PAGE='previous';
	const CSS_NEXT_PAGE='next';
	const CSS_INTERNAL_PAGE='page';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='active';

	/**
	 * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
	 */
	public $maxButtonCount=10;
	/**
	 * @var string the text label for the next page button. Defaults to 'Next &gt;'.
	 */
	public $nextPageLabel;
	/**
	 * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
	 */
	public $prevPageLabel;
	/**
	 * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
	 */
	public $firstPageLabel;
	/**
	 * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
	 */
	public $lastPageLabel;
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
	
	public $cssPager = 'pager';

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel='Next &gt;';
		if($this->prevPageLabel===null)
			$this->prevPageLabel='&lt; Previous';
		if($this->firstPageLabel===null)
			$this->firstPageLabel='&lt;&lt; First';
		if($this->lastPageLabel===null)
			$this->lastPageLabel='Last &gt;&gt;';
		if($this->header===null)
			$this->header='Go to page: ';
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo '<ul class="'.$this->cssPager.'">';
		echo implode("\n",$buttons);
		echo '</ul>';
		echo $this->footer;
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage();
		$buttons=array();
		
		// first page
		$buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=1,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=1;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=1,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount)
			$page=$pageCount;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount,false);

		// last page
		$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount,self::CSS_LAST_PAGE,$currentPage>=$pageCount,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		$page = max(1, $page);
		
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		
		$liOptions = array();
		$liOptions['val'] = $page;
		$liOptions['class'] = $class;
		
		return Core_DataList_Html::tag('li', $liOptions, '<a href="javascript:void(0);">'.$label.'</a>');
	}

	/**
	 * @return array the begin and end pages that need to be displayed.
	 */
	protected function getPageRange()
	{
		$currentPage=$this->getCurrentPage();
		$pageCount=$this->getPageCount();
		
		$beginPage=max(1, $currentPage-(int)($this->maxButtonCount/2));
		if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
		{
			$endPage=$pageCount;
			$beginPage=max(1, $endPage-$this->maxButtonCount+1);
		}
		return array($beginPage, $endPage);
	}
}
