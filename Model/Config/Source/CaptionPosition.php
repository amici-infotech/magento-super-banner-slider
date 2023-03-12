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

/**
 * Class CaptionPosition
 * @package Amici\BannerSlider\Model\Config\Source
 */
class CaptionPosition implements \Magento\Framework\Option\ArrayInterface
{
    const BANNER_POSITION_DEFAULT         = 'default';
    const BANNER_POSITION_TOP_LEFT        = 'top-left';
    const BANNER_POSITION_TOP_MIDDLE      = 'top-middle';
    const BANNER_POSITION_TOP_RIGHT       = 'top-right';
    const BANNER_POSITION_MIDDLE_LEFT     = 'middle-left';
    const BANNER_POSITION_MIDDLE_CENTER   = 'middle-center';
    const BANNER_POSITION_MIDDLE_RIGHT    = 'middle-right';
    const BANNER_POSITION_BOTTOM_LEFT     = 'bottom-left';
    const BANNER_POSITION_BOTTOM_CENTER   = 'bottom-center';
    const BANNER_POSITION_BOTTOM_RIGHT    = 'bottom-right';
    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @param ModuleManager $moduleManager
     * @param SliderFactory $sliderFactory
     */
    public function __construct(
        ModuleManager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * Return array of sliders
     *
     * @return array
     */
    public function toOptionArray()
    {
        $targets = [
            [
                'value' => self::BANNER_POSITION_DEFAULT,
                'label' => __('Default'),
            ],
            [
                'value' => self::BANNER_POSITION_MIDDLE_LEFT,
                'label' => __('Left'),
            ],
            [
                'value' => self::BANNER_POSITION_MIDDLE_CENTER,
                'label' => __('Center'),
            ],
            [
                'value' => self::BANNER_POSITION_MIDDLE_RIGHT,
                'label' => __('Right'),
            ]
        ];
        return $targets;
    }
}
