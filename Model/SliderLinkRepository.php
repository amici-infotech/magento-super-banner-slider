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
 * Copyright (c) 2023 AmiciInfotech (https://amiciinfotech.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author AmiciInfotech <contact@amiciinfotech.com>
 */

namespace Amici\BannerSlider\Model;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class SliderLinkRepository
 * @package Amici\BannerSlider\Model
 */
class SliderLinkRepository implements \Amici\BannerSlider\Api\SliderLinkRepositoryInterface
{
    /**
     * @var SliderRepository
     */
    protected $sliderRepository;

    /**
     * @var \Amici\BannerSlider\Api\BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @param \Amici\BannerSlider\Model\SliderFactory $sliderFactory
     * @param \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository
     * @param \Amici\BannerSlider\Api\BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        \Amici\BannerSlider\Model\SliderFactory $sliderFactory,
        \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository,
        \Amici\BannerSlider\Api\BannerRepositoryInterface $bannerRepository
    ) {
        $this->sliderFactory = $sliderFactory;
        $this->sliderRepository = $sliderRepository;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Amici\BannerSlider\Api\Data\SliderBannerLinkInterface $bannerLink)
    {
        $slider = $this->sliderFactory->create()->load($bannerLink->getSliderId());
        $banner = $this->bannerRepository->getById($bannerLink->getId());
        $bannerPositions = $slider->getBannersPosition();
        $bannerPositions[$banner->getId()] = $bannerLink->getPosition();
        $slider->setPostedBanners($bannerPositions);
        
        try {
            $slider->saveSliderBanners($slider);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __(
                    'Could not save banner "%1" with position %2 to slider %3',
                    $banner->getBannerrId(),
                    $bannerLink->getPosition(),
                    $slider->getSliderId()
                ),
                $e
            );
        }
        return true;
    }

    /**
     * @param \Amici\BannerSlider\Api\Data\SliderBannerLinkInterface $bannerLink
     * @return bool
     * @throws CouldNotSaveException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Amici\BannerSlider\Api\Data\SliderBannerLinkInterface $bannerLink)
    {
        return $this->deleteByIds($bannerLink->getSliderId(), $bannerLink->getId());
    }

    /**
     * @param int $sliderId
     * @param int $id
     * @return bool|null
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteByIds($sliderId, $id)
    {
        if (empty($sliderId)) {
            return null;
        }
        $slider = $this->sliderFactory->create()->load($sliderId);

        if (!$slider->getId()) {
            return null;
        }
        $banner = $this->bannerRepository->getById($id);
        $bannerPositions = $slider->getBannersPosition();

        $bannerID = $banner->getBannerId();
        if (!isset($bannerPositions[$bannerID])) {
            throw new InputException(__('Slider does not contain specified banner'));
        }
        $backupPosition = $bannerPositions[$bannerID];
        unset($bannerPositions[$bannerID]);
        $slider->setPostedBanners($bannerPositions);
        try {
            $slider->saveSliderBanners($slider);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __(
                    'Could not save banner "%banner" with position %position to slider %slider',
                    [
                        "banner" => $banner->getBannerId(),
                        "position" => $backupPosition,
                        "slider" => $slider->getSliderId()
                    ]
                ),
                $e
            );
        }
        return true;
    }
}
