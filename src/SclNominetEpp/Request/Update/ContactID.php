<?php

namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Response\Update\UpdateContactID as UpdateContactIDResponse;
use SclNominetEpp\Request\Update\AbstractUpdate;
use SclNominetEpp\Contact as ContactObject;
use SclNominetEpp\Request\Update\Field\UpdateFieldInterface;

/**
 * This class build the XML for a Nominet EPP contact:update command.
 *
 * @author Merlyn Cooper <merlyn.cooper@hotmail.co.uk>
 */
class ContactID extends AbstractUpdate
{
    const TYPE = 'contact-id'; //For possible Abstracting later
    const UPDATE_NAMESPACE = 'urn:ietf:params:xml:ns:contact-1.0';

    const VALUE_NAME = 'id';

    protected $contactID = null;
    protected $newContactID;

    public function __construct(ContactObject $contactID, ContactObject $newContactID)
    {
        parent::__construct(
            self::TYPE,
            new UpdateContactIDResponse(),
            self::UPDATE_NAMESPACE,
            self::VALUE_NAME
        );

        $this->contactID    = $contactID;
        $this->newContactID = $newContactID;
    }

    /**
     * {@inheritDoc}
     *
     * @param \SimpleXMLElement $updateXML
     */
    public function addContent(SimpleXMLElement $updateXML)
    {
        $contactNS   = self::UPDATE_NAMESPACE;

        $contactXSI   =   $contactNS . ' ' . 'contact-id-1.0.xsd';

        $update = $updateXML->addChild('contact-id:update', '', $contactNS);
        $update->addAttribute('xsi:schemaLocation', $contactXSI);
        $update->addChild(self::VALUE_NAME, $this->contactID, self::UPDATE_NAMESPACE);
        $change = $update->addChild('chg');
        $change->addChild(self::VALUE_NAME, $this->newContactID);
    }

    public function setContactID($contactID)
    {
        $this->contactID = $contactID;
    }

    /**
     * @todo contactID needs a ->getId() or ->getName() function.
     * @return string
     */
    public function getName()
    {
        return $this->contactID->getId();
    }

    /**
     * An Exception is thrown if the object is not of type \SclNominetEpp\Contact
     *
     * @throws Exception
     */
    public function objectValidate($contact)
    {
        if (!$contact instanceof ContactObject) {
            $exception = sprintf('A valid contact object was not passed to UpdateContactID, Ln:%d', __LINE__);
            throw new Exception($exception);
        }
        return true;
    }
}
