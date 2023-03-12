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
 * @copyright Copyright (c) 2023 AmiciInfotech (https://amiciinfotech.com/)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author AmiciInfotech <contact@amiciinfotech.com>
 */

namespace Amici\BannerSlider\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Context;
use Amici\BannerSlider\Api\SliderRepositoryInterface;
use Magento\framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @param Context $context
     * @param SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        Context $context,
        SliderRepositoryInterface $sliderRepository
    ) {
        $this->context = $context;
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSliderId()
    {
        try {
            return $this->sliderRepository->getById(
                $this->context->getRequest()->getParam('slider_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
