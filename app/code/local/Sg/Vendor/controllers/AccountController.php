<?php 

class SG_Vendor_AccountController extends Mage_Core_Controller_Front_Action
{
    public function createAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('vendor/session');
    }

    public function createpostAction()
    {
        $vendorData = $this->getRequest()->getPost();
        $model = Mage::getModel('vendor/vendor');
        $model->setData($vendorData);
        $model->password = md5($model->password);
        $model->save();

        $checkboxValue = $this->getRequest()->getParam('checkbox_name');

        if ($checkboxValue) {
            // Generate a verification token
            $verificationToken = Mage::helper('core')->getRandomString(32);

            // Set the customer account to "pending" state
            $vendor = $this->_getSession()->getVendor();
            $vendor->setIsConfirmationRequired(true);
            $vendor->setConfirmation($verificationToken);
            $vendor->save();

            // Send the verification email
            $this->_sendVerificationEmail($vendor);
        }

        // Call the parent method to complete the registration process
        parent::createPostAction();
    }

     private function _sendVerificationEmail($vendor)
    {
        // Load the email template
        $storeId = Mage::app()->getStore()->getId();
        $templateId = Mage::getStoreConfig('customer/create_account/confirmation_template', $storeId);
        $emailTemplate = Mage::getModel('core/email_template')->load($templateId);

        // Set template variables
        $emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));
        $emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));
        $emailTemplateVariables = array(
            'vendor' => $vendor,
            'verification_url' => $this->_getVerificationUrl($vendor)
        );
        $emailTemplate->setVars($emailTemplateVariables);

        // Send the email
        $emailTemplate->send($vendor->getEmail(), $vendor->getName(), $emailTemplateVariables);
    }

    private function _getVerificationUrl($vendor)
    {
        // Generate the verification URL using the custom verification controller action
        $verificationUrl = $this->_getUrl(
            'your_module/account/verify',
            array(
                'id' => $vendor->getId(),
                'token' => $vendor->getConfirmation()
            )
        );

        return $verificationUrl;
    }

     protected function _getUrl($url, $params = array())
    {
        return Mage::getUrl($url, $params);
    }

    // protected function _getSession()
    // {
    //     return Mage::getSingleton('vendor/session');
    // }

    protected function _getVendor()
    {
        $vendor = $this->_getFromRegistry('current_vendor');
        if (!$vendor) {
            $vendor = $this->_getModel('vendor/vendor')->setId(null);
        }
        if ($this->getRequest()->getParam('is_subscribed', false)) {
            $vendor->setIsSubscribed(1);
        }
        /**
         * Initialize vendor group id
         */
        $vendor->getGroupId();

        return $vendor;
    }
}