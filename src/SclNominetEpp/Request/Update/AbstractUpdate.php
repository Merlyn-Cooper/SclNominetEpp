<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Request;
use SimpleXMLElement;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This abstract class enables building the XML for a Nominet EPP update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
abstract class AbstractUpdate extends Request
{
    protected $type;

    protected $updateNamespace;

    protected $valueName;
    
    protected $updateExtensionNamespace;

    protected $value;
    
    protected $extensionExists = false;
    
    protected $updateXSI;
    
    protected $extensionXSI;

    /**
     *
     * @param type $type
     * @param type $response
     * @param type $updateNamespace
     * @param type $valueName
     */
    public function __construct($type, $response, $updateNamespace, $valueName, $updateExtensionNamespace)
    {
        parent::__construct('update', $response);

        $this->type            = $type;
        $this->updateNamespace = $updateNamespace;
        $this->valueName       = $valueName;
        if (null != $updateExtensionNamespace) {
           $this->updateExtensionNamespace = $updateExtensionNamespace; 
           $this->extensionExists = true;
        }
    }
    
    public function addContent( SimpleXMLElement $updateXML )
    {
        parent::addContent($updateXML);
        $updateNS   = $this->updateNamespace;
        if ($this->extensionExists) {
            $extensionNS = $this->updateExtensionNamespace;
        }
        $updateXSI   =   $updateNS . ' ' . "{$this->type}-1.0.xsd";
        $this->updateXSI = $updateXSI;
        if ($this->extensionExists) {
            $this->extensionXSI = $extensionNS . ' ' . "{$this->type}-nom-ext-1.1.xsd";
        }
        $update = $updateXML->addChild("{$this->type}:update", '', $updateNS);
        $update->addAttribute('xsi:schemaLocation', $updateXSI);
        $update->addChild($this->valueName, $this->getObject(), $updateNS);
    }

    abstract protected function getObject();

    /**
     * Valdiates whether the object is of the correct class.
     *
     * @param object $object
     * @return boolean
     * @throws Exception
     */
    abstract protected function objectValidate($object);
    
    public function lookup($value)
    {
        $this->value = $value;

        return $value;
    }

        /**
     * The <b>add()</b> function assigns a Field object as an element of the add array
     * for including specific fields in the update request "{$this->type}:add" tag.
     * ($this->type = 'domain' || 'contact' || 'contact-id' || 'host'; (pseudo-code))
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    protected function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * The <b>remove()</b> function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "{$this->type}:remove" tag.
     * ($this->type = 'domain' || 'contact' || 'contact-id' || 'host'; (pseudo-code))
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    protected function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }
}
