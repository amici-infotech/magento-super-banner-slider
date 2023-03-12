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

namespace Amici\BannerSlider\Model;

use Amici\BannerSlider\Api\Data\SliderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Slider
 * @package Amici\BannerSlider\Model
 */
class Slider extends AbstractModel implements SliderInterface, IdentityInterface
{
    /**#@+
     * Slider's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * AmiciInfotech page cache tag
     */
    const CACHE_TAG = 'amici_slider';

    /**
     * @var string
     */
    protected $cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'amici_slider';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Amici\BannerSlider\Model\ResourceModel\Slider::class);
    }
    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : (array)$this->getData('store_id');
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }

    /**
     * Prepare slider's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve slider id
     *
     * @return int
     */
    public function getSliderId()
    {
        return $this->getData(self::SLIDER_ID);
    }

    /**
     * Retrieve slider title
     *
     * @return string
     */
    public function getTitle()
    {
        return (string)$this->getData(self::TITLE);
    }
    
    /**
     * Retrieve slider position
     *
     * @return string
     */
    public function getSliderPosition()
    {
        return (string)$this->getData(self::SLIDER_POSITION);
    }

    /**
     * Retrieve show title
     *
     * @return int
     */
    public function getShowTitle()
    {
        return $this->getData(self::SHOW_TITLE);
    }

    /**
     * Retrieve status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Retrieve slider sort type
     *
     * @return int
     */
    public function getSortType()
    {
        return $this->getData(self::SORT_TYPE);
    }

    /**
     * Retrieve slider style slide
     *
     * @return string
     */
    public function getStyleSlide()
    {
        return (string)$this->getData(self::STYLE_SLIDE);
    }

    /**
     * Retrieve slider default items
     *
     * @return int
     */
    public function getDefaultItems()
    {
        return $this->getData(self::DEFAULT_ITEMS);
    }
    
     /**
      * Retrieve slider caption
      *
      * @return string
      */
    public function getCaption()
    {
        return (string)$this->getData(self::CAPTION);
    }

    /**
     * Retrieve slider speed
     *
     * @return float
     */
    public function getSliderSpeed()
    {
        return $this->getData(self::SLIDER_SPEED);
    }
   
    /**
     * Get creation time
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->getData(self::START_DATE);
    }

    /**
     * Get update time
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->getData(self::END_DATE);
    }

    /**
     * Set SliderID
     *
     * @param int $sliderId
     * @return SliderInterface
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
    }
    
    /**
     * Set Slider title
     *
     * @param string $title
     * @return SliderInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }
    
    /**
     * Set Slider Position
     *
     * @param string $sliderPosition
     * @return SliderInterface
     */
    public function setSliderPosition($sliderPosition)
    {
        return $this->setData(self::SLIDER_POSITION, $sliderPosition);
    }
    
    /**
     * Set Show title
     *
     * @param int $showTitle
     * @return SliderInterface
     */
    public function setShowTitle($showTitle)
    {
        return $this->setData(self::SHOW_TITLE, $showTitle);
    }
    
    /**
     * Set status
     *
     * @param int $status
     * @return SliderInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
    
    /**
     * Set SortType
     *
     * @param int $sortType
     * @return SliderInterface
     */
    public function setSortType($sortType)
    {
        return $this->setData(self::SORT_TYPE, $sortType);
    }
    
    /**
     * Set style slide
     *
     * @param string $styleSlide
     * @return SliderInterface
     */
    public function setStyleSlide($styleSlide)
    {
        return $this->setData(self::STYLE_SLIDE, $styleSlide);
    }
    
    /**
     * Set Default Items
     *
     * @param int $defaultItems
     * @return SliderInterface
     */
    public function setDefaultItems($defaultItems)
    {
        return $this->setData(self::DEFAULT_ITEMS, $defaultItems);
    }
    
    /**
     * Set slider caption
     *
     * @param string $caption
     * @return SliderInterface
     */
    public function setCaption($caption)
    {
        return $this->setData(self::CAPTION, $caption);
    }
    
    /**
     * Set slider speed
     *
     * @param float $sliderSpeed
     * @return SliderInterface
     */
    public function setSliderSpeed($sliderSpeed)
    {
        return $this->setData(self::SLIDER_SPEED, $sliderSpeed);
    }
    
    /**
     * Set creation time
     *
     * @param string $startDate
     * @return SliderInterface
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Set update time
     *
     * @param string $endDate
     * @return SliderInterface
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * @return ScopeConfigInterface
     */
    private function getScopeConfig()
    {
        if (null === $this->scopeConfig) {
            $this->scopeConfig = \Magento\Framework\App\ObjectManager::getInstance()->get(ScopeConfigInterface::class);
        }

        return $this->scopeConfig;
    }

    /**
     * Retrieve array of banner id's for slider
     *
     * The array returned has the following format:
     * array($bannerId => $position)
     *
     * @return array
     */
    public function getBannersPosition()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('banners_position');
        if ($array === null) {
            $array = $this->getResource()->getBannersPosition($this);
            $this->setData('banners_position', $array);
        }
        return $array;
    }

    /**
     * Retrieve array of banner id's for slider
     *
     * The array returned has the following format:
     * array($bannerId => $position)
     *
     * @return array
     */
    public function getCurrentSliderBannersPosition($slider)
    {
        if (!$slider->getSliderId()) {
            return [];
        }

        $array = $slider->getData('banners_position');
        if ($array === null) {
            $array = $this->getResource()->getBannersPosition($slider);
            $slider->setData('banners_position', $array);
        }
        return $array;
    }

    /**
     * save array of banner id's for slider
     *
     * @return array
     */
    public function saveSliderBanners($slider)
    {
        if (!$slider->getId()) {
            return null;
        }

        $updatedSlider = $this->getResource()->saveSliderBanners($slider);
        
        return $updatedSlider;
    }
}
