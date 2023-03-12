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
 * Class SliderLinkManagement
 * @package Amici\BannerSlider\Model
 */
class SliderLinkManagement implements \Amici\BannerSlider\Api\SliderLinkManagementInterface
{
    /**
     * @var \Amici\BannerSlider\Api\SliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @var \Amici\BannerSlider\Api\BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @var ResourceModel\Banner
     */
    protected $bannerResource;

    /**
     * @var \Amici\BannerSlider\Api\SliderLinkRepositoryInterface
     */
    protected $sliderLinkRepository;

    /**
     * @var \Amici\BannerSlider\Api\Data\SliderBannerLinkInterfaceFactory
     */
    protected $bannerLinkFactory;

    /**
     * @var \Magento\Framework\Indexer\IndexerRegistry
     */
    protected $indexerRegistry;

    /**
     * SliderLinkManagement constructor.
     *
     * @param \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository
     * @param \Amici\BannerSlider\Api\Data\SliderBannerLinkInterfaceFactory $bannerLinkFactory
     */
    public function __construct(
        \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository,
        \Amici\BannerSlider\Api\Data\SliderBannerLinkInterfaceFactory $bannerLinkFactory
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->bannerLinkFactory = $bannerLinkFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssignedBanners($sliderId)
    {
        $slider = $this->sliderRepository->getById($sliderId);

        /** @var \Amici\BannerSlider\Model\ResourceModel\Banner\Collection $banners */
        $banners = $slider->getBannerCollection();
        $banners->addFieldToSelect('position');

        /** @var \Amici\BannerSlider\Api\Data\SliderBannerLinkInterface[] $links */
        $links = [];

        /** @var \Amici\BannerSlider\Model\Banner $banner */
        foreach ($banners->getItems() as $banner) {
            /** @var \Amici\BannerSlider\Api\Data\SliderBannerLinkInterface $link */
            $link = $this->bannerLinkFactory->create();
            $link->setId($banner->getId())
                ->setPosition($banner->getData('cat_index_position'))
                ->setSliderId($slider->getId());
            $links[] = $link;
        }
        
        return $links;
    }

    /**
     * Assign banner to given sliders
     *
     * @param string $bannerId
     * @param \int[] $sliderIds
     * @return bool
     */
    public function assignBannerToSliders($bannerId, array $sliderIds)
    {
        
        $banner = $this->getBannerRepository()->getById($bannerId);
        $assignedSliders = $this->getBannerResource()->getSliderIds($banner);
        
        if (!empty(array_diff($assignedSliders, $sliderIds)) > 0) {
            foreach (array_diff($assignedSliders, $sliderIds) as $sliderId) {
                $this->getSliderLinkRepository()->deleteByIds($sliderId, $bannerId);
            }
        }
        
        if (!empty(array_diff($sliderIds, $assignedSliders)) > 0) {
            foreach (array_diff($sliderIds, $assignedSliders) as $sliderId) {
                /** @var \Amici\BannerSlider\Api\Data\SliderBannerLinkInterface $sliderBannerLink */
                $sliderBannerLink = $this->bannerLinkFactory->create();
                $sliderBannerLink->setId($bannerId);
                $sliderBannerLink->setSliderId($sliderId);
                $sliderBannerLink->setPosition(0);
                $this->getSliderLinkRepository()->save($sliderBannerLink);
            }
        }
        
        return true;
    }

    /**
     * Retrieve banner repository instance
     *
     * @return \Amici\BannerSlider\Api\BannerRepositoryInterface
     */
    private function getBannerRepository()
    {
        if (null === $this->bannerRepository) {
            $this->bannerRepository = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Api\BannerRepositoryInterface::class);
        }
        return $this->bannerRepository;
    }

    /**
     * Retrieve banner resource instance
     *
     * @return ResourceModel\Banner
     */
    private function getBannerResource()
    {
        if (null === $this->bannerResource) {
            $this->bannerResource = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Model\ResourceModel\Banner::class);
        }
        return $this->bannerResource;
    }

    /**
     * Retrieve slider link repository instance
     *
     * @return \Amici\BannerSlider\Api\SliderLinkRepositoryInterface
     */
    private function getSliderLinkRepository()
    {
        if (null === $this->sliderLinkRepository) {
            $this->sliderLinkRepository = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Api\SliderLinkRepositoryInterface::class);
        }
        return $this->sliderLinkRepository;
    }
}
