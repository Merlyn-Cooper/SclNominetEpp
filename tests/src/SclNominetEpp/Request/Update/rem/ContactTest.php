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
use SclNominetEpp\Request\Update\Contact as UpdateContact;

class ContactTest extends \PHPUnit_Framework_TestCase
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
        $this->request = new UpdateContact();
    }
    
    /**
     *
     */
    public function testCreateContact()
    {
        $xml = <<<EOX
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="urn:ietf:params:xml:ns:epp-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
  <command>
    <update>
      <contact:update
       xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
        <contact:id>sh8013</contact:id>
        <contact:rem>
          <contact:status s="clientDeleteProhibited"/>
        </contact:rem>
      </contact:update>
    </update>
    <clTRID>ABC-12345</clTRID>
  </command>
</epp>
               
EOX;
    }
}
