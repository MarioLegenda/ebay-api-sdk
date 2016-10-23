<?php

require_once __DIR__.'/../vendor/autoload.php';

use FindingAPI\Finding;
use FindingAPI\Core\Request;

use FindingAPI\Core\Information\OperationName;
use FindingAPI\Definition\Definition;
use FindingAPI\Core\ItemFilter\ItemFilter;
use FindingAPI\Core\Information\Currency as InformationCurrency;

$request = new Request();

$request
    ->setOperationName(OperationName::FIND_ITEMS_BY_KEYWORDS)
    ->setMethod('get')
    ->setResponseDataFormat('xml')
    ->setSecurityAppId('Mariokrl-testing-PRD-ee6e68035-e73c8a53')
    ->addSearch(Definition::customDefinition('harry potter'))
    ->setOutputSelector(array('SellerInfo', 'StoreInfo', 'CategoryHistogram'))
    ->addItemFilter(ItemFilter::BEST_OFFER_ONLY, array(true))
    ->addItemFilter(ItemFilter::CURRENCY, array(InformationCurrency::AUSTRALIAN));

$finder = Finding::getInstance($request);

$body = (string) $finder->send()->getResponse()->getGuzzleResponse()->getBody();

$dom = new DOMDocument();
$dom->loadXML($body);

$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$xmlString = $dom->saveXML();

echo "<pre>";
echo htmlspecialchars($xmlString);
