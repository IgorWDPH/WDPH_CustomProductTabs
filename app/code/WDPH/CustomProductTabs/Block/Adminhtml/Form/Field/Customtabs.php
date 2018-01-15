<?php
namespace WDPH\CustomProductTabs\Block\Adminhtml\Form\Field;

class Customtabs extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{    
    protected function _prepareToRender()
    {
        $this->addColumn('tab_title', ['label' => __('Title')]);
        $this->addColumn('attribute_code', ['label' => __('Attribute code')]);
        $this->addColumn('cms_block_code', ['label' => __('or CMS block code')]);        
        $this->addColumn('sort_order', ['label' => __('Order')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Tab');
    }
}
?>