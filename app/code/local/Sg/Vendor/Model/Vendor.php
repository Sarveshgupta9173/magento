<?php

class SG_Vendor_Model_Vendor extends Mage_Core_Model_Abstract
{   
    const XML_PATH_IS_CONFIRM   = 'vendor/create_account/confirm';

     private static $_isConfirmationRequired;

    function __construct()
    {
        $this->_init('vendor/vendor');
    }

    public function sendNewAccountEmail($type = 'registered', $backUrl = '', $storeId = '0', $password = null)
    {
        $types = array(
            'registered'   => self::XML_PATH_REGISTER_EMAIL_TEMPLATE, // welcome email, when confirmation is disabled
            'confirmed'    => self::XML_PATH_CONFIRMED_EMAIL_TEMPLATE, // welcome email, when confirmation is enabled
            'confirmation' => self::XML_PATH_CONFIRM_EMAIL_TEMPLATE, // email with confirmation link
        );
        if (!isset($types[$type])) {
            Mage::throwException(Mage::helper('vendor')->__('Wrong transactional account email type'));
        }

        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId($this->getSendemailStoreId());
        }

        if (!is_null($password)) {
            $this->setPassword($password);
        }

        $this->_sendEmailTemplate($types[$type], self::XML_PATH_REGISTER_EMAIL_IDENTITY,
            array('vendor' => $this, 'back_url' => $backUrl), $storeId);
        $this->cleanPasswordsValidationData();

        return $this;
    }

    public function isConfirmationRequired()
    {
        // if ($this->canSkipConfirmation()) {
        //     return false;
        // }
        if (self::$_isConfirmationRequired === null) {
            $storeId = $this->getStoreId() ? $this->getStoreId() : null;
            self::$_isConfirmationRequired = (bool)Mage::getStoreConfig(self::XML_PATH_IS_CONFIRM, $storeId);
        }

        return self::$_isConfirmationRequired;
    }

    public function getRandomConfirmationKey()
    {
        return md5(uniqid());
    }

    public function sendPasswordReminderEmail()
    {
        $storeId = $this->getStoreId();
        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId();
        }

        $this->_sendEmailTemplate(self::XML_PATH_REMIND_EMAIL_TEMPLATE, self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            array('vendor' => $this), $storeId);

        return $this;
    }

    public function sendChangedPasswordOrEmail()
    {
        $storeId = $this->getStoreId();
        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId();
        }

        $this->_sendEmailTemplate(self::XML_PATH_CHANGED_PASSWORD_OR_EMAIL_TEMPLATE,
            self::XML_PATH_CHANGED_PASSWORD_OR_EMAIL_IDENTITY,
            array('vendor' => $this), $storeId, $this->getOldEmail());

        return $this;
    }

    protected function _sendEmailTemplate($template, $sender, $templateParams = array(), $storeId = null, $customerEmail = null)
    {
        $customerEmail = ($customerEmail) ? $customerEmail : $this->getEmail();
        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($customerEmail, $this->getName());
        $mailer->addEmailInfo($emailInfo);

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig($sender, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId(Mage::getStoreConfig($template, $storeId));
        $mailer->setTemplateParams($templateParams);
        $mailer->send();
        return $this;
    }

    public function sendPasswordResetConfirmationEmail()
    {
        $storeId = Mage::app()->getStore()->getId();
        if (!$storeId) {
            $storeId = $this->_getWebsiteStoreId();
        }

        $this->_sendEmailTemplate(self::XML_PATH_FORGOT_EMAIL_TEMPLATE, self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            array('vendor' => $this), $storeId);

        return $this;
    }

     protected function _getWebsiteStoreId($defaultStoreId = null)
    {
        if ($this->getWebsiteId() != 0 && empty($defaultStoreId)) {
            $storeIds = Mage::app()->getWebsite($this->getWebsiteId())->getStoreIds();
            reset($storeIds);
            $defaultStoreId = current($storeIds);
        }
        return $defaultStoreId;
    }

}