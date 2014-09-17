<?php

/**
 * Solr search component which provide API to interacting with the Solr Server.
 * This class utilizes the SolrPhpClient package for Solr manipulation
 *
 * @version 1.0
 *
 * @link Core_Global
 * @link Apache_Solr_Service
 */
class Core_Solr_SearchHandler implements Core_Search {

    /**
     * Solr instance
     * @var Core_Solr
     */
    protected $solr;

    /**
     * Query string
     * @var string
     */
    protected $query;

    /**
     * Query Filters
     * @var array
     */
    protected $filters = array();

    /**
     * Sort type
     * @var number
     */
    protected $sortCondition = self::SORT_DEFAULT;

    /**
     * Number of rows to return in one page
     * @var number
     */
    protected $rowsPerPage = 10;

    /**
     * Page number to return
     * @var int
     */
    protected $page = 1;

    /**
     * Total number of found products
     * @var number
     */
    protected $resultCount = 0;

    /**
     * Found products
     * @var array
     */
    protected $foundProducts = array();

    /**
     * Found facets
     * @var array
     */
    protected $foundFacets = array();

    /*
     * DataFilter */
    protected $dataFilter = array();
    protected $dataFilterPatern = array();

    /**
     * Mapping between application sort condition and solr sorting query
     * @var array
     */
    protected $sortDefinition = array(
        self::SORT_DEFAULT => '',
        self::SORT_STAR_RATING_ASC => 'hotels_star_rating asc, hotels_rates_from asc',
        self::SORT_STAR_RATING_DESC => 'hotels_star_rating desc, hotels_rates_from desc',
        self::SORT_PRICE_ASC => 'hotels_rates_from asc, hotels_star_rating asc',
        self::SORT_PRICE_DESC => 'hotels_rates_from desc, hotels_star_rating desc',
    );
    protected $conditionDefault = CURRENCYSOLR;

    /**
     * Constructors.
     */
    public function __construct() {
        list($dataFilterTranslated, $dataFilterPatern) = include APPLICATION_PATH . '/configs/translated_filter_data.php';
        $this->dataFilterPatern = $dataFilterPatern;
    }

    /**
     * Search documents
     *
     * @throws Apache_Solr_HttpTransportException If an error occurs during the service call
     * @throws Apache_Solr_InvalidArgumentException If an invalid HTTP method is used
     */
    public function search() {

        // ensure server is up
        if (!$this->solr->isAlive()) {
            throw new Exception('Server is down');
        }

        $params = array();
        $params['fq'] = '';
        if ($this->conditionDefault) {
            $params['fq'] = '(hotels_rates_currency:' . $this->conditionDefault . ')';
        }

        // build sort parameter
        if ($this->sortCondition != self::SORT_DEFAULT) {
            $params['sort'] = $this->sortDefinition[(int) $this->sortCondition];
        }
        //FILTER
        if ($this->filters) {
            foreach ($this->filters as $name => $value) {
                $params['fq'] .= $params['fq'] != "" ? " AND ({$value})" : "({$value})";
            }
        }
        //Facet for filter-data
        $params['facet'] = 'on';
        $params['facet.field'] = $this->dataFilterPatern;   
        Core_Map::debug($params);
        // perform search
        $response = $this->solr->getSolrService()->search($this->query, ((int) $this->page - 1) * (int) $this->rowsPerPage, $this->rowsPerPage, $params, 'GET');

        /* echo '<pre>';
          print_r(Zend_Json::decode($response->getRawResponse()));
          exit; */
        //$this->parseResults(Zend_Json::decode($response->getRawResponse()));
        $this->parseResults($response);
    }

    /**
     * Set Solr instance
     * @see Core_Search::setSolr()
     */
    public function setSolr(Core_Solr $solr) {
        $this->solr = $solr;
    }

    /**
     * Set query string
     * @see Core_Search::setQuery()
     */
    public function setQuery($query) {
        if (empty($query))
            $query = '*';
        $this->query = $query;
    }

    /**
     * Set page number to return
     * @see Core_Search::setPage()
     */
    public function setPage($page) {
        if (!empty($page)) {
            $this->page = (int) $page;
        }
    }

    /**
     * Set number of products per page
     * @see Core_Search::setRowsPerPage()
     */
    public function setRowsPerPage($row) {
        if (!empty($row)) {
            $this->rowsPerPage = (int) $row;
        }
    }

