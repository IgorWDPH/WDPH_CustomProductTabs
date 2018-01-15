<?php
namespace WDPH\CustomProductTabs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    protected $storeManager;
    protected $objectManager;

    const XML_PATH_SKELETON = 'wdph_customtabs_main/';

    public function __construct(Context $context, ObjectManagerInterface $objectManager, StoreManagerInterface $storeManager)
	{
        $this->objectManager = $objectManager;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    public function getConfig($config_path, $storeCode = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SKELETON . $config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeCode);
    }
}
?>