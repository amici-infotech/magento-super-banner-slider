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

namespace Amici\BannerSlider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action\Context;
use Amici\BannerSlider\Api\SliderRepositoryInterface;
use Amici\BannerSlider\Model\Slider;
use Amici\BannerSlider\Model\SliderFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Class Save
 * @package Amici\BannerSlider\Controller\Adminhtml\Slider
 */
class Save extends \Magento\Backend\App\AbstractAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Amici_BannerSlider::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Amici\BannerSlider\Model\SliderFactory
     */
    private $sliderFactory;

    /**
     * @var \Amici\BannerSlider\Api\SliderRepositoryInterface
     */
    private $sliderRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param \Amici\BannerSlider\Model\Slider $sliderFactory
     * @param \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        \Amici\BannerSlider\Model\Slider $sliderFactory = null,
        \Amici\BannerSlider\Api\SliderRepositoryInterface $sliderRepository = null
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->sliderFactory = $sliderFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Model\SliderFactory::class);
        $this->sliderRepository = $sliderRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Amici\BannerSlider\Api\SliderRepositoryInterface::class);
        parent::__construct($context);
    }
    
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $slider = $this->_initSlider();
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Slider::STATUS_ENABLED;
            }
            if (empty($data['slider_id'])) {
                $data['slider_id'] = null;
            }

            /** @var \Amici\BannerSlider\Model\Slider $model */
            $model = $this->sliderFactory->create();
            $id = $this->getRequest()->getParam('slider_id');
            if ($id) {
                try {
                    $model = $this->sliderRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This slider no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            
            $model->setData($data);
            $model->setStartDate($data['start_date']);
            $model->setEndDate($data['end_date']);
            
            $this->_eventManager->dispatch(
                'amici_slider_prepare_save',
                ['slider' => $model, 'request' => $this->getRequest()]
            );

            if (!$this->dataProcessor->validate($data)) {
                return $resultRedirect->setPath('*/*/edit', ['slider_id' => $model->getSliderId(), '_current' => true]);
            }

            try {
                $_slider = $this->sliderRepository->save($model);
                if (isset($data['slider_banners'])
                    && is_string($data['slider_banners'])
                    && !$slider->getBannersReadonly()
                ) {
                    $banners = json_decode($data['slider_banners'], true);
                    $_slider->setPostedBanners($banners);
                    $this->_objectManager->get(\Amici\BannerSlider\Model\Slider::class)
                    ->saveSliderBanners($_slider);
                }
                
                if (isset($data['posted_banners'])
                    && is_array($data['posted_banners'])
                ) {
                    $banners = $data['posted_banners'];
                    $_slider->setPostedBanners($banners);
                    $this->_objectManager->get(\Amici\BannerSlider\Model\Slider::class)
                    ->saveSliderBanners($_slider);
                }

                $this->messageManager->addSuccessMessage(__('You saved the slider.'));
                $this->dataPersistor->clear('amici_slider');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['slider_id' =>
                    $model->getSliderId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the slider.'));
            }

            $this->dataPersistor->set('amici_slider', $data);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $this->getRequest()->getParam('slider_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param bool $getRootInstead
     * @return mixed
     */
    public function _initSlider($getRootInstead = false)
    {
        $sliderId = (int)$this->getRequest()->getParam('slider_id', false);
        $storeId = (int)$this->getRequest()->getParam('store_id');
        
        /** @var \Amici\BannerSlider\Model\Slider $model */
        $slider = $this->_objectManager->create(\Amici\BannerSlider\Model\Slider::class);
        $slider->setStoreId($storeId);
        if ($sliderId) {
            $slider->load($sliderId);
        }
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('slider', $slider);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_slider', $slider);
        $this->_objectManager->get(\Magento\Cms\Model\Wysiwyg\Config::class)
            ->setStoreId($this->getRequest()->getParam('store'));
        return $slider;
    }
}
