<?php
namespace SclNominetEpp\Request\Update;

use SclNominetEpp\Contact;
use SclNominetEpp\Address;

use SclContact\Fax;
use SclContact\Country;
use SclContact\Postcode;
use SclContact\PhoneNumber;
use SclContact\PersonName;
use SclContact\Email;
use SclNominetEpp\Request\Update\ContactID as UpdateContactID;

class ContactIDTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->request = new UpdateContactID();
    }
}