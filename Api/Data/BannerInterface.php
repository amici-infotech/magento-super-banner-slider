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
 * AmiciInfotech BannerSlider interface.
 * @api
 * @since 100.0.2
 */
interface BannerInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BANNER_ID              = 'banner_id';
    const NAME                   = 'name';
    const SLIDER_ID              = 'slider_id';
    const STATUS                 = 'status';
    const IMAGE                  = 'image';
    const IMAGE_ALT              = 'image_alt';
    const CAPTION                = 'caption';
    const CAPTION_ANIMATION      = 'caption_animation';
    const LINK                   = 'link';
    const TARGET                 = 'target';
    const CREATION_TIME          = 'creation_time';
    const UPDATE_TIME            = 'update_time';

    /**#@-*/

    /**
     * Get banner ID
     *
     * @return int|null
     */
    public function getBannerId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get slider ID
     *
     * @return int|null
     */
    public function getSliderId();

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Get image alt
     *
     * @return string
     */
    public function getImageAlt();

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption();

    /**
     * Get caption animation
     *
     * @return string
     */
    public function getCaptionAnimation();

    /**
     * Get link
     *
     * @return string
     */
    public function getLink();
    
    /**
     * Get image target
     *
     * @return int|null
     */
    public function getTarget();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set BannerID
     *
     * @param int $bannerId
     * @return BannerInterface
     */
    public function setBannerId($bannerId);

    /**
     * Set name
     *
     * @param string $name
     * @return BannerInterface
     */
    public function setName($name);

    /**
     * Set SliderID
     *
     * @param int $sliderId
     * @return BannerInterface
     */
    public function setSliderId($sliderId);

    /**
     * Set Status
     *
     * @param int $status
     * @return BannerInterface
     */
    public function setStatus($status);

    /**
     * Set image
     *
     * @param string $image
     * @return BannerInterface
     */
    public function setImage($image);

    /**
     * Set image alt
     *
     * @param string $imageAlt
     * @return BannerInterface
     */
    public function setImageAlt($imageAlt);

    /**
     * Set image caption
     *
     * @param string $caption
     * @return BannerInterface
     */
    public function setCaption($caption);

    /**
     * Set image caption animation
     *
     * @param string $captionAnimation
     * @return BannerInterface
     */
    public function setCaptionAnimation($captionAnimation);

    /**
     * Set image link
     *
     * @param string $link
     * @return BannerInterface
     */
    public function setLink($link);
    
    /**
     * Set image target
     *
     * @param int $target
     * @return BannerInterface
     */
    public function setTarget($target);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BannerInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return BannerInterface
     */
    public function setUpdateTime($updateTime);
}
