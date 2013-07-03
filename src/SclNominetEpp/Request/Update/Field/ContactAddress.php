<?php
namespace SclNominetEpp\Request\Update\Field;

use SclNominetEpp\Address;

/**
 * UpdateContact "chg" uses "postalInfo" as a field with "type" as an attribute 
 * (either "loc" or "int").
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactAddress implements UpdateFieldInterface
{
    /**
     *
     * @var type
     */
    private $address;

    /**
     *
     * @param type $type
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     *
     * @param SimpleXMLElement $xml
     * @param type $namespace
     */
    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $postalInfo = $xml->addChild('postalInfo', '', $namespace);
        $postalInfo->addAttribute('type', $this->type);
        
        //Line1 and Line2 are Streets.
        if (null != $this->address->getLine1()) {
            $postalInfo->addChild('street', $this->address->getLine1());
        }
        if (null != $this->address->getLine2()) {
            $postalInfo->addChild('street', $this->address->getLine2());
        }
        if (null != $this->address->getCity()) {
            $postalInfo->addChild('city', $this->address->getCity());
        }
        //sp means "state/province" but it's county.
        if (null != $this->address->getCounty()) {
            $postalInfo->addChild('sp', $this->address->getCounty());
        }
        if (null != $this->address->getPostcode()) {
            $postalInfo->addChild('pc', $this->address->getPostcode());
        }
        //cc means "country code", but it's just country.
        if (null != $this->address->getCountry()) {
            $postalInfo->addChild('cc', $this->address->getCountry());
        }
    }
}
