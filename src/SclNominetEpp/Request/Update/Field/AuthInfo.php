<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain|UpdateContact "chg" uses "authInfo" as a field with "pw" as an attribute.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class AuthInfo implements UpdateFieldInterface
{
    private $passwd;

    public function __construct($passwd)
    {
        $this->passwd  = $passwd;
    }

    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        $authInfo   = $xml->addChild('authInfo', '', $namespace);
        $authInfo->addchild('pw', $this->passwd, $namespace);
    }
}
