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

namespace Amici\BannerSlider\Model\Config\Source;

use Magento\Framework\Module\Manager as ModuleManager;
use Amici\BannerSlider\Model\SliderFactory;

/**
 * Class Sliders
 * @package Amici\BannerSlider\Model\Config\Source
 */
class Sliders implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @var GroupRepositoryInterface
     */
    protected $sliderFactory;

    /**
     * @param ModuleManager $moduleManager
     * @param SliderFactory $sliderFactory
     */
    public function __construct(
        ModuleManager $moduleManager,
        SliderFactory $sliderFactory
    ) {
        $this->moduleManager = $moduleManager;
        $this->sliderFactory = $sliderFactory;
    }

    /**
     * Return array of sliders
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->moduleManager->isEnabled('Amici_BannerSlider')) {
            return [];
        }
        $sliders[] =
            [
                'label' => __('-- Select Slider(s) --'),
                'value' => 0,
            ];

        /** @var GroupInterface[] $groups */
        $sliderCollection = $this->sliderFactory->create()->getCollection()->addFieldToSelect(
            'status'
        )
        ->addFieldToSelect(
            'title'
        )
        ->addFieldToSelect(
            'slider_id'
        )->addFieldToFilter('status', 1);
        
        foreach ($sliderCollection as $slider) {
            $sliders[] = [
                'label' => $slider->getTitle(),
                'value' => $slider->getSliderId(),
            ];
        }

        return $sliders;
    }
}
