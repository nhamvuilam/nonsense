<?php
abstract class Core_DataList_Pagination_Abstract
{	
	public $pages;

	/**
	 * Returns the pagination information used by this pager.
	 * @return CPagination the pagination information
	 */
	public function getPages()
	{
		if($this->pages===null)
			$this->pages=$this->createPages();
		return $this->pages;
	}

	/**
	 * Sets the pagination information used by this pager.
	 * @param CPagination $pages the pagination information
	 */
	public function setPages($pages)
	{
		$this->pages=$pages;
	}

	/**
	 * Creates the default pagination.
	 * This is called by {@link getPages} when the pagination is not set before.
	 * @return CPagination the default pagination instance.
	 */
	protected function createPages()
	{
		return new Core_Pagination;
	}

	/**
	 * @return integer number of items in each page.
	 * @see CPagination::getPageSize
	 */
	public function getPageSize()
	{
		return $this->getPages()->getPageSize();
	}

	/**
	 * @param integer $value number of items in each page
	 * @see CPagination::setPageSize
	 */
	public function setPageSize($value)
	{
		$this->getPages()->setPageSize($value);
	}

	/**
	 * @return integer total number of items.
	 * @see CPagination::getItemCount
	 */
	public function getItemCount()
	{
		return $this->getPages()->getItemCount();
	}

	/**
	 * @param integer $value total number of items.
	 * @see CPagination::setItemCount
	 */
	public function setItemCount($value)
	{
		$this->getPages()->setItemCount($value);
	}

	/**
	 * @return integer number of pages
	 * @see CPagination::getPageCount
	 */
	public function getPageCount()
	{
		return $this->getPages()->getPageCount();
	}

	/**
	 * @param boolean $recalculate whether to recalculate the current page based on the page size and item count.
	 * @return integer the zero-based index of the current page. Defaults to 0.
	 * @see CPagination::getCurrentPage
	 */
	public function getCurrentPage()
	{
		return $this->getPages()->getCurrentPage();
	}

	/**
	 * @param integer $value the zero-based index of the current page.
	 * @see CPagination::setCurrentPage
	 */
	public function setCurrentPage($value)
	{
		$this->getPages()->setCurrentPage($value);
	}
}