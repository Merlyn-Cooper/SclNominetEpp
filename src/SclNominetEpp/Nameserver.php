<?php
namespace SclNominetEpp;

use DateTime;

/**
 * A nameserver record.
 *
 * @author Tom Oram <tom@scl.co.uk
 * @todo Add format checking for IPv4 and IPv6
 */
class Nameserver
{
    /**
     * The nameserver host name
     *
     * @var string
     */
    private $hostName;

    /**
     * Array of status of a Nameserver
     *
     * @var array|string
     */
    private $status = array();

    private $possibleStatus = array(
        "ok",
        "linked",
        "serverDeleteProhibited",
        "clientDeleteProhibited",
        "pendingDelete",
        "pendingTransfer",
        "serverUpdateProhibited",
        "clientUpdateProhibited"
    );

    /**
     * The identifier of the sponsoring client.
     *
     * @var string
     */
    private $clientID;

    /**
     * The identifier of the client that created the host object
     *
     * @var string
     */
    private $creatorID;

    /**
     * The date and time of host-object creation.
     *
     * @var string
     */
    private $created;

    /**
     * The identifier of the client
     * that last updated the host object.
     *
     * @var string
     */
    private $upID = "";

    /**
     * The date and time of the most recent
     * host-object modification
     *
     * @var string
     */
    private $upDate;

    /**
     * The v4 IP address
     *
     * @var string
     */
    private $ipv4 = null;

    /**
     * The v6 IP address
     *
     * @var string
     */
    private $ipv6 = null;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set $this->hostName
     *
     * @param string $hostName
     */
    public function setHostName($hostName)
    {
        $this->hostName = (string) $hostName;
    }

    /**
     * Get $this->hostName
     *
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * Set $this->status
     *
     * @param string $status
     */
    public function addStatus($status)
    {
        if (!in_array($newStatus, $this->possibleStatus)) {
            //fail, not a legal status.
            return false;
        }

        if ('linked' != $newStatus && in_array('ok', $this->status)) {
            //fail, "ok" status MAY only be combined with "linked" status.
            return false;
        }

        /**
         * "pendingDelete" status MUST NOT be combined with either
         * "clientDeleteProhibited" or "serverDeleteProhibited" status.
         */
        if (("clientDeleteProhibited" == $newStatus || "serverDeleteProhibited == $newStatus")
                && (in_array('pendingDelete', $this->status))) {
            //fail
            return false;
        }

        if (("pendingDelete" == $newStatus)
                && ((in_array('clientDeleteProhibited', $this->status))
                || (in_array('serverDeleteProhibited', $this->status)))) {
            //fail
            return false;
        }

        /**
         * "pendingTransfer" status MUST NOT be combined with either
         * "clientTransferProhibited" or "serverTransferProhibited" status.
         */
        if (("clientTransferProhibited" == $newStatus || "serverTransferProhibited == $newStatus")
                && (in_array('pendingTransfer', $this->status))) {
            //fail
            return false;
        }

        if (("pendingTransfer" == $newStatus)
                && ((in_array('clientTransferProhibited', $this->status))
                || (in_array('serverTransferProhibited', $this->status)))) {
            //fail
            return false;
        }

        /*
         * "pendingUpdate" status MUST NOT be combined with either
         * "clientUpdateProhibited" or "serverUpdateProhibited" status.
         */
        if (("clientUpdateProhibited" == $newStatus || "serverUpdateProhibited == $newStatus")
                && (in_array('pendingUpdate', $currentStatuses))) {
            //fail
            return false;
        }

        if (("pendingUpdate" == $newStatus)
                && ((in_array('clientUpdateProhibited', $currentStatuses))
                || (in_array('serverUpdateProhibited', $currentStatuses)))) {
            //fail
            return false;
        }
        /**
         * The pendingCreate, pendingDelete, pendingTransfer, and pendingUpdate
         * status values MUST NOT be combined with each other.
         * Other status combinations not expressly prohibited MAY be used.
         */

        if (in_array($newStatus, $this->pendingStatuses)) {
            foreach ($currentStatuses as $status) {
                if (in_array($status, $this->pendingStatuses)) {
                    //fail,
                    return false;
                }
            }
        }
        $this->status[] = (string) $status;

        return true;
    }

    /**
     * Get $this->status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set $this->created
     *
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Get $this->created
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set $this->creatorID
     *
     * @param string $creatorID
     */
    public function setCreatorID($creatorID)
    {
        $this->creatorID = (string) $creatorID;
    }

    /**
     * Get $this->creatorID
     *
     * @return string
     */
    public function getCreatorID()
    {
        return $this->creatorID;
    }

    /**
     * Set $this->clientID
     *
     * @param string $clientID
     */
    public function setClientID($clientID)
    {
        $this->clientID = (string) $clientID;
    }

    /**
     * Get $this->clientID
     *
     * @return string
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * Set the ID of the user that last changed the domain name.
     *
     * @param string $upID
     */
    public function setUpID($upID)
    {
        $this->upID = (string) $upID;
    }

    /**
     * Get the ID of the user that last changed the domain name.
     *
     * @return string
     */
    public function getUpID()
    {
        return $this->upID;
    }

    /**
     * Set the date the domain name was last changed.
     *
     * @param DateTime $upDate
     */
    public function setUpDate(DateTime $upDate)
    {
        $this->upDate = $upDate;
    }

    /**
     * Get the date the domain name was last changed.
     *
     * @return DateTime
     */
    public function getUpDate()
    {
        return $this->upDate;
    }

    /**
     * Set $this->ipv4
     *
     * @param string $ipv4
     */
    public function setIpv4($ipv4)
    {
        $this->ipv4 = (string) $ipv4;
    }

    /**
     * Get $this->ipv4
     *
     * @return string
     */
    public function getIpv4()
    {
        return $this->ipv4;
    }

    /**
     * Set $this->ipv6
     *
     * @param string $ipv6
     */
    public function setIpv6($ipv6)
    {
        $this->ipv6 = (string) $ipv6;
    }

    /**
     * Get $this->ipv6
     *
     * @return string
     */
    public function getIpv6()
    {
        return $this->ipv6;
    }
}
