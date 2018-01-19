<?php
namespace WDPH\CustomProductTabs\Model\Observer;

class AddUpdateHandlesObserver implements \Magento\Framework\Event\ObserverInterface
{    
	protected $customTabsHelper;
    
    public function __construct(\WDPH\CustomProductTabs\Helper\Data $customTabsHelper)
    {
		$this->customTabsHelper = $customTabsHelper;
    }
   
    public function execute(\Magento\Framework\Event\Observer $observer)
    {		
        if(!$this->customTabsHelper->getConfig('general/enabled') || $observer->getData('full_action_name') != 'catalog_product_view') 
		{
            return $this;
        }		
		$layout = $observer->getData('layout');
        if($this->customTabsHelper->getConfig('general/remove_attrtab'))
		{			
            $layout->getUpdate()->addHandle('wdph_customtabs_removeattr_tab');
        }
		if($this->customTabsHelper->getConfig('general/remove_desctab'))
		{			
            $layout->getUpdate()->addHandle('wdph_customtabs_removedesc_tab');
        }
		if($this->customTabsHelper->getConfig('general/remove_revtab'))
		{			
            $layout->getUpdate()->addHandle('wdph_customtabs_removerev_tab');
        }
        return $this;
    }
}
?>