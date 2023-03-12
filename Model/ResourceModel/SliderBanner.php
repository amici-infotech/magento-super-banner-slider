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

namespace Amici\BannerSlider\Model\ResourceModel;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class SliderBanner
 */
class SliderBanner extends AbstractDb
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $eventPrefix = 'amici_slider_banner_resource';

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('amici_slider_banner', 'entity_id');
    }
}
