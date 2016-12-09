<?php
/**
 * @category    Itdelight
 * @package     Itdelight_UnsetProdCustomOptions
 * @author      Itdelight Team. Created by AleksLi <alex.litvinov@itdelight.com>
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$productsWithOptions = array();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$productsCollection = Mage::getModel('catalog/product')->getCollection();

foreach ($productsCollection as $product) {
    if ($product->getData('has_options') == 1) {
        array_push($productsWithOptions, $product->getEntityId());
    }

}

if (!empty($productsWithOptions)) {

    foreach ($productsWithOptions as $id) {

        $product = Mage::getModel('catalog/product')->load($id);

        $customOptions = $product->getOptions();

        foreach ($customOptions as $option) {
            $option->delete();
        }
        $product->setCanSaveCustomOptions(true);
        $product->setHasOptions(0);
    }
}

$installer->endSetup();


