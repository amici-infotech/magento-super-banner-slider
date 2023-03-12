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

namespace Amici\BannerSlider\Block\Adminhtml\Slider;

/**
 * Class AssignBanners
 * @package Amici\BannerSlider\Block\Adminhtml\Slider
 */
class AssignBanners extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'slider/assign_banners.phtml';

    /**
     * @var \Amici\BannerSlider\Block\Adminhtml\Slider\Tab\Grid
     */
    protected $bannerGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;
    
    /**
     * @var \Amici\BannerSlider\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * AssignProducts constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Amici\BannerSlider\Model\SliderFactory $sliderFactory,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBannerGrid()
    {
        if (null === $this->bannerGrid) {
            $this->bannerGrid = $this->getLayout()->createBlock(
                \Amici\BannerSlider\Block\Adminhtml\Slider\Tab\Banner::class,
                'md.admin.banner.grid'
            );
        }
        return $this->bannerGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBannerGrid()->toHtml();
    }

    /**
     * @return string
     */
    public function getBannersJson()
    {
        $banners = $this->getSlider()->getBannersPosition();

        if (!empty($banners)) {
            return $this->jsonEncoder->encode($banners);
        }

        return '{}';
    }
    /**
     * Retrieve current category instance
     *
     * @return array|null
     */
    public function getSlider()
    {
        return $this->sliderFactory->create()->load($this->getRequest()->getParam('slider_id'));
    }
}
