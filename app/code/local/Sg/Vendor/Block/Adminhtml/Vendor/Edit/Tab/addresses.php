<?php

class SG_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Addresses extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        //setting the field form addresses
        $fieldset = $form->addFieldset('vendor_form',array('legend'=>Mage::helper('vendor')->__('Vendor Addresses')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('vendor')->__('Address'),
            'required' => false,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city','text', array(
            'label' => Mage::helper('vendor')->__('City'),
            'required' => false,
            'name' => 'address[city]'
        ));

        $fieldset->addField('country','select', array(
            'label' => Mage::helper('vendor')->__('Country'),
            'required' => false,
            'name' => 'address[country]',
            'options'=> $this->getCountryOptions(),
            'onchange'=> 'updateStateOptions(this.value)'
        ));

        $fieldset->addField('state', 'select', array(
            'label' => Mage::helper('vendor')->__('State'),
            'required' => false,
            'name' => 'address[state]',
            'options'=> $this->getStateOptions()
        ));


        $fieldset->addField('zipcode','text', array(
            'label' => Mage::helper('vendor')->__('Zipcode'),
            'required' => false,
            'name' => 'address[zipcode]'
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } 
        elseif ( Mage::registry('address_edit') ) {
            $form->setValues(Mage::registry('address_edit')->getData());
        }

         $script = '
            <script>
            function updateStateOptions(countryId) {
                console.log(countryId);
                var url = "' . $this->getUrl('*/*/updateStateOptions') . '"; // Replace with your controller action URL
                new Ajax.Request(url, {
                    method: "post",
                    parameters: { country_id: countryId },
                    onSuccess: function(transport) {
                        var response = transport.responseText.evalJSON();
                        var stateField = $("state");
                        stateField.update("");
                        response.each(function(option) {
                            stateField.insert(new Element("option", { value: option.value }).update(option.label));
                        });
                    }
                });
            }
            </script>';
        $fieldset->addField('ajax_script', 'note', array(
            'text'     => $script,
            'after_element_html' => '',
        ));

        return parent::_prepareForm();

    }

     public function getCountryOptions()
    {
         $countryCollection = Mage::getResourceModel('directory/country_collection')->loadByStore();
        $options = array();
        foreach ($countryCollection as $country) {
            $options[$country->getCountryId()] = $country->getName();
        }

        return $options;
    }

    public function getStateOptions()
    {
         $countryId = $this->getRequest()->getPost('address')['country']; // Retrieve the selected country ID

        $regionCollection = Mage::getModel('directory/region')->getResourceCollection()
            ->addCountryFilter($countryId)
            ->load();
    

        $stateOptions = array();

        foreach ($regionCollection as $region) {
            $stateOptions[$region->getCode()] = $region->getCode();
        }

        return $stateOptions;
    }

}





    