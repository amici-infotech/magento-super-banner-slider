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

namespace Amici\BannerSlider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SliderRepositoryInterface
{
    /**
     * Save slider.
     *
     * @param \Amici\BannerSlider\Api\Data\SliderInterface $page
     * @return \Amici\BannerSlider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Amici\BannerSlider\Api\Data\SliderInterface $page);

    /**
     * Retrieve slider.
     *
     * @param int $sliderId
     * @return \Amici\BannerSlider\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sliderId);

    /**
     * Retrieve slider matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Amici\BannerSlider\Api\Data\SliderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete slider.
     *
     * @param \Amici\BannerSlider\Api\Data\SliderInterface $page
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Amici\BannerSlider\Api\Data\SliderInterface $page);

    /**
     * Delete slider by ID.
     *
     * @param int $sliderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sliderId);

    /**
     * @param int $storeId
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Amici\BannerSlider\Api\Data\BannerSearchResultsInterface
     */
    public function getBannersBySliderId($storeId, SearchCriteriaInterface $searchCriteria);
    
}
