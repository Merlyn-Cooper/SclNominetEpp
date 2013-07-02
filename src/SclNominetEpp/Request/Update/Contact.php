<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\Contact as UpdateContactResponse;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Request\Update\AbstractUpdate;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class Contact extends AbstractUpdate
{
    const TYPE = 'contact'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';
    const UPDATE_EXTENSION_NAMESPACE = 'http://www.nominet.org.uk/epp/xml/contact-nom-ext-1.1';

    const VALUE_NAME = 'id';

    protected $contact = null;
    protected $value;

    private $add = array();
    private $remove = array();

    public function __construct(ContactObject $contact)
    {
        parent::__construct(
                self::TYPE, 
                new UpdateContactResponse(), 
                self::UPDATE_NAMESPACE, 
                self::VALUE_NAME, 
                self::UPDATE_EXTENSION_NAMESPACE
                );
        $this->contact = $contact;
    }


    /**
     * The <b>add()</b> function assigns a Field object as an element of the add array
     * for including specific fields in the update request "contact:add" tag.
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    public function add(UpdateFieldInterface $field)
    {
        $this->add[] = $field;
    }

    /**
     * The <b>remove()</b> function assigns a Field object as an element of the remove array
     * for including specific fields in the update request "contact:remove" tag.
     *
     * @param \SclNominetEpp\Request\Update\Field\UpdateFieldInterface $field
     */
    public function remove(UpdateFieldInterface $field)
    {
        $this->remove[] = $field;
    }

    public function addContent(\SimpleXMLElement $updateXML)
    {
        parent::addContent($updateXML);
        $contactNS   = self::UPDATE_NAMESPACE;
        $extensionNS = self::UPDATE_EXTENSION_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'contact-1.0.xsd';
        $extensionXSI = $extensionNS . ' ' . 'contact-nom-ext-1.1.xsd';

        $update = $updateXML->addChild('contact:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contact, $contactNS);

        /**
         * 
         * updateNS
         * extensionNS
         * parent::updateXSI
         * parent::extensionXSI
         * 
         * 
         */
        
        $addBlock = $updateXML->addChild('add', '', $contactNS);

        foreach ($this->add as $field) {
            $field->fieldXml($addBlock, $contactNS);
        }

        $remBlock = $updateXML->addChild('rem', '', $contactNS);

        foreach ($this->remove as $field) {
            $field->fieldXml($remBlock, $contactNS);
        }

        $change = $update->addChild('chg');
            $postalInfo = $change->addChild('postalInfo');
            $postalInfo->addAttribute('type', $type);
                $postalInfo->addChild('name');
                $addr = $postalInfo->addChild('addr');
                    $addr->addChild('street');
                    $addr->addChild('city');
                    $addr->addChild('sp');
                    $addr->addChild('pc');
                    $addr->addChild('cc');
        $extensionXML = $this->xml->command->addChild('extension');
        $extension = $extensionXML->addChild('contact-nom-ext:update', '', $extensionNS);
        $extension->addAttribute('xsi:schemaLocation', $extensionXSI);

        $extension->addChild('trad-name');
        $extension->addChild('type');
        $extension->addChild('co-no');
        $extension->addChild('opt-out');
        //@todo implement all variables, also, fix the extension data.

    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }
    
    public function getObject()
    {
        return $this->contact->getId();
    }
    
    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Contact
     *
     * @throws Exception
     */
    public function objectValidate($contact)
    {
        if (!$contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to UpdateContact, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }
}
