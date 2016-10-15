<?php

namespace Test;

require __DIR__.'/../vendor/autoload.php';

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Core\Response;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Condition;
use FindingAPI\Core\ResponseParser\ResponseItem\Child\Item;
use FindingAPI\Finding;
use FindingAPI\Core\Request;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency;
use FindingAPI\Core\Information\SortOrder;
use FindingAPI\Core\Information\GlobalId;

class MainTest extends \PHPUnit_Framework_TestCase
{
    public function testItemFilters()
    {
        $request = new Request();

        $itemFilterStorage = $request->getItemFilterStorage();

        // single value item filter
        $itemFilterStorage->addItemFilter(array(
            'SingleValueItemFilter' => array(
                'object' => 'Test\ItemFilter\SingleValueItemFilter',
                'value' => null,
                'multiple_values' => false,
                'date_time' => false,
            ),
        ));

        $this->assertTrue($itemFilterStorage->hasItemFilter('SingleValueItemFilter'));

        $itemFilterStorage->removeItemFilter('SingleValueItemFilter');

        $this->assertFalse($itemFilterStorage->hasItemFilter('SingleValueItemFilter'));

        // multiple value item filter

        $itemFilterStorage->addItemFilter(array(
            'MultipleValueItemFilter' => array(
                'object' => 'Test\ItemFilter\MultipleValueItemFilter',
                'value' => null,
                'multiple_values' => true,
                'date_time' => false,
            ),
        ));
    }

    public function testRequest()
    {
        $request = new Request();

        $request
            ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
            ->setMethod('get')
            ->setResponseDataFormat('xml')
            ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53')
            ->addSearch(Definition::customDefinition('harry potter'));
 //           ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
            //->specialFeature()->findLocalItems(31000)
//            ->setBuyerPostalCode(31000)
//            ->setSortOrder(SortOrder::START_TIME_NEWEST)
//            ->setPaginationInput(20, 'pageNumber')
//            ->setOutputSelector(array('SellerInfo', 'StoreInfo'))
            //->addOption(Options::SMART_GUESS_SYSTEM)
/*            ->addSearch(Definition::customDefinition('harry potter'))
            ->addItemFilter(ItemFilter::AUTHORIZED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::AVAILABLE_TO, array('AF'))
            ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
            ->addItemFilter(ItemFilter::CHARITY_ONLY, array(true))
            ->addItemFilter(ItemFilter::CONDITION, array('New', 1000, 1500, 1750))
            ->addItemFilter(ItemFilter::CURRENCY, array(Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::END_TIME_FROM, array(new \DateTime('1.1.2018 21:23:38')))
            ->addItemFilter(ItemFilter::END_TIME_TO, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::EXCLUDE_AUTO_PAY, array(true))
            ->addItemFilter(ItemFilter::EXCLUDE_CATEGORY, array(123, 435))
            ->addItemFilter(ItemFilter::EXCLUDE_SELLER, array('Budala', 'Idiot'))
            ->addItemFilter(ItemFilter::EXPEDITED_SHIPPING_TYPE, array('Expedited'))
            ->addItemFilter(ItemFilter::FEATURED_ONLY, array(true))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MAX, array(9))
            ->addItemFilter(ItemFilter::FEEDBACK_SCORE_MIN, array(9))
            ->addItemFilter(ItemFilter::FREE_SHIPPING_ONLY, array(true))
            ->addItemFilter(ItemFilter::GET_IT_FAST_ONLY, array(true))
            ->addItemFilter(ItemFilter::HIDE_DUPLICATE_ITEMS, array(true))
            ->addItemFilter(ItemFilter::LISTED_IN, array(GlobalId::EBAY_AT))
            ->addItemFilter(ItemFilter::LISTING_TYPE, array('All', 'AuctionWithBIN'))
            ->addItemFilter(ItemFilter::LOCAL_PICKUP_ONLY, array(true))
            ->addItemFilter(ItemFilter::LOCAL_SEARCH_ONLY, array(true))
            ->addItemFilter(ItemFilter::LOCATED_IN, array('dz', 'ai'))
            ->addItemFilter(ItemFilter::LOTS_ONLY, array(true))
            ->addItemFilter(ItemFilter::MAX_BIDS, array(1))
            ->addItemFilter(ItemFilter::MAX_HANDLING_TIME, array(1))
            ->addItemFilter(ItemFilter::MAX_DISTANCE, array(6))
            ->addItemFilter(ItemFilter::MAX_PRICE, array(0.0, Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::MAX_QUANTITY, array(1))
            ->addItemFilter(ItemFilter::MIN_BIDS, array(0))
            ->addItemFilter(ItemFilter::MIN_PRICE, array(0.1, Currency::AUSTRALIAN))
            ->addItemFilter(ItemFilter::MIN_QUANTITY, array(1))
            ->addItemFilter(ItemFilter::MOD_TIME_FROM, array(new \DateTime('1.1.2019')))
            ->addItemFilter(ItemFilter::OUTLET_SELLER_ONLY, array(false))
            ->addItemFilter(ItemFilter::PAYMENT_METHOD, array('PayPal'))
            ->addItemFilter(ItemFilter::RETURNS_ACCEPTED_ONLY, array(false))
            ->addItemFilter(ItemFilter::SELLER, array('Seller1'))
            ->addItemFilter(ItemFilter::SELLER_BUSINESS_TYPE, array('Business', 'Ebay-at'))
            ->addItemFilter(ItemFilter::SOLD_ITEMS_ONLY, array(true))
            ->addItemFilter(ItemFilter::START_TIME_FROM, array(new \DateTime('1.9.2018')))
            ->addItemFilter(ItemFilter::START_TIME_TO, array(new \DateTime('1.9.2019')))
            ->addItemFilter(ItemFilter::TOP_RATED_SELLER_ONLY, array(true))
            ->addItemFilter(ItemFilter::WORLD_OF_GOOD_ONLY, array(false));*/

        return $request;
    }
    /**
     * @depends testRequest
     */
    public function testFinder(Request $request)
    {
        $finder = Finding::getInstance($request);

        $finder->setValidationRule('global-item-filters', false);
        $finder->setValidationRule('individual-item-filters', false);

        $processed = $finder->send()->getProcessed();

        $response = $finder->getResponse();

        return $response;
    }
    /**
     * @depends testFinder
     */
    public function testResponse(Response $response)
    {
        $this->assertInternalType('string', $response->getRoot()->getName(), 'RootItem name should be ebay method name, for instance findItemByKeywordsResponse');
        $this->assertEquals('http://www.ebay.com/marketplace/search/v1/services', $response->getRoot()->getNamespace(), 'Invalid ebay api url, not a string');
        $this->assertInternalType('string', $response->getRoot()->getAck(), 'Invalid ack. Ack should be something like Success');
        $this->assertInternalType('string', $response->getRoot()->getTimestamp(), 'Invalid timestamp. Not a string');
        $this->assertInternalType('string', $response->getRoot()->getVersion(), 'Invalid version. Not a string');
        $this->assertInternalType('int', $response->getRoot()->getSearchResultsCount(), 'Invalid search results count. Not a string');


        $searchResults = $response->getSearchResults();

        $item = $searchResults->getItemById('360778402701');
        $this->validateItem($item);

        $item = $searchResults->getItemByName('Harry Potter Complete Book Series Special Edition Boxed Set by J.K. Rowling NEW!');
        $this->validateItem($item);
    }

