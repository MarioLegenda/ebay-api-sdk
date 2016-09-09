<?php

namespace FindingAPI;

use FindingAPI\Definition\SearchDefinitionInterface;
use FindingAPI\Core\Request;

class FinderSearch
{
    /**
     * @var Request $configuration
     */
    private $request;
    /**
     * @var FinderSearch $instance
     */
    private static $instance;
    /**
     * @param Request|null $configuration
     * @return FinderSearch
     */
    public static function getInstance(Request $request) : FinderSearch
    {
        self::$instance = (self::$instance instanceof self) ? self::$instance : new FinderSearch($request);

        return self::$instance;
    }
    /**
     * FinderSearch constructor.
     * @param Request $configuration
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @param SearchDefinitionInterface $definition
     * @return $this
     */
    public function search(SearchDefinitionInterface $definition)
    {
        
        return $this;
    }
}