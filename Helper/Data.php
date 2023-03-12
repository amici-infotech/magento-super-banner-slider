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

namespace Amici\BannerSlider\Helper;

use Amici\BannerSlider\Model\Slider;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Data
 * @package Amici\BannerSlider\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const MEDIA_DIR = 'bannerslider';
    const XML_PATH_RESIZE_ENABLE_FOR_BANEER = 'imageresize/general/banner_enable';

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Amici\BannerSlider\Api\BannerRepositoryInterface $bannerRepository
     */
    protected $bannerRepository;

    /**
     * @var \Amici\BannerSlider\Model\SliderLinkManagement $sliderLinkManagement
     */
    protected $sliderLinkManagement;

    /**
     * @var \Amici\BannerSlider\Model\Slider $sliderModel
     */
    protected $sliderModel;

    /**
     * @var \Amici\BannerSlider\Model\BannerFactory $bannerFactory
     */
    protected $bannerFactory;

    /**
     * 
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Amici\BannerSlider\Model\Slider $sliderModel
     * @param \Amici\BannerSlider\Model\BannerFactory $bannerFactory
     * @param \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository
     * @param \Amici\BannerSlider\Api\BannerRepositoryInterface $bannerRepository
     * @param \Amici\BannerSlider\Model\SliderLinkManagement $sliderLinkManagement
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Amici\BannerSlider\Model\Slider $sliderModel,
        \Amici\BannerSlider\Model\BannerFactory $bannerFactory,
        \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository,
        \Amici\BannerSlider\Api\BannerRepositoryInterface $bannerRepository,
        \Amici\BannerSlider\Model\SliderLinkManagement $sliderLinkManagement,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->backendUrl = $backendUrl;
        $this->sliderModel = $sliderModel;
        $this->bannerFactory = $bannerFactory;
        $this->sliderRepository = $sliderRepository;
        $this->sliderLinkManagement = $sliderLinkManagement;
        $this->bannerRepository = $bannerRepository;
        $this->storeManager = $storeManager;
        $this->date =  $date;
        $this->imageFactory = $imageFactory;
        $this->_filesystem = $filesystem;
        $this->_directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    }

    /**
     * get Base Url Media.
     *
     * @param string $path   [description]
     * @param bool   $secure [description]
     *
     * @return string [description]
     */
    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->storeManager->getStore()
        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
    }

    /**
     * @return string [url]
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * @return int
     */
    public function getCurrentStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * get Slider status at home page
     * @return boolean
     */
    public function getIsExtensionEnabled()
    {
        return $this->getConfig('bannerslider/general/enable');
    }

    /**
     * get Slider status at home page
     * @return boolean
     */
    public function getIsEnabledAtHome()
    {
        return $this->getConfig('bannerslider/general/enable_at_home');
    }

    /**
     * check status
     * @return boolean
     */
    public function getSliderIdAtHome()
    {
        return $this->getConfig('bannerslider/general/home_slider');
    }
    
    /**
     * check status
     * @return boolean
     */
    public function getShowDotsByDefault($storeId = 0)
    {
        return $this->getConfig('bannerslider/slickslider_settings/dots');
    }
    
    /**
     * check status
     * @return boolean
     */
    public function isNav($storeId = 0)
    {
        return $this->getConfig('bannerslider/slickslider_settings/navbar');
    }
    
    
    public function isItHyva()
    {
        return $this->getConfig('bannerslider/general/hyva_theme');
    }


    /**
     * check status
     * @return boolean
     */
    public function isAutoPlay($storeId)
    {
        return $this->getConfig('bannerslider/slickslider_settings/autoplay');
    }
    
    /**
     * check status
     * @return boolean
     */
    public function getSlidesToScrollByDefault($storeId)
    {
        return $this->getConfig('bannerslider/slickslider_settings/slidetoscroll');
    }
    

    /**
     * @return object
     */
    public function getSliderDataById($id)
    {
        return $this->sliderRepository->getById($id);
    }

    /**
     * @return Collection
     */
    public function getBannersCollectionBySliderId($id)
    {
        $slider = $this->getSliderDataById($id);
        $banners = $this->sliderModel->getCurrentSliderBannersPosition($slider);
        $bannersData = [];
        foreach ($banners as $key => $value) {
            $loadedBanner = $this->bannerRepository->getById($key);
            
            if (!$loadedBanner->getStatus()) {
                continue;
            }

            $loadedBanner->setPosition($value);
            $bannersData[] = $loadedBanner;
            usort($bannersData, [$this, "cmp"]);
        }

        return $bannersData;
    }

    /**
     * @return string | boolean
     */
    public function getBannersTarget($targetValue)
    {
        $result = '';
        switch ($targetValue) {
            case \Amici\BannerSlider\Model\Config\Source\Targets::BANNER_TARGET_SAME_TAB:
                $result = false;
                break;
            case \Amici\BannerSlider\Model\Config\Source\Targets::BANNER_TARGET_NEW_TAB:
                $result = '_blank';
                break;
            default:
                $result = false;
                break;
        }
        return $result;
    }

    /**
     * @return boolean
     */
    public function getSliderTimingBySliderId($id)
    {
        $slider = $this->getSliderDataById($id);
        $startDate = $slider->getStartDate();
        $endDate = $slider->getEndDate();
        
        $current = date('Y-m-d h:i:sa');
        $start = $this->date->date($startDate)->format('Y-m-d h:i:sa');
        $end = $this->date->date($endDate)->format('Y-m-d h:i:sa');

        $showSlider = false;
        if ($current > $start && $current < $end) {
            $showSlider = true;
        }
        
        return $showSlider;
    }
    /**
     * @return string [url]
     */
    public function getBannerImageUrl($imageName, $width, $height)
    {
        $resizeIsEnable = $this->scopeConfig->getValue(self::XML_PATH_RESIZE_ENABLE_FOR_BANEER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if ($resizeIsEnable) {        
            /* Real path of image from directory */
            $realPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(self::MEDIA_DIR .'/'.$imageName);
            if (!$this->_directory->isFile($realPath) || !$this->_directory->isExist($realPath)) {
                return $this->getMediaUrl().self::MEDIA_DIR.'/'.$imageName;
            }
            /* Target directory path where our resized image will be save */
            $targetDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(self::MEDIA_DIR . '/resized/'.$width.'x'.$height);
            $pathTargetDir = $this->_directory->getRelativePath($targetDir);
            /* If Directory not available, create it */
            if (!$this->_directory->isExist($pathTargetDir)) {
                $this->_directory->create($pathTargetDir);
            }
            if (!$this->_directory->isExist($pathTargetDir)) {
                return $this->getMediaUrl().self::MEDIA_DIR.'/'.$imageName;
            }

            $image = $this->imageFactory->create();
            $image->open($realPath);
            $image->keepAspectRatio(true);
            $image->resize($width,$height);
            $dest = $targetDir . '/' . pathinfo($realPath, PATHINFO_BASENAME);
            $image->save($dest);
            if ($this->_directory->isFile($this->_directory->getRelativePath($dest))) {
                return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . self::MEDIA_DIR .'/resized/'.$width.'x'.$height.'/'.$imageName;
            }
        } else {
            return $this->getMediaUrl().self::MEDIA_DIR.'/'.$imageName;
       }
    }

    /**
     * @return sorted array
     */
    private function cmp($a, $b)
    {
        return strcmp($a->getPosition(), $b->getPosition());
    }

    /**
     * get Slider id
     * @return int | boolean | string | null | array
     */
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * get Slider Banner Url
     * @return string
     */
    public function getSliderBannerUrl()
    {
        return $this->backendUrl->getUrl('*/*/banners', ['_current' => true]);
    }

    /**
     * get Backend Url
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getBackendUrl($route = '', $params = ['_current' => true])
    {
        return $this->backendUrl->getUrl($route, $params);
    }
}
