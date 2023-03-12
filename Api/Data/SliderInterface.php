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

namespace Amici\BannerSlider\Api\Data;

/**
 * AmiciInfotech slider interface.
 * @api
 * @since 100.0.2
 */
interface SliderInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const SLIDER_ID              = 'slider_id';
    const TITLE                  = 'title';
    const SLIDER_POSITION        = 'slider_position';
    const SHOW_TITLE             = 'show_title';
    const STATUS                 = 'status';
    const SORT_TYPE              = 'sort_type';
    const STYLE_SLIDE            = 'style_slide';
    const DEFAULT_ITEMS          = 'default_items';
    const SLIDER_SPEED           = 'slider_speed';
    const CAPTION                = 'caption';
    const START_DATE             = 'start_date';
    const END_DATE               = 'end_date';

    /**#@-*/

    /**
     * Get slider ID
     *
     * @return int|null
     */
    public function getSliderId();

    /**
     * Get slider title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get slider position
     *
     * @return string
     */
    public function getSliderPosition();

    /**
     * Show slider title
     *
     * @return int|null
     */
    public function getShowTitle();

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get sort type
     *
     * @return int|null
     */
    public function getSortType();

    /**
     * Get slider style slide
     *
     * @return string
     */
    public function getStyleSlide();

    /**
     * Get slider default items
     *
     * @return int|null
     */
    public function getDefaultItems();
    
    /**
     * Get slider speed
     *
     * @return float
     */
    public function getSliderSpeed();

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption();
    /**
     * Get start date
     *
     * @return string|null
     */
    public function getStartDate();

    /**
     * Get end date
     *
     * @return string|null
     */
    public function getEndDate();

    /**
     * Set SldierID
     *
     * @param int $sliderId
     * @return SliderInterface
     */
    public function setSliderId($sliderId);

    /**
     * Set slider title
     *
     * @param string $title
     * @return SliderInterface
     */
    public function setTitle($title);

    /**
     * Set Slider Position
     *
     * @param string $sliderPosition
     * @return SliderInterface
     */
    public function setSliderPosition($sliderPosition);
    
    /**
     * Set Show title
     *
     * @param int $showTitle
     * @return SliderInterface
     */
    public function setShowTitle($showTitle);

    /**
     * Set Status
     *
     * @param int $status
     * @return SliderInterface
     */
    public function setStatus($status);

    /**
     * Set SortType
     *
     * @param int $sortType
     * @return SliderInterface
     */
    public function setSortType($sortType);
    
    /**
     * Set style slide
     *
     * @param string $styleSlide
     * @return SliderInterface
     */
    public function setStyleSlide($styleSlide);

     /**
      * Set Default Items
      *
      * @param int $defaultItems
      * @return SliderInterface
      */
    public function setDefaultItems($defaultItems);

    /**
     * Set slider caption
     *
     * @param string $caption
     * @return SliderInterface
     */
    public function setCaption($caption);
    
    /**
     * Set slider speed
     *
     * @param float $sliderSpeed
     * @return SliderInterface
     */
    public function setSliderSpeed($sliderSpeed);

    /**
     * Set start date
     *
     * @param string $startDate
     * @return \Amici\BannerSlider\Api\Data\SliderInterface
     */
    public function setStartDate($startDate);

    /**
     * Set end date
     *
     * @param string $endDate
     * @return \Amici\BannerSlider\Api\Data\SliderInterface
     */
    public function setEndDate($endDate);
}
