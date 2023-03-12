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
 * Class Targets
 * @package Amici\BannerSlider\Model\Config\Source
 */
class Targets implements \Magento\Framework\Option\ArrayInterface
{
    const BANNER_TARGET_SAME_TAB = 0;
    const BANNER_TARGET_NEW_TAB = 1;

    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @param ModuleManager $moduleManager
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
        if (!$this->moduleManager->isEnabled('Amici_BannerSlider')) {
            return [];
        }
        $targets = [
            [
                'value' => self::BANNER_TARGET_SAME_TAB,
                'label' => __('Same Tab'),
            ],
            [
                'value' => self::BANNER_TARGET_NEW_TAB,
                'label' => __('New Tab'),
            ]
        ];

        return $targets;
    }
}
