<?php
namespace SclNominetEpp\Request\Update\Field;

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
    private $type;

    /**
     *
     * @param type $type
     */
    public function __construct($type)
    {
        $this->type     = $type;
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

    }
}
