<?php

/**
 * AmiciInfotech
 * Copyright (C) 2023 AmiciInfotech <contact@amiciinfotech.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    AmiciInfotech
 * @package     Amici_BannerSlider
 * @copyright   Copyright (c) 2023 AmiciInfotech (https://amiciinfotech.com/)
 * @license     https://amiciinfotech.com/license-agreement.html
 * @author      AmiciInfotech <contact@amiciinfotech.com>
 */

namespace Amici\BannerSlider\Block;

/**
 * Class BannerSlider
 * @package Amici\BannerSlider\Block
 */
class BannerSlider extends \Magento\Framework\View\Element\Template
{
    /**
     * @var bool
     */
    protected $isApplied = false;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var int
     */
    protected $parentSliderId = 0;
    
    /**
     * @var Model\BannerSlider
     */
    protected $sliderModel;
    
    /**
     *
     * @var Model\SliderFactory
     */
    protected $sliderFactory;
    
    /**
     * @var \Amici\BannerSlider\Helper\Data
     */
    protected $helper;
    
    /**
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Registry $registry
     * @param \Amici\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Magento\Cms\Model\Template\FilterProvider $templateProcessor
     * @param \Amici\BannerSlider\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
        \Amici\BannerSlider\Model\SliderFactory $sliderFactory,
        \Magento\Cms\Model\Template\FilterProvider $templateProcessor,
        \Amici\BannerSlider\Helper\Data $helper,
        array $data = []
    ) {
        $this->objectManager = $objectManager;
        $this->coreRegistry = $registry;
        $this->sliderFactory = $sliderFactory;
        $this->templateProcessor = $templateProcessor;
        $this->helper = $helper;
        parent::__construct($context, $data);
        $this->checkSliderId();
        $this->sliderModel = $this->objectManager->create(\Amici\BannerSlider\Model\Slider::class)
        ->load($this->getSliderId());
        $this->applyTemplate();
    }

    public function checkSliderId()
    {
        if (!empty($this->getSliderId())) {
            return true;
        }
        
        if ($this->_request->getFullActionName() == 'cms_index_index') {
            if ($this->helper->getIsEnabledAtHome() && $this->helper->getIsExtensionEnabled()) {
                $id = $this->helper->getSliderIdAtHome();
                $this->setSliderId($id);
            } else {
                return true;
            }
        }

        return true;
    }

    public function filterOutputHtml($string)
    {
        return $this->templateProcessor->getPageFilter()->filter($string);
    }

    public function getSlider()
    {
        return $this->sliderModel;
    }

    public function applyTemplate()
    {
        if ($this->sliderModel->getStatus() == 1 && $this->helper->getIsExtensionEnabled()) {
            if (!$this->helper->isItHyva()) {
                $this->setTemplate('Amici_BannerSlider::sliders/luma-slider.phtml');
            } else if($this->helper->isItHyva()){
                $this->setTemplate('Amici_BannerSlider::hyva/slider-main.phtml');
            }
        }
    }

    /**
     * @return null
     */
    public function getSliderTitle()
    {
        if ($this->sliderModel->getStatus() == 1 && $this->helper->getIsExtensionEnabled()) {
            return $this->sliderModel->getTitle();
        }
        
        return null;
    }

    /**
     * @return \Magento\Framework\Phrase|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _toHtml()
    {
        $id = $this->getSliderId();
        if ($this->_request->getFullActionName() == 'cms_index_index') {
            if ($this->helper->getIsEnabledAtHome()) {
                $id = $this->helper->getSliderIdAtHome();
            } else {
                return parent::_toHtml();
            }
        }
        if (!$id) {
            return __('Please specify the Slider ID');
        }
        return parent::_toHtml();
    }

    /**
     * Prepare global layout
     * @return $this
     */
    protected function _prepareLayout()
    {
        if ($this->helper->getIsEnabledAtHome() && $this->helper->getIsExtensionEnabled()) {
            $this->pageConfig->addBodyClass('amici-banner-slider-index');
        }
        return parent::_prepareLayout();
    }

    /**
     * @return \Amici\BannerSlider\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }
}
