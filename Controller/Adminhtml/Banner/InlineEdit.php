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

use Magento\Backend\App\Action\Context;
use Amici\BannerSlider\Api\BannerRepositoryInterface as BannerRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Amici\BannerSlider\Api\Data\BannerInterface;

/**
 * Class InlineEdit
 * @package Amici\BannerSlider\Controller\Adminhtml\Banner
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Amici_BannerSlider::banner';

    /**
     * @var \Amici\BannerSlider\Api\BannerRepositoryInterface
     */
    protected $bannerRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param BannerRepository $bannerRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        BannerRepository $bannerRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->bannerRepository = $bannerRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $model = $this->_bannerFactory->create();

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $bannerId) {
                    /** @var \Amici\BannerSlider\Model\Banner $banner */
                    $banner = $this->bannerRepository->getById($bannerId);
                    $model->load($bannerId);
                    try {
                        $model->setData(array_merge($banner->getData(), $postItems[$bannerId]));
                        $model->beforeSave();
                        $this->bannerRepository->save($model);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBannerId(
                            $banner,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add banner title to error message
     *
     * @param BannerInterface $banner
     * @param string $errorText
     * @return string
     */
    public function getErrorWithBannerId(BannerInterface $banner, $errorText)
    {
        return '[Banner ID: ' . $banner->getBannerId() . '] ' . $errorText;
    }
}
