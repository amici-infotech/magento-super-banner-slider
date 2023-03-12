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

/**
 * @codeCoverageIgnore
 */
class SliderBannerLink extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \Amici\BannerSlider\Api\Data\SliderBannerLinkInterface
{
    /**#@+
     * Constant for confirmation status
     */
    const KEY_BANNER_ID = 'banner_id';
    const KEY_POSITION = 'position';
    const KEY_SLIDER_ID = 'slider_id';
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->_get(self::KEY_BANNER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->_get(self::KEY_POSITION);
    }

    /**
     * {@inheritdoc}
     */
    public function getSliderId()
    {
        return $this->_get(self::KEY_SLIDER_ID);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::KEY_BANNER_ID, $id);
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition($position)
    {
        return $this->setData(self::KEY_POSITION, $position);
    }

    /**
     * Set slider id
     *
     * @param string $sliderId
     * @return $this
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::KEY_SLIDER_ID, $sliderId);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Amici\BannerSlider\Api\Data\SliderBannerLinkExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Amici\BannerSlider\Api\Data\SliderBannerLinkExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Amici\BannerSlider\Api\Data\SliderBannerLinkExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
