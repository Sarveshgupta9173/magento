<?php 

class SG_Brand_Block_Adminhtml_Brand_Grid_Renderer_Banner extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {

        $name = $row->getBanner();
        $imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$name;
        $path = "<img src='{$imageUrl}' width='100' height='100'>";

        return $path;
    }
}