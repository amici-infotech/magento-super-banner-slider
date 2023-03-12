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

use Amici\BannerSlider\Api\Data\BannerInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * AmiciInfotech block model
 *
 */
class Banner extends AbstractModel implements BannerInterface, IdentityInterface
{
    /**
     * AmiciInfotech block cache tag
     */
    const CACHE_TAG = 'amici_bannerslider';

    /**#@+
     * Block's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const BANNER_TARGET_SAME_TAB = 0;
    const BANNER_TARGET_NEW_TAB = 1;

    /**#@-*/

    /**#@-*/
    protected $cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $eventPrefix = 'amici_banner';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Amici\BannerSlider\Model\ResourceModel\Banner::class);
    }

    /**
     * Prevent blocks recursion
     *
     * @return AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Retrieve banner id
     *
     * @return int
     */
    public function getBannerId()
    {
        return $this->getData(self::BANNER_ID);
    }

    /**
     * Retrieve banner name
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->getData(self::NAME);
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
     * Retrieve status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Retrieve banner image
     *
     * @return string
     */
    public function getImage()
    {
        return (string)$this->getData(self::IMAGE);
    }

    /**
     * Retrieve banner image alt
     *
     * @return string
     */
    public function getImageAlt()
    {
        return (string)$this->getData(self::IMAGE_ALT);
    }

    /**
     * Retrieve banner image caption
     *
     * @return string
     */
    public function getCaption()
    {
        return (string)$this->getData(self::CAPTION);
    }

    /**
     * Retrieve banner caption animation
     *
     * @return string
     */
    public function getCaptionAnimation()
    {
        return (string)$this->getData(self::CAPTION_ANIMATION);
    }

    /**
     * Retrieve banner link
     *
     * @return string
     */
    public function getLink()
    {
        return (string)$this->getData(self::LINK);
    }
    
    /**
     * Retrieve banner target
     *
     * @return int
     */
    public function getTarget()
    {
        return $this->getData(self::TARGET);
    }

    /**
     * Retrieve block creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve block update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set BannerID
     *
     * @param int $bannerId
     * @return BannerInterface
     */
    public function setBannerId($bannerId)
    {
        return $this->setData(self::BANNER_ID, $bannerId);
    }

    /**
     * Set banner name
     *
     * @param string $name
     * @return BannerInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set SliderId
     *
     * @param int $sliderId
     * @return BannerInterface
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return BannerInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set image
     *
     * @param string $image
     * @return BannerInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set image alt
     *
     * @param string $imageAlt
     * @return BannerInterface
     */
    public function setImageAlt($imageAlt)
    {
        return $this->setData(self::IMAGE_ALT, $imageAlt);
    }

    /**
     * Set image caption
     *
     * @param string $caption
     * @return BannerInterface
     */
    public function setCaption($caption)
    {
        return $this->setData(self::CAPTION, $caption);
    }

    /**
     * Set image caption animation
     *
     * @param string $captionAnimation
     * @return BannerInterface
     */
    public function setCaptionAnimation($captionAnimation)
    {
        return $this->setData(self::CAPTION_ANIMATION, $captionAnimation);
    }

    /**
     * Set image link
     *
     * @param string $link
     * @return BannerInterface
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }
    
    /**
     * Set image target
     *
     * @param int $target
     * @return BannerInterface
     */
    public function setTarget($target)
    {
        return $this->setData(self::TARGET, $target);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BannerInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return BannerInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Prepare banner's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    
    /**
     * Prepare banner's targets.
     *
     * @return array
     */
    public function getAvailableTargets()
    {
        return [self::BANNER_TARGET_SAME_TAB => __('Same Tab'), self::BANNER_TARGET_NEW_TAB => __('New Tab')];
    }

    /**
     * save array of banner id's for slider
     *
     * @return array
     */
    public function saveBannerToSlider($banner)
    {
        if (!$banner->getId()) {
            return null;
        }

        $updatedSlider = $this->getResource()->saveBannerToSlider($banner);

        return $updatedSlider;
    }
}
