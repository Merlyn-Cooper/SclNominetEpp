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
     * @todo STATUS may be divided into Domain and Name Server, important!
     * "draft-hollenbeck-rfc2832bis-01.html" check out 2.1.1 and 2.1.2.
     * http://archive.icann.org/
     *
     * A client MUST NOT alter status values set by the server.
     * A server MAY alter or override status values set by a client, subject to local server policies.
     * Status values that can be added or removed by a client are prefixed with "client".
     */
    const STATUS_CLIENT_DELETE_PROHIBITED   = 'clientDeleteProhibited';
    const STATUS_CLIENT_UPDATE_PROHIBITED   = 'clientUpdateProhibited';

    // Corresponding status values that can be added or removed by a server are prefixed with "server".
    const STATUS_SERVER_DELETE_PROHIBITED   = 'serverDeleteProhibited';
    const STATUS_SERVER_UPDATE_PROHIBITED   = 'serverUpdateProhibited';

    /*
     * pending[action]" status MUST NOT be combined
     * with either:-
     * "client[action]Prohibited" or
     * "server[action]Prohibited" status or
     * other "pending[action]" status.
     */
    const STATUS_PENDING_DELETE   = 'pendingDelete';
    const STATUS_PENDING_TRANSFER = 'pendingTransfer';

    const STATUS_LINKED = 'linked';

    //"ok" status MUST NOT be combined with any other status except linked.
    const STATUS_OKAY = 'ok';
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

    /**
     * nameserverstatus = "OK" / "CLIENTUPDATEPROHIBITED" /
     * "CLIENTDELETEPROHIBITED" / "SERVERUPDATEPROHIBITED" /
     * "SERVERDELETEPROHIBITED" / "LINKED" /
     * "PENDINGTRANSFER" / "PENDINGDELETE"
     *
     * @var type
     */

    private $possibleStatus = array(
        self::STATUS_CLIENT_DELETE_PROHIBITED,
        self::STATUS_CLIENT_UPDATE_PROHIBITED,
        self::STATUS_LINKED,
        self::STATUS_OKAY,
        self::STATUS_PENDING_DELETE,
        self::STATUS_PENDING_TRANSFER,
        self::STATUS_SERVER_DELETE_PROHIBITED,
        self::STATUS_SERVER_UPDATE_PROHIBITED,
    );

    private $pendingStatuses = array(
        self::STATUS_PENDING_DELETE,
        self::STATUS_PENDING_TRANSFER
    );

    private $actions = array(
        "Delete",
        "Transfer",
        "Update",
        "Renew"
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
    public function addStatus($newStatus, $remStatus = null)
    {
        if (!in_array($newStatus, $this->possibleStatus)) {
            //fail, not a legal status.
            return false;
        }

        if ((!empty($this->status) && 'ok' == $newStatus)
                || ('linked' != $newStatus && in_array('ok', $this->status))) {
            ////fail, "ok" status MAY only be combined with "linked" status.
            return false;
        }

        /*if ('linked' != $newStatus && in_array('ok', $this->status)) {
            //fail, "ok" status MAY only be combined with "linked" status.
            return false;
        }*/

        foreach ($this->actions as $action) {
            /**
             * "pending{$action}" status MUST NOT be combined with either
             * "client{$action}Prohibited" or "server{$action}Prohibited" status.
             */
            if (("client{$action}Prohibited" == $newStatus || "server{$action}Prohibited == $newStatus")
                    && (in_array("pending{$action}", $this->status))) {
                //fail
                return false;
            }

            if (("pending{$action}" == $newStatus)
                    && ((in_array("client{$action}Prohibited", $this->status))
                    || (in_array("server{$action}Prohibited", $this->status)))) {
                //fail
                return false;
            }
        }

        /**
         * The pendingCreate, pendingDelete, pendingTransfer, and pendingUpdate
         * status values MUST NOT be combined with each other.
         * Other status combinations not expressly prohibited MAY be used.
         */

        if (in_array($newStatus, $this->pendingStatuses)) {
            foreach ($this->status as $status) {
                if (in_array($status, $this->pendingStatuses)) {
                    //fail,
                    return false;
                }
            }
        }
        $this->status[] = (string) $newStatus;

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
