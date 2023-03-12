<?php

/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Amici\BannerSlider\Controller\Adminhtml\Slider;

/**
 * Class Grid
 * @package Amici\BannerSlider\Controller\Adminhtml\Slider
 */
class Grid extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Grid Action
     * Display list of products related to current slider
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $slider = $this->_initSlider(true);
        if (!$slider) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('bannerslider/*/', ['_current' => true, 'id' => null]);
        }
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Amici\BannerSlider\Block\Adminhtml\Slider\Tab\Banner::class,
                'md.banner.grid'
            )->toHtml()
        );
    }

    /**
     * @param bool $getRootInstead
     * @return mixed
     */
    public function _initSlider($getRootInstead = false)
    {
        $sliderId = (int)$this->getRequest()->getParam('slider_id', false);
        $storeId = (int)$this->getRequest()->getParam('store_id');
        
        /** @var \Amici\BannerSlider\Model\Slider $model */
        $slider = $this->_objectManager->create(\Amici\BannerSlider\Model\Slider::class);
        $slider->setStoreId($storeId);

        if ($sliderId) {
            $slider->load($sliderId);
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('slider', $slider);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_slider', $slider);
        $this->_objectManager->get(\Magento\Cms\Model\Wysiwyg\Config::class)
            ->setStoreId($this->getRequest()->getParam('store'));
        return $slider;
    }
}