    /**
     * Limit search results to a range of facilities
     * @param array $facility
     */
    public function setFacilityFilter($facility) {
        if (isset($facility[0]) && !empty($facility[0])) {
            $exp = explode(',', $facility[0]);
            $cond = '';
            foreach ($exp as $row) {
                $cond .= ($cond != '' ? " OR {$row}:1" : "{$row}:1");
            }
            $this->filters['facility'] = $cond;
        }
    }

    /**
     * Limit search results to a range of facilities
     * @param array $facility
     */
    public function setStarRatingFilter($star_rating) {

        if (isset($star_rating[0]) && !empty($star_rating[0])) {
            $exp = explode(',', $star_rating[0]);
            $cond = '';
            $title = 'hotels_star_rating';
            foreach ($exp as $row) {
                if ($row != -1)
                    $cond .= ($cond != '' ? " OR {$title}:[{$row} TO " . ($row + 0.5) . "]" : "{$title}:[{$row} TO " . ($row + 0.5) . "]");
                else if ($row == -1)
                    $cond .= ($cond != '' ? " OR {$title}:0" : "{$title}:0");
            }
            $this->filters['star_rating'] = $cond;
        }
    }

    /**
     * Limit search results to a range of price
     * @param array $price(from-to)
     */ 
    public function setPriceFilter($price) {
        if ($price) {
            $exp = explode('-', $price);
            if (isset($exp[1]) && isset($exp[0]) && preg_match('/^\d+$/', $exp[1]) && preg_match('/^\d+$/', $exp[0])) {
                $exp[0] = (int) $exp[0] / (int) Model_Currency::getInstance()->getCurrencyRate();
                $exp[1] = (int) $exp[1] / (int) Model_Currency::getInstance()->getCurrencyRate();
                $cond = "hotels_rates_from:[{$exp[0]} TO {$exp[1]}]";
                $this->filters['hotels_rates_from'] = $cond;
            }
        }        
        /*
         * Set filter for getting hotels which has hotels_rates_from > 0
         */
        else{
            $this->filters['hotels_rates_from'] = 'hotels_rates_from:[1 TO *]';
        }
    }

    /**
     * Sort results using a sort id
     * @param number $sortId
     */
    public function setSortType($sortId) {
        if (is_array($sortId))
            $sortId = $sortId[0];
        if ($sortId && in_array($sortId, array_keys($this->sortDefinition))) {
            $this->sortCondition = (int) $sortId;
        }
    }

    /**
     * Add query with countries_country_id
     * @param number $country_id
     */
    public function setCountry($country_id) {
        if ($country_id) {
            $this->query .= ' AND countries_country_id:' . $country_id;
        }
    }

    /**
     * Add query with cities_city_id
     * @param number $city_id
     */
    public function setCity($city_id) {
        if ($city_id) {
            $this->query .= ' AND cities_city_id:' . $city_id;
        }
    }

    /**
     * Add query with cities_city_id
     * @param number $city_id
     */
    public function setArea($area_id) {
        if ($area_id) {
            $this->query .= ' AND hotels_area_id:' . $area_id;
        }
    }

    /**
     * Return total number of found products
     * @see Core_Search::getNumFound()
     */
    public function getNumFound() {
        return $this->resultCount;
    }

    /**
     * Return found products
     * @see Core_Search::getProducts()
     */
    public function getProducts() {
        return $this->foundProducts;
    }

    /**
     * Return found facilities filters
     * @see Core_Search::getFacilitiesFilter()
     */
    public function getFacilitiesFilter() {
        return $this->foundFacets['facility'];
    }

    /**
     * Return found brand filters
     * @see Core_Search::getStarRatingFilters()
     */
    public function getStarRatingFilters() {
        return $this->foundFacets['star_rating'];
    }

    /**
     * Return found price filters
     * @return array
     */
    public function getPriceFilters() {
        return $this->foundFacets['prices'];
    }

    /**
     * Return array of available facet of the search result
     * @param Apache_Solr_Response $response
     * @return array
     */
    /* protected function getFacet(Apache_Solr_Response $response) {
      return array(
      //'categories' => $this->getCategoryFacet($response),
      //'brands' => $this->getBrandFacet($response),
      //'tags' => $this->getTagFacet($response),
      // 'prices' => $this->getPriceFacet($response),
      'facility'=>$this->getFacilitiesFacet($response),
      'star_rating'=>$this->getStarRatingFacet($response),
      );
      } */

