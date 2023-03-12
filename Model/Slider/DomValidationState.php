<?php

/* AmiciInfotech
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
 * @category AmiciInfotech
 * @package Amici_BannerSlider
 * @copyright Copyright (c) 2023 AmiciInfotech (https://amiciinfotech.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author AmiciInfotech <contact@amiciinfotech.com>
 */
namespace Amici\BannerSlider\Model\Slider;

/**
 * Class DomValidationState
 * @package Amici\BannerSlider\Model\Slider
 */
class DomValidationState implements \Magento\Framework\Config\ValidationStateInterface
{
    /**
     * Retrieve validation state
     * Used in cms page post processor to force validate layout update xml
     *
     * @return boolean
     */
    public function isValidationRequired()
    {
        return true;
    }
}
