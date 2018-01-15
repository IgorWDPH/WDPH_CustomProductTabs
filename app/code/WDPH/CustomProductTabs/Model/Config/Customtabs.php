<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace WDPH\CustomProductTabs\Model\Config;

/**
 * Backend for serialized array data
 */
class Customtabs extends \Magento\Framework\App\Config\Value
{    
    public function __construct(\Magento\Framework\Model\Context $context,
								\Magento\Framework\Registry $registry,
								\Magento\Framework\App\Config\ScopeConfigInterface $config,
								\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,								
								\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
								\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
								array $data = []
    ) {        
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }    
    
    protected function _afterLoad()
    {
        $value = $this->getValue();
        $arr = unserialize($value);
        
        $this->setValue($arr);
    }
    
    public function beforeSave()
    {
        $value = $this->getValue();
        unset($value['__empty']);
        $arr = serialize($value);
        
        $this->setValue($arr);
    }
}
