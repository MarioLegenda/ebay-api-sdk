<?php

namespace FindingAPI\Core\Request;

use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilterStorage;

use FindingAPI\Core\Exception\{ FindingApiException, ItemFilterException };

use SDKBuilder\Request\AbstractRequest;
use SDKBuilder\Request\RequestParameters;

class Request extends AbstractRequest
{
    /**
     * @var ItemFilterStorage
     */
    private $itemFilterStorage;
    /**
     * @var Options $options
     */
    private $options;
    /**
     * @var array $definitions
     */
    protected $definitions = array();
    /**
     * Request constructor.
     * @param RequestParameters $globalParameters
     * @param RequestParameters $specialParameters
     */
    public function __construct(RequestParameters $globalParameters, RequestParameters $specialParameters)
    {
        parent::__construct($globalParameters, $specialParameters);

        $this->itemFilterStorage = new ItemFilterStorage();

        $this->options = new Options();

        Definition::initiate($this->options);
    }
    /**
     * @param string $buyerPostalCode
     * @return Request
     * @throws FindingApiException
     */
    public function setBuyerPostalCode(string $buyerPostalCode) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter('BuyerPostalCode')) {
            throw new FindingApiException('Item filter BuyerPostalCode does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('BuyerPostalCode', array($buyerPostalCode));

        return $this;
    }
    /**
     * @param string $sortOrder
     * @return Request
     * @throws FindingApiException
     */
    public function setSortOrder(string $sortOrder) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter('SortOrder')) {
            throw new FindingApiException('Item filter SortOrder does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('SortOrder', array($sortOrder));

        return $this;
    }
    /**
     * @param int $pagination
     * @param string $paginationType
     * @return Request
     * @throws FindingApiException
     */
    public function setPaginationInput(int $pagination, string $paginationType) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter('PaginationInput')) {
            throw new FindingApiException('Item filter PaginationInput does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('PaginationInput', array($paginationType));

        return $this;
    }
    /**
     * @param array $outputSelector
     * @return Request
     * @throws ItemFilterException
     */
    public function setOutputSelector(array $outputSelector) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter('OutputSelector')) {
            throw new ItemFilterException('Item filter OutputSelector does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue('OutputSelector', $outputSelector);

        return $this;
    }
    /**
     * @param string $itemFilter
     * @param array $value
     * @return Request
     * @throws ItemFilterException
     */
    public function addItemFilter(string $itemFilterName, array $value) : Request
    {
        if (!$this->itemFilterStorage->hasItemFilter($itemFilterName)) {
            throw new ItemFilterException('Item filter '.$itemFilterName.' does not exists. Check FinderSearch::getItemFilterStorage()->addItemFilter() method');
        }

        $this->itemFilterStorage->updateItemFilterValue($itemFilterName, $value);

        return $this;
    }
    /**
     * @param int $option
     * @return Request
     */
    public function addOption(int $option) : Request
    {
        $this->options->addOption($option);

        return $this;
    }
    /**
     * @return ItemFilterStorage
     */
    public function getItemFilterStorage() : ItemFilterStorage
    {
        return $this->itemFilterStorage;
    }
    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}