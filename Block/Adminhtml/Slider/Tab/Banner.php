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

namespace Amici\BannerSlider\Block\Adminhtml\Slider\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;

/**
 * Class Banner
 * @package Amici\BannerSlider\Block\Adminhtml\Slider\Tab\
 */
class Banner extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Amici\BannerSlider\Model\BannerFactory
     */
    protected $bannerFactory;
    
    /**
     * @var \Amici\BannerSlider\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Amici\BannerSlider\Model\BannerFactory $bannerFactory
     * @param \Amici\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Amici\BannerSlider\Model\BannerFactory $bannerFactory,
        \Amici\BannerSlider\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->sliderFactory = $sliderFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('amici_slider_banner');
        $this->setDefaultSort('banner_id');
        $this->setUseAjax(true);
    }

    /**
     * @return array|null
     */
    public function getSlider()
    {
        return $this->sliderFactory->create()->load($this->getRequest()->getParam('slider_id'));
    }

    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ($column->getId() == 'in_slider') {
            $bannerIds = $this->_getSelectedBanners();
            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('banner_id', ['in' => $bannerIds]);
            } elseif (!empty($bannerIds)) {
                $this->getCollection()->addFieldToFilter('banner_id', ['nin' => $bannerIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(['in_slider' => 1]);
        }

        $collection = $this->bannerFactory->create()->getCollection()
        ->addFieldToSelect(
            'name'
        )
        ->addFieldToSelect(
            'banner_id'
        )->addFieldToSelect(
            'image'
        )->joinField(
            'position',
            'amici_slider_banner',
            'position',
            'banner_id = main_table.banner_id',
            'position.slider_id = ' . (int)$this->getRequest()->getParam('slider_id', 0),
            'left'
        );
       
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        if ($storeId > 0) {
            $collection->addStoreFilter($storeId);
        }

        $this->setCollection($collection);

        if ($this->getSlider()->getBannersReadonly()) {
            $bannerIds = $this->_getSelectedBanners();
            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            $this->getCollection()->addFieldToFilter('banner_id', ['in' => $bannerIds]);
        }

        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        if (!$this->getSlider()->getBannersReadonly()) {
            $this->addColumn(
                'in_slider',
                [
                    'type' => 'checkbox',
                    'name' => 'in_slider',
                    'values' => $this->_getSelectedBanners(),
                    'index' => 'banner_id',
                    'header_css_class' => 'col-select col-massaction',
                    'column_css_class' => 'col-select col-massaction'
                ]
            );
        }

        $this->addColumn(
            'banner_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'sortable' => true,
                'index' => 'image',
                'renderer'  => \Amici\BannerSlider\Block\Adminhtml\Slider\Tab\Renderer\BannerImage::class,
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'type' => 'number',
                'index' => 'position',
                'editable' => !$this->getSlider()->getBannersReadonly()
            ]
        );
        
        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('bannerslider/*/Grid', ['_current' => true]);
    }

    /**
     * @return array
     */
    protected function _getSelectedBanners()
    {
        $banners = $this->getRequest()->getPost('selected_banners');

        if ($banners === null) {
            $banners = $this->getSlider()->getBannersPosition();
            return array_keys($banners);
        }
        return $banners;
    }
}
