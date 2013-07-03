<?php
namespace SclNominetEpp\Request\Update\Field;

/**
 * UpdateDomain|UpdateContact "chg" uses "authInfo" as a field with "pw" as an attribute.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactDisclose implements UpdateFieldInterface
{
    /**
     * The "flag" attribute contains an XML Schema boolean value.
     * 
     * A value of "true" or "1" (one) notes a client preference to
     * allow disclosure of the specified elements as an exception 
     * to the stated data-collection policy.  
     * 
     * A value of "false" or "0" (zero) notes a client preference 
     * to not allow disclosure of the specified elements as 
     * an exception to the stated data-collection policy.
     * 
     * @var string 
     */
    private $flag;
    
    /**
     *
     * @var mixed
     */
    private $discloseArray = array();
    
    /**
     * Area can be either "loc" or "int".
     * 
     * If an internationalized form (type="int") is provided, 
     * element content MUST be represented in a subset of UTF-8 
     * that can be represented in the 7-bit US-ASCII character set.
     *   
     * If a localized form (type="loc") is provided, 
     * element content MAY be represented in unrestricted UTF-8. 
     * 
     * @var string
     */
    private $area;

    public function __construct($flag, $discloseArray, $area = null)
    {
        $this->flag  = (string) $flag;
        $this->discloseArray = $discloseArray;
        $this->area = $area;
    }

    public function fieldXml(\SimpleXMLElement $xml, $namespace)
    {
        if (empty($this->discloseArray)) {
            return;
        }
        
        $authInfo   = $xml->addChild('disclose', '', $namespace);
        $authInfo->addAttribute('flag', $this->flag, $namespace);
        foreach ($this->discloseArray as $name => $value) {
            $discloseItem = $authInfo->addChild($name, $value, $namespace);
            if (!empty($area)) {
                $discloseItem->addAttribute('type', $area);
            }
        }
    }
}
