<?php
class Core_DataList_Pagination
{
	/**
	 * The default page size.
	 */
	const DEFAULT_PAGE_SIZE=10;
	public $pageSize=self::DEFAULT_PAGE_SIZE;
	public $itemCount=0;
	public $currentPage;

	/**
	 * Constructor.
	 * @param integer $itemCount total number of items.
	 * @since 1.0.1
	 */
	public function __construct($itemCount=0)
	{
		$this->setItemCount($itemCount);
	}

	/**
	 * @return integer number of items in each page. Defaults to 10.
	 */
	public function getPageSize()
	{
		return $this->pageSize;
	}

	/**
	 * @param integer $value number of items in each page
	 */
	public function setPageSize($value)
	{
		if(($this->pageSize=$value)<=0)
			$this->pageSize=self::DEFAULT_PAGE_SIZE;
	}

	/**
	 * @return integer total number of items. Defaults to 0.
	 */
	public function getItemCount()
	{
		return $this->itemCount;
	}

	/**
	 * @param integer $value total number of items.
	 */
	public function setItemCount($value)
	{
		if(($this->itemCount=$value)<0)
			$this->itemCount=0;
	}

	/**
	 * @return integer number of pages
	 */
	public function getPageCount()
	{
		if($this->pageSize == 0) return 0; 
		return (int) ($this->itemCount/$this->pageSize) + 1;
	}

	/**
	 * @param boolean $recalculate whether to recalculate the current page based on the page size and item count.
	 * @return integer the zero-based index of the current page. Defaults to 0.
	 */
	public function getCurrentPage()
	{		
		return empty($this->currentPage)?1:$this->currentPage;
	}

	/**
	 * @param integer $value the zero-based index of the current page.
	 */
	public function setCurrentPage($value)
	{
		$this->currentPage=$value;
	}
	
	/**
	 * @return integer the offset of the data. This may be used to set the
	 * OFFSET value for a SQL statement for fetching the current page of data.
	 * @since 1.1.0
	 */
	public function getOffset()
	{
		return $this->getCurrentPage()*$this->getPageSize();
	}

	/**
	 * @return integer the limit of the data. This may be used to set the
	 * LIMIT value for a SQL statement for fetching the current page of data.
	 * This returns the same value as {@link pageSize}.
	 * @since 1.1.0
	 */
	public function getLimit()
	{
		return $this->getPageSize();
	}	
}