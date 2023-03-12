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
namespace Amici\BannerSlider\Controller\Adminhtml\Banner;

use Amici\BannerSlider\Model\Banner;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Amici\BannerSlider\Controller\Adminhtml\Banner
 */
class Save extends \Amici\BannerSlider\Controller\Adminhtml\Banner
{
    /**
     * @var \Amici\BannerSlider\Api\SliderLinkManagementInterface
     */
    protected $sliderLinkManagement;

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['banner_id'])) {
                $data['banner_id'] = null;
            }

            if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                $data['image'] =$data['image'][0]['name'];
                $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                    'Amici\BannerSlider\BannerImageUpload'
                );
                $this->imageUploader->moveFileFromTmp($data['image']);
            } elseif (isset($data['image'][0]['image']) && !isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['image'];
            } else {
                if (isset($data['image']) && isset($data['image']['value'])) {
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } else {
                        $data['image'] = null;
                    }
                }
            }

            /** @var \Amici\BannerSlider\Model\Banner $model */
            $model = $this->_bannerFactory->create();
            $id = $this->getRequest()->getParam('banner_id');
            if ($id) {
                try {
                    $model = $this->bannerRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);
            if (isset($data['slider_id']) && !empty($data['slider_id'])) {
                $model->setSliderId(implode(',', $data['slider_id']));
            }
            
            try {
                $model->beforeSave();
                $this->bannerRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the banner.'));
                $this->dataPersistor->clear('amici_banner');
                if (isset($data['slider_id']) && !empty($data['slider_id'])) {
                    $this->getSliderLinkManagement()->assignBannerToSliders(
                        $model->getId(),
                        $data['slider_id']
                    );
                }
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getBannerId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('amici_banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return \Amici\BannerSlider\Api\SliderLinkManagementInterface
     */
    private function getSliderLinkManagement()
    {
        if (null === $this->sliderLinkManagement) {
            $this->sliderLinkManagement = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Api\SliderLinkManagementInterface::class);
        }
        return $this->sliderLinkManagement;
    }
}
