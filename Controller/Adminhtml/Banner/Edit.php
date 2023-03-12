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

namespace Amici\BannerSlider\Controller\Adminhtml\Banner;

/**
 * Class Edit
 * @package Amici\BannerSlider\Controller\Adminhtml\Banner
 */
class Edit extends \Amici\BannerSlider\Controller\Adminhtml\Banner
{
    /**
     * Edit Banner
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        
        $model = $this->_bannerFactory->create();
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Banner no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        
        $this->coreRegistry->register('amici_banner', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );
        
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Banner'));
        
        return $resultPage;
    }
}
