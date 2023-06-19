<?php

class SG_Vendor_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * Customer object
     *
     * @var Mage_Customer_Model_Customer
     */
    protected $_customer;

    /**
     * Flag with customer id validations result
     *
     * @var bool
     */
    protected $_isVendorIdChecked = null;

    /**
     * Persistent customer group id
     *
     * @var null|int
     */
    protected $_persistentVendorGroupId = null;

    /**
     * Retrieve customer sharing configuration model
     *
     * @return Mage_Customer_Model_Config_Share
     */
    public function getVendorConfigShare()
    {
        return Mage::getSingleton('vendor/config_share');
    }

    public function __construct()
    {
        $namespace = 'vendor';
        // if ($this->getVendorConfigShare()->isWebsiteScope()) {
        //     $namespace .= '_' . (Mage::app()->getStore()->getWebsite()->getCode());
        // }

        $this->init($namespace);
        Mage::dispatchEvent('vendor_session_init', array('vendor_session'=>$this));
    }

    /**
     * Set customer object and setting customer id in session
     *
     * @param   Mage_Customer_Model_Customer $customer
     * @return  Mage_Customer_Model_Session
     */
    public function setVendor(SG_Vendor_Model_Vendor $vendor)
    {
        // check if customer is not confirmed
        if ($vendor->isConfirmationRequired()) {
            if ($vendor->getConfirmation()) {
                return $this->_logout();
            }
        }
        $this->vendor = $vendor;
        $this->setId($vendor->getId());
        // save customer as confirmed, if it is not
        if ((!$vendor->isConfirmationRequired()) && $vendor->getConfirmation()) {
            $vendor->setConfirmation(null)->save();
            $vendor->setIsJustConfirmed(true);
        }
        return $this;
    }

    /**
     * Retrieve customer model object
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getVendor()
    {
        if ($this->vendor instanceof SG_Vendor_Model_Vendor) {
            return $this->vendor;
        }

        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        if ($this->getId()) {
            $vendor->load($this->getId());
        }

        $this->setVendor($vendor);
        return $this->vendor;
    }

    /**
     * Set customer id
     *
     * @param int|null $id
     * @return Mage_Customer_Model_Session
     */
    public function setVendorId($id)
    {
        $this->setData('vendor_id', $id);
        return $this;
    }

    /**
     * Retrieve customer id from current session
     *
     * @return int|null
     */
    public function getVendorId()
    {
        if ($this->getData('vendor_id')) {
            return $this->getData('vendor_id');
        }
        return ($this->isLoggedIn()) ? $this->getId() : null;
    }

    /**
     * Set customer group id
     *
     * @param int|null $id
     * @return Mage_Customer_Model_Session
     */
    public function setVendorGroupId($id)
    {
        $this->setData('vendor_group_id', $id);
        return $this;
    }

    /**
     * Get customer group id
     * If customer is not logged in system, 'not logged in' group id will be returned
     *
     * @return int
     */
    public function getVendorGroupId()
    {
        if ($this->getData('vendor_group_id')) {
            return $this->getData('vendor_group_id');
        }
        if ($this->isLoggedIn() && $this->getVendor()) {
            return $this->getVendor()->getGroupId();
        }
        return Mage_Vendor_Model_Group::NOT_LOGGED_IN_ID;
    }

    /**
     * Checking customer login status
     *
     * @return bool
     */
    public function isLoggedIn()
    {
        return (bool)$this->getId() && (bool)$this->checkVendorId($this->getId());
    }

    /**
     * Check exists customer (light check)
     *
     * @param int $customerId
     * @return bool
     */
    public function checkVendorId($customerId)
    {
        if ($this->_isVendorIdChecked === null) {
            $this->_isVendorIdChecked = Mage::getResourceSingleton('vendor/vendor')->checkVendorId($vendorId);
        }
        return $this->_isVendorIdChecked;
    }

    /**
     * Customer authorization
     *
     * @param   string $username
     * @param   string $password
     * @return  bool
     */
    public function login($username, $password)
    {
        /** @var $customer Mage_Customer_Model_Customer */
        $vendor = Mage::getModel('vendor/vendor')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId());

        if ($vendor->authenticate($username, $password)) {
            $this->setVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    public function setVendorAsLoggedIn($vendor)
    {
        $this->setVendor($vendor);
        $this->renewSession();
        Mage::getSingleton('core/session')->renewFormKey();
        Mage::dispatchEvent('vendor_login', array('vendor'=>$vendor));
        return $this;
    }

    /**
     * Authorization customer by identifier
     *
     * @param   int $customerId
     * @return  bool
     */
    public function loginById($vendorId)
    {
        $vendor = Mage::getModel('vendor/vendor')->load($vendorId);
        if ($vendor->getId()) {
            $this->setVendorAsLoggedIn($vendor);
            return true;
        }
        return false;
    }

    /**
     * Logout customer
     *
     * @return Mage_Customer_Model_Session
     */
    public function logout()
    {
        if ($this->isLoggedIn()) {
            Mage::dispatchEvent('vendor_logout', array('vendor' => $this->getVendor()) );
            $this->_logout();
        }
        return $this;
    }

    /**
     * Authenticate controller action by login customer
     *
     * @param   Mage_Core_Controller_Varien_Action $action
     * @param   bool $loginUrl
     * @return  bool
     */
    public function authenticate(Mage_Core_Controller_Varien_Action $action, $loginUrl = null)
    {
        if ($this->isLoggedIn()) {
            return true;
        }

        $this->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
        if (isset($loginUrl)) {
            $action->getResponse()->setRedirect($loginUrl);
        } else {
            $action->setRedirectWithCookieCheck(Mage_Vendor_Helper_Data::ROUTE_ACCOUNT_LOGIN,
                Mage::helper('vendor')->getLoginUrlParams()
            );
        }

        return false;
    }

    /**
     * Set auth url
     *
     * @param string $key
     * @param string $url
     * @return Mage_Customer_Model_Session
     */
    protected function _setAuthUrl($key, $url)
    {
        $url = Mage::helper('core/url')
            ->removeRequestParam($url, Mage::getSingleton('core/session')->getSessionIdQueryParam());
        // Add correct session ID to URL if needed
        $url = Mage::getModel('core/url')->getRebuiltUrl($url);
        return $this->setData($key, $url);
    }

    /**
     * Logout without dispatching event
     *
     * @return Mage_Customer_Model_Session
     */
    protected function _logout()
    {
        $this->setId(null);
        $this->setCustomerGroupId(Mage_Customer_Model_Group::NOT_LOGGED_IN_ID);
        $this->getCookie()->delete($this->getSessionName());
        Mage::getSingleton('core/session')->renewFormKey();
        return $this;
    }

    /**
     * Set Before auth url
     *
     * @param string $url
     * @return Mage_Customer_Model_Session
     */
    public function setBeforeAuthUrl($url)
    {
        return $this->_setAuthUrl('before_auth_url', $url);
    }

    /**
     * Set After auth url
     *
     * @param string $url
     * @return Mage_Customer_Model_Session
     */
    public function setAfterAuthUrl($url)
    {
        return $this->_setAuthUrl('after_auth_url', $url);
    }

    /**
     * Reset core session hosts after reseting session ID
     *
     * @return Mage_Customer_Model_Session
     */
    public function renewSession()
    {
        parent::renewSession();
        Mage::getSingleton('core/session')->unsSessionHosts();

        return $this;
    }
}
