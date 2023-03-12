<?php

namespace Amici\BannerSlider\Model;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Amici\BannerSlider\Api\Data;
use Amici\BannerSlider\Api\SliderRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Amici\BannerSlider\Model\ResourceModel\Slider as ResourceSlider;
use Amici\BannerSlider\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Amici\BannerSlider\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class SliderRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SliderRepository implements SliderRepositoryInterface
{
    /**
     * @var ResourceSlider
     */
    protected $resource;

    /**
     * @var SliderFactory
     */
    protected $sliderFactory;

    /**
     * @var SliderCollectionFactory
     */
    protected $sliderCollectionFactory;

    /**
     * @var Data\SliderSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Amici\BannerSlider\Api\Data\SliderInterfaceFactory
     */
    protected $dataSliderFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var Magento\Catalog\Model\ProductFactory
     */
    private $product;

    /**
     * SliderRepository constructor.
     * @param ResourceSlider $resource
     * @param SliderFactory $sliderFactory
     * @param Data\SliderInterfaceFactory $dataSliderFactory
     * @param SliderCollectionFactory $sliderCollectionFactory
     * @param Data\SliderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param BannerCollectionFactory $bannerCollectionFactory
     * @param ProductFactory $product
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ResourceSlider $resource,
        SliderFactory $sliderFactory,
        Data\SliderInterfaceFactory $dataSliderFactory,
        SliderCollectionFactory $sliderCollectionFactory,
        Data\SliderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        BannerCollectionFactory $bannerCollectionFactory,
        ProductFactory $product,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->resource = $resource;
        $this->sliderFactory = $sliderFactory;
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSliderFactory = $dataSliderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->product = $product;
    }

    /**
     * @param Data\SliderInterface $slider
     * @return Data\SliderInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */

    public function save(\Amici\BannerSlider\Api\Data\SliderInterface $slider)
    {
        if (empty($slider->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $slider->setStoreId($storeId);
        }
        try {
            $this->resource->save($slider);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the slider: %1',
                $exception->getMessage()
            ));
        }
        return $slider;
    }

    /**
     * Load Slider data by given Slider Identity
     *
     * @param string $sliderId
     * @return Slider
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($sliderId)
    {
        $slider = $this->sliderFactory->create();
        $slider->load($sliderId);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with id "%1" does not exist.', $sliderId));
        }
        return $slider;
    }

    /**
     * @inheritdoc
     */

    public function getBannersBySliderId($storeId, SearchCriteriaInterface $searchCriteria)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $sliderId = $this->scopeConfig->getValue('bannerslider/general/home_slider', ScopeInterface::SCOPE_STORE);
        $collection = $this->bannerCollectionFactory->create();
        $collection->addFieldToFilter('main_table.slider_id',['like'=>'%'.$sliderId.'%']);
        $collection->getSelect()->join(
            ['store' => $collection->getTable('amici_bannerslider_slider_store')],
            'store.slider_id = main_table.slider_id',
            ['store.store_id']
        );
        $bannerDetails = [];
        if ($collection->getSize() > 0) {
            foreach ($collection as $bannerItems) {
                $bannerDetails[] = [
                    'banner_id'         => $bannerItems->getBannerId(),
                    'name'              => $bannerItems->getName(),
                    'slider_id'         => $bannerItems->getSliderId(),
                    'link'              => $bannerItems->getLink(),
                    'target'            => $bannerItems->getTarget(),
                    'image'             => $bannerItems['image'] =
                        $mediaUrl . 'bannerslider/' . $bannerItems->getImage(),
                    'image_alt'         => $bannerItems->getImageAlt(),
                    'creation_time'     => $bannerItems->getCreationTime(),
                    'update_time'       => $bannerItems->getUpdateTime(),
                    'status'            => $bannerItems->getStatus()
                ];
            }
        }
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($bannerDetails);
        $searchResult->setTotalCount(count($bannerDetails));

        return $searchResult;
    }


    /**
     * Load Slider data collection by given search criteria
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return \Amici\BannerSlider\Model\ResourceModel\Slider\Collection
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->sliderCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $sliders = [];
        /** @var Slider $sliderModel */
        foreach ($collection as $sliderModel) {
            $sliderData = $this->dataSliderFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $sliderData,
                $sliderModel->getData(),
                \Amici\BannerSlider\Api\Data\SliderInterface::class
            );
            $sliders[] = $this->dataObjectProcessor->buildOutputDataArray(
                $sliderData,
                \Amici\BannerSlider\Api\Data\SliderInterface::class
            );
        }
        $searchResults->setItems($sliders);
        return $searchResults;
    }

    /**
     * Delete Slider
     *
     * @param \Amici\BannerSlider\Api\Data\SliderInterface $slider
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Amici\BannerSlider\Api\Data\SliderInterface $slider)
    {
        try {
            $this->resource->delete($slider);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the slider: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Slider by given Slider Identity
     *
     * @param string $sliderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($sliderId)
    {
        return $this->delete($this->getById($sliderId));
    }
}