    private function validateItem(Item $item)
    {
        $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\Item', $item, 'Invalid Item');

        $this->assertInternalType('string', $item->getItemId(), 'Item::getItemId() should return a string');
        $this->assertInternalType('string', $item->getGlobalId(), 'Item::getGlobalId() should return a string');
        $this->assertInternalType('string', $item->getTitle(), 'Item::getTitle() should return a title');
        $this->assertInternalType('string', $item->getViewItemUrl(), 'Item::getViewItemUrl() should return a string');
        $this->assertInternalType('array', $item->getProductId(), 'Item::getProductId() should return an array');
        $this->assertInternalType('string', $item->getPaymentMethod(), 'Item::getPaymentMethod() should return a string');
        $this->assertInternalType('bool', $item->getReturnsAccepted(), 'Item::getReturnsAccepted() should return bool');
        $this->assertInternalType('bool', $item->getIsMultiVariationListing(), 'Item::getIsMultiVariationListing() should return bool');
        $this->assertInternalType('bool', $item->getTopRatedListing(), 'Item::getTopRatedListing() should return boolean');

        $this->assertThat(
            $item->getAutoPay('autoPay'),
            $this->logicalOr(
                $this->isType('bool'),
                $this->equalTo('autoPay')
            ),
            'Item::getAutoPay() should return a bool'
        );

        $this->assertThat(
            $item->getPostalCode('postalCode'),
            $this->logicalOr(
                $this->isType('int'),
                $this->equalTo('postalCode')
            ),
            'Item::getPostalCode() should return a int'
        );

        $this->assertInternalType('string', $item->getLocation(), 'Item::getLocation() should return a string');
        $this->assertInternalType('string', $item->getCountry(), 'Item::getCountry() should return a string');

        if ($item->getGalleryUrl() !== null) {
            $this->assertInternalType('string', $item->getGalleryUrl(), 'Item::getGalleryUrl() should return a string');
        }

        $this->assertInternalType('string', $item->getPrimaryCategory()->getCategoryId(), 'Invalid primary category id. Expected string');
        $this->assertInternalType('string', $item->getPrimaryCategory()->getCategoryName(), 'Invalid primary category name. Expected string');

        $shippingInfo = $item->getShippingInfo();

        $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\ShippingInfo', $shippingInfo, 'Invalid object. Expected ShippingInfo');
        $this->assertInternalType('array', $shippingInfo->getShippingServiceCost(), 'ShippingInfo::getShippingServiceCost() has to return array');
        $this->assertInternalType('bool', $shippingInfo->getExpeditedShipping(), 'ShippingInfo::getExpeditedShipping() has to return bool');
        $this->assertInternalType('int', $shippingInfo->getHandlingTime(), 'ShippingInfo::getHandlingTime() has to return int');
        $this->assertInternalType('bool', (bool) $shippingInfo->getOneDayShippingAvailable(), 'ShippingInfo::oneDayShippingAvailable() has to return bool');
        $this->assertInternalType('string', $shippingInfo->getShippingType(), 'ShippingInfo::shippingType() has to return string');
        $this->assertInternalType('array', $shippingInfo->getShipToLocations(), 'ShippingInfo::shipToLocations() has to return array');

        $sellingStatus = $item->getSellingStatus();

        $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\SellingStatus', $sellingStatus, 'Invalid instance. SellingStatus expected');
        $this->assertThat(
            $sellingStatus->getBidCount(),
            $this->logicalOr(
                $this->isType('null'),
                $this->isType('int')
            ),
            'SellingStatus::getBidCount() should return either null or an integer'
        );

        $this->assertThat(
            $sellingStatus->getConvertedCurrentPrice(),
            $this->logicalOr(
                $this->isType('null'),
                $this->isType('array')
            ),
            'SellingStatus::getConvertedCurrentPrice() should return either null or a array'
        );

        $this->assertThat(
            $sellingStatus->getCurrentPrice(),
            $this->logicalOr(
                $this->isType('null'),
                $this->isType('array')
            ),
            'SellingStatus::getCurrentPrice() should return either null or a array'
        );

        $this->assertThat(
            $sellingStatus->getSellingState(),
            $this->logicalOr(
                $this->isType('null'),
                $this->isType('string')
            ),
            'SellingStatus::getSellingState() should return either null or a string'
        );

        $this->assertThat(
            $sellingStatus->getTimeLeft(),
            $this->logicalOr(
                $this->isType('null'),
                $this->isType('string')
            ),
            'SellingStatus::getTimeLeft() should return either null or a string'
        );

        $listingInfo = $item->getListingInfo();

        $this->assertInstanceOf('FindingAPI\Core\ResponseParser\ResponseItem\Child\ListingInfo', $listingInfo, 'Invalid instance. Expected ListingInfo');

        $this->assertThat(
            $listingInfo->getBestOfferEnabled('bestOfferEnabled'),
            $this->logicalOr(
                $this->equalTo('bestOfferEnabled'),
                $this->isType('bool')
            ),
            'ListingInfo::getBestOfferEnabled() should return either null or a boolean'
        );

        $this->assertThat(
            $listingInfo->getBuyItNowAvailable('buyItNowAvailable'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('buyItNowAvailable')
            ),
            'ListingInfo::getBuyItNowAvailable() should return a boolean'
        );

        $this->assertThat(
            $listingInfo->getStartTime('startTime'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('startTime')
            ),
            'ListingInfo::getStartTime() should return a string'
        );

        $this->assertThat(
            $listingInfo->getEndTime('endTime'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('endTime')
            ),
            'ListingInfo::getEndTime() should return a string'
        );

        $this->assertThat(
            $listingInfo->getListingType('listingType'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('listingType')
            ),
            'ListingInfo::getListingType() should return a string'
        );

        $this->assertThat(
            $listingInfo->getGift('gift'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('gift')
            ),
            'ListingInfo::getGift() should return a boolean'
        );

        $this->assertThat(
            $listingInfo->getBuyItNowPrice('buyItNowPrice'),
            $this->logicalOr(
                $this->isType('array'),
                $this->equalTo('buyItNowPrice')
            ),
            'ListingInfo::getBuyItNowPrice() should return a array'
        );

        $this->assertThat(
            $listingInfo->getConvertedBuyItNowPrice('convertedBuyItNowPrice'),
            $this->logicalOr(
                $this->isType('string'),
                $this->equalTo('convertedBuyItNowPrice')
            ),
            'ListingInfo::getConvertedBuyItNowPrice() should return a array'
        );

        if ($item->getCondition() instanceof Condition) {
            $condition = $item->getCondition();

            $this->assertInternalType('int', $condition->getConditionId(), 'Condition::getConditionId() should return an int');
            $this->assertInternalType('string', $condition->getConditionDisplayName(), 'Condition::getConditionDisplayName() should return a string');
        }
    }
}