    /**
     * Return facilities facet
     * @param Apache_Solr_Response $response
     * @return array
     */
    protected function getFacilitiesFacet(Apache_Solr_Response $response) {
        $facilities = array();
        foreach ($response->facet_counts->facet_fields as $name => $count) {
            if ($name != 'hotels_star_rating') {
                if ($count->{1} > 0) {
                    $facilities[$name] = array('name' => $name,
                        'count' => $count->{1},
                    );
                }
                /* $brandParts = $this->getBrandParts($name);
                  $brands[(string) $brandParts[0]] = array(
                  'name' => $brandParts[1],
                  'count' => $count,
                  ); */
            }
        }
        return $facilities;
    }

    /**
     * Return star rating facet
     * @param Apache_Solr_Response $response
     * @return array
     */
    protected function getStarRatingFacet(Apache_Solr_Response $response) {
        $star_rating = array();
        foreach ($response->facet_counts->facet_fields as $name => $count) {
            if ($name == 'hotels_star_rating') {
                foreach ($count as $k => $v) {
                    //if(is_integer($k)){
                    $k = floor($k);
                    if ($k > 0) {
                        if (isset($star_rating[$k])) {
                            $star_rating[$k]['count'] += $v;
                        } else {
                            $star_rating[$k] = array('name' => $k,
                                'count' => $v,
                            );
                        }
                    }
                    if ($k == 0)
                        $star_rating[$k] = array('name' => -1,
                            'count' => $v,
                        );
                    //}							
                }
            }
        }

        $res_array = array();
        foreach ($star_rating as $key => $val) {
            $res_array[] = $key;
        }
        ksort($star_rating);
        return $star_rating;
    }

    /**
     * Return brand facet
     * @param Apache_Solr_Response $response
     * @return array
     */
    /* protected function getBrandFacet(Apache_Solr_Response $response) {
      // retrieve brand facet name using category id
      $brands = array();
      foreach ($response->facet_counts->facet_fields->brand_composite as $name => $count) {
      $brandParts = $this->getBrandParts($name);
      $brands[(string) $brandParts[0]] = array(
      'name' => $brandParts[1],
      'count' => $count,
      );
      }
      return $brands;
      } */

    /**
     * Prepare solr searching params
     * @param array $params The default array of search params passing to Solr
     * @return array The final array of search params
     */
    protected function prepareSearchParams($params) {
        return $params;
    }

    /**
     * Setting up search result
     * @return void
     */
    protected function parseResults($response) {
        $this->resultCount = $response->response->numFound;
        $this->foundProducts = $response->response->docs;
        //$this->foundFacets = $this->getFacet($response);
        $this->searchFacilityFilter();
        $this->searchStarRatingFilter();
    }

    protected function searchFacilityFilter() {
        if (!$this->solr->isAlive()) {
            throw new Exception('Server is down');
        }
        $params = array();
        $params['fq'] = '';
        if ($this->filters) {            
            $require_search = array('facility', 'hotels_rates_from');
            foreach ($require_search as $row) {
                if (isset($this->filters[$row])) {
                    $params['fq'] .=!empty($params['fq']) ? " AND ({$this->filters[$row]})" : "({$this->filters[$row]})";
                }
            }
            
        }
        //Facet for filter-data
        $params['facet'] = 'on';
        $params['facet.field'] = $this->dataFilterPatern;
        $response = $this->solr->getSolrService()->search($this->query, ((int) $this->page - 1) * (int) $this->rowsPerPage, $this->rowsPerPage, $params, 'GET');

        $this->foundFacets['star_rating'] = $this->getStarRatingFacet($response);
    }

    protected function searchStarRatingFilter() {
        if (!$this->solr->isAlive()) {
            throw new Exception('Server is down');
        }
        $params = array();
        $params['fq'] = '';
        if ($this->filters) {
            $require_search = array('star_rating', 'hotels_rates_from');
            foreach ($require_search as $row) {
                if (isset($this->filters[$row])) {
                    $params['fq'] .=!empty($params['fq']) ? " AND ({$this->filters[$row]})" : "({$this->filters[$row]})";
                }
            }
        }
        //Facet for filter-data
        $params['facet'] = 'on';
        $params['facet.field'] = $this->dataFilterPatern;
        $response = $this->solr->getSolrService()->search($this->query, ((int) $this->page - 1) * (int) $this->rowsPerPage, $this->rowsPerPage, $params, 'GET');

        $this->foundFacets['facility'] = $this->getFacilitiesFacet($response);
    }
}