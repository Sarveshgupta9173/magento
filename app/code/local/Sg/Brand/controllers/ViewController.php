<?php
// echo 111; die;
class SG_Brand_ViewController extends Mage_Core_Controller_Front_Action
{

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
