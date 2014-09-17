<?php
interface Core_Search {

    /**
     * Sort by revalance
     * @var number
     */
    const SORT_DEFAULT = 0;

    /**
     * Sort result ascending by price
     * @var number
     */
    const SORT_PRICE_ASC = 6;//

    /**
     * Sort results descending by price
     * @var number
     */
    const SORT_PRICE_DESC = 7;//

    /**
     * Sort by star rating
     * @var number
     */
    const SORT_STAR_RATING_ASC = 4;//

    /**
     * Sort by star rating
     * @var number
     */
    const SORT_STAR_RATING_DESC = 3;//


    public function setSolr(Core_Solr $solr);

    public function setQuery($query);
    public function setPage($page);
    public function setRowsPerPage($row);
    //public function setCategoryFilter($categoryId);
    //public function setBrandFilter($brandId);
    //public function setPriceFilter($price);
    public function setFacilityFilter($sortType);
    public function setSortType($sortType);	

    public function getNumFound();
    public function getProducts();
    public function getFacilitiesFilter();
	public function getStarRatingFilters();
    // public function getBrandFilters();   	
    // public function getSuggestedTags();
    // public function getPriceFilters();
	
	//public function setDataFilter();

    public function search();
}
