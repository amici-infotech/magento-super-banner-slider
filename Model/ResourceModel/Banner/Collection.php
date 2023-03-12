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

namespace Amici\BannerSlider\Model\ResourceModel\Banner;

use Amici\BannerSlider\Api\Data\BannerInterface;
use \Amici\BannerSlider\Model\ResourceModel\AbstractCollection;
use Amici\BannerSlider\Model\Banner;
use Amici\BannerSlider\Model\ResourceModel\Banner as BannerResourceModel;

/**
 * Class Collection
 * @package Amici\BannerSlider\Model\ResourceModel\Banner
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $eventPrefix = 'amici_banner_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $eventObject = 'baner_collection';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Banner::class, BannerResourceModel::class);
        $this->_map['fields']['banner_id'] = 'main_table.banner_id';
    }
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('banner_id', 'name');
    }
}
