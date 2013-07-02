<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain "chg" uses "registrant" as a field
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class DomainRegistrant implements UpdateFieldInterface
{
    private $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $xml->addChild('registrant', $this->contact, $namespace);
    }
}
