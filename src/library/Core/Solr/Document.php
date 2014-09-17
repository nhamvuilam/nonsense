<?php
class Core_Solr_Document {
    /** Tag prefixes which are saved to Solr  **/
    const TAG_PREFIX_BOOK_AUTHOR = 0;
    const TAG_PREFIX_BOOK_PUBLISHER = 1;
    const TAG_PREFIX_BOOK_TRANSLATOR = 2;
    const TAG_PREFIX_CATEGORY = 2;

    public static $BREADCRUMBS_SEPARATOR = '@';

    public static $TAG_PREFIX = array(
            self::TAG_PREFIX_BOOK_AUTHOR => '__author__@',
            self::TAG_PREFIX_BOOK_PUBLISHER => '__publisher__@',
            self::TAG_PREFIX_BOOK_TRANSLATOR => '__translator__@',
            self::TAG_PREFIX_CATEGORY => '__category__@',
    );


    /**
     * Return a tag value if it match a prefix
     * @param string $prefix The prefix to match
     * @param array $tags The array of tag to search
     * @return string
     */
    public static function getTagValByPrefix($prefix, array $tags) {
        foreach ($tags as $tag) {
            $result = preg_replace("/^{$prefix}/", "", $tag);
            if (strlen($result) < strlen($tag)) {
                return $result;
            }
        }
        return null;
    }

    /**
     * Return category object (id, name) of an Apache_Solr_Document
     * @param Apache_Solr_Document $doc
     * @param number $level Default is 0. The level of category to get. OPTIONAL
     * If level is greater than the depth of category tree, then 0 will be used
     * @return stdClass
     */
    public static function getCategoryByLevel(Apache_Solr_Document $doc, $level = 0) {
        $category = new stdClass();
        $breadcrumbs = self::getBreadcrumbsArray($doc);

        if ((int) $level > count($breadcrumbs[0])) {
            $level = 0;
        }

        $category->id = $breadcrumbs[0][(int) $level];
        $category->name = $breadcrumbs[1][(int) $level];
        return $category;
    }

    /**
     * Return direct category of an Apache_Solr_Document
     * @param Apache_Solr_Document $doc
     * @return stdClass
     */
    public static function getDirectCategory(Apache_Solr_Document $doc) {
        $category = new stdClass();
        $breadcrumbs = self::getBreadcrumbsArray($doc);

        $breadcrumbsDepth = count($breadcrumbs[0]);

        $category->id = $breadcrumbs[0][(int) $breadcrumbsDepth - 1];
        $category->name = $breadcrumbs[1][(int) $breadcrumbsDepth - 1];
        return $category;
    }

    /**
     * Get root category of an Apache_Solr_Document
     * @param Apache_Solr_Document $doc
     * @return stdClass
     */
    public static function getRootCategory(Apache_Solr_Document $doc) {
        return self::getCategoryByLevel($doc);
    }

    /**
     * Return category id and category name array of an Apache_Solr_Document.
     *
     * Each array is an array which holds the whole category hierachy. The
     * very first element is the root category and the last element is the
     * category which contains the product directly
     *
     * @param Apache_Solr_Document $doc
     * @return array
     */
    public static function getBreadcrumbsArray(Apache_Solr_Document $doc) {
        $breadcrumbs = explode(self::$BREADCRUMBS_SEPARATOR, $doc->breadcrumbs);
        $breadcrumbsId = explode(self::$BREADCRUMBS_SEPARATOR, $doc->breadcrumbs_id);
        return array($breadcrumbsId, $breadcrumbs);
    }

}