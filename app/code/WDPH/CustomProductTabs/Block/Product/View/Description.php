<?php
namespace WDPH\CustomProductTabs\Block\Product\View;

class Description extends \Magento\Catalog\Block\Product\View\Description
{
	protected $customTabsHelper;
	protected $filterProvider;
	protected $staticBlockRepository;
	protected $storeManager;
	
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
								\Magento\Framework\Registry $registry,
								\WDPH\CustomProductTabs\Helper\Data $customTabsHelper,
								\Magento\Cms\Model\Template\FilterProvider $filterProvider,
								\Magento\Cms\Model\BlockRepository $staticBlockRepository,
								array $data = [])
	{
		$this->staticBlockRepository = $staticBlockRepository;
		$this->filterProvider = $filterProvider;
		$this->storeManager = $context->getStoreManager();
		$this->customTabsHelper = $customTabsHelper;
        parent::__construct($context, $registry, $data);
	}
	
	public function getCustomTabs()
	{
		if($this->customTabsHelper->getConfig('general/enabled'))
		{
			$tabs = unserialize($this->customTabsHelper->getConfig('general/custom_tabs'));
			$resultTabs = array();
			if(empty($tabs)) return array();
			$counter = 0;
			foreach($tabs as $key => $tab)
			{
				$attrContent = '';
				$cmsContent = '';
				if(trim($tab['attribute_code']))
				{
					$attrContent = $this->getAttrValue(trim($tab['attribute_code']));
				}
				if(trim($tab['cms_block_code']))
				{
					$cmsContent = $this->getStaticBlockContent(trim($tab['cms_block_code']));
				}				
				if(!$attrContent && !$cmsContent) continue;
				$resultTabs[$counter]['tab_content'] = $attrContent . $cmsContent;
				$resultTabs[$counter]['key'] = $key;
				$resultTabs[$counter]['sort_order'] = intval($tab['sort_order']);
				$resultTabs[$counter]['tab_title'] = (trim($tab['tab_title'])) ? trim($tab['tab_title']) : 'Oops, someone forgot set tab title :(';
				$resultTabs[$counter]['tab_content_attr'] = '';
				$resultTabs[$counter]['tab_content_block'] = '';
				$resultTabs[$counter]['tab_content_error'] = '';				
				$counter++;
			}
			$resultTabs = $this->sorter($resultTabs);			
			return $resultTabs;
		}
		return array();
	}
	
	protected function getAttrValue($attrCode)
	{
		$product = $this->getProduct();
		$attr = $product->getResource()->getAttribute($attrCode);		
		if(is_object($attr)) return $attr->getFrontend()->getValue($product);
		return '';
	}
	
	protected function getStaticBlockContent($blockId)
	{
        try
		{
            $cmsBlock = $this->staticBlockRepository->getById($blockId);
			if(!$cmsBlock->isActive()) return '<h3>Oops, CMS block deactivated :(</h3>';
			$cmsBlockContent = $this->filterProvider->getBlockFilter()->setStoreId($this->storeManager->getStore()->getId())->filter($cmsBlock->getContent());
			if(!trim($cmsBlockContent)) return '<h3>Oops, CMS block empty :(</h3>';
			return $cmsBlockContent;
        }
		catch(\Exception $e)
		{
            return 'Looks like CMS Block ID are incorret :(';
        }
        return false;
    }
	
	protected function sorter($tabs)
	{
		if(!(count($tabs) > 0)) return $tabs;
		for($i = 0; $i < count($tabs) - 1; $i++)
		{
			for($k = 1; $k < count($tabs); $k++)
			if($tabs[$i]['sort_order'] > $tabs[$k]['sort_order'])
			{
				$temp = $tabs[$i];
				$tabs[$i] = $tabs[$k];
				$tabs[$k] = $temp;
			}
		}
		return $tabs;
	}
}
?>