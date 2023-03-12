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

namespace Amici\BannerSlider\Model\ResourceModel;

use Amici\BannerSlider\Api\Data\SliderInterface;
//use Amici\BannerSlider\Model\Slider as Slider;
use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Slider
 * @package Amici\BannerSlider\Model\ResourceModel
 */
class Slider extends AbstractDb
{
    /**
     * Store model
     *
     * @var null|Store
     */
    protected $_store = null;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var EventManager
     */
    private $_eventManager;

    /**
     * Slider Banner table name
     *
     * @var string
     */
    protected $_sliderBannerTable;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param DateTime $dateTime
     * @param EntityManager $entityManager
     * @param MetadataPool $metadataPool
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        DateTime $dateTime,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        \Magento\Framework\Event\Manager $eventManager,
        \Amici\BannerSlider\Model\BannerFactory $bannerFactory,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
        $this->dateTime = $dateTime;
        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;
        $this->_eventManager = $eventManager;
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('amici_bannerslider_slider', 'slider_id');
    }

    /**
     * @inheritDoc
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata(SliderInterface::class)->getEntityConnection();
    }

    /**
     * @param AbstractModel $object
     * @param string $value
     * @param string|null $field
     * @return bool|int|string
     * @throws LocalizedException
     * @throws \Exception
     */
    private function getSliderId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);

        if (!is_numeric($value) && $field === null) {
            $field = 'slider_id';
        } elseif (!$field) {
            $field = $entityMetadata->getIdentifierField();
        }

        $sliderId = $value;
        if ($field != $entityMetadata->getIdentifierField() || $object->getStoreId()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);
            $result = $this->getConnection()->fetchCol($select);
            $sliderId = count($result) ? $result[0] : false;
        }
        return $sliderId;
    }

    /**
     * Load an object
     *
     * @param Slider|AbstractModel $object
     * @param mixed $value
     * @param string $field field to load by (defaults to model id)
     * @return $this
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $sliderId = $this->getSliderId($object, $value, $field);
        if ($sliderId) {
            $this->entityManager->load($object, $sliderId);
        }
        return $this;
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Slider|AbstractModel $object
     * @return Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = [
                Store::DEFAULT_STORE_ID,
                (int)$object->getStoreId(),
            ];
            $select->join(
                ['amici_bannerslider_slider_store' => $this->getTable('amici_bannerslider_slider_store')],
                $this->getMainTable() . '.' . $linkField . ' = amici_bannerslider_slider_store.' . $linkField,
                []
            )
                ->where('status = ?', 1)
                ->where('amici_bannerslider_slider_store.store_id IN (?)', $storeIds)
                ->order('amici_bannerslider_slider_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Retrieve load select with filter by identifier, store and activity
     *
     * @param string $identifier
     * @param int|array $store
     * @param int $isActive
     * @return Select
     */
    protected function _getLoadByIdentifierSelect($identifier, $store, $isActive = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $this->getConnection()->select()
            ->from(['ms' => $this->getMainTable()])
            ->join(
                ['mss' => $this->getTable('amici_bannerslider_slider_store')],
                'ms.' . $linkField . ' = cps.' . $linkField,
                []
            )
            ->where('ms.slider_id = ?', $identifier)
            ->where('mss.store_id IN (?)', $store);

        if ($isActive !== null) {
            $select->where('ms.status = ?', $isActive);
        }

        return $select;
    }

    /**
     *  Check whether page identifier is numeric
     *
     * @param AbstractModel $object
     * @return bool
     */
    protected function isNumericPageIdentifier(AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether page identifier is valid
     *
     * @param AbstractModel $object
     * @return bool
     */
    protected function isValidPageIdentifier(AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);

        $stores = [Store::DEFAULT_STORE_ID, $storeId];
        $select = $this->_getLoadByIdentifierSelect($identifier, $stores, 1);
        $select->reset(Select::COLUMNS)
            ->columns('ms.' . $entityMetadata->getIdentifierField())
            ->order('mss.store_id DESC')
            ->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieves cms page title from DB by passed identifier.
     *
     * @param string $identifier
     * @return string|false
     */
    public function getSliderTitleByIdentifier($identifier)
    {
        $stores = [Store::DEFAULT_STORE_ID];
        if ($this->_store) {
            $stores[] = (int)$this->getStore()->getId();
        }

        $select = $this->_getLoadByIdentifierSelect($identifier, $stores);
        $select->reset(Select::COLUMNS)
            ->columns('ms.title')
            ->order('mss.store_id DESC')
            ->limit(1);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieves cms page title from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getSliderTitleById($id)
    {
        $connection = $this->getConnection();
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);

        $select = $connection->select()
            ->from($this->getMainTable(), 'title')
            ->where($entityMetadata->getIdentifierField() . ' = :slider_id');

        return $connection->fetchOne($select, ['slider_id' => (int)$id]);
    }

    /**
     * Retrieves cms page identifier from DB by passed id.
     *
     * @param string $id
     * @return string|false
     */
    public function getSliderIdentifierById($id)
    {
        $connection = $this->getConnection();
        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);

        $select = $connection->select()
            ->from($this->getMainTable(), 'slider_id')
            ->where($entityMetadata->getIdentifierField() . ' = :slider_id');

        return $connection->fetchOne($select, ['slider_id' => (int)$id]);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $sliderId
     * @return array
     */
    public function lookupStoreIds($sliderId)
    {
        $connection = $this->getConnection();

        $entityMetadata = $this->metadataPool->getMetadata(SliderInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $connection->select()
            ->from(['mss' => $this->getTable('amici_bannerslider_slider_store')], 'store_id')
            ->join(
                ['ms' => $this->getMainTable()],
                'mss.' . $linkField . ' = ms.' . $linkField,
                []
            )
            ->where('ms.' . $entityMetadata->getIdentifierField() . ' = :slider_id');

        return $connection->fetchCol($select, ['slider_id' => (int)$sliderId]);
    }

    /**
     * Set store model
     *
     * @param Store $store
     * @return $this
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->_storeManager->getStore($this->_store);
    }

    /**
     * @inheritDoc
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        return $this;
    }

    /**
     * Save slider banner relation
     *
     * @param \Amici\BannerSlider\Model\Slider $slider
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function saveSliderBanners($slider)
    {
        $slider->setIsChangedBannerList(false);
        $id = $slider->getSliderId();
        /**
         * new slider-banner relationships
         */
        $banners = $slider->getPostedBanners();
        
        /**
         * Example re-save slider
         */
        if ($banners === null) {
            return $this;
        }

        /**
         * old slider-banner relationships
         */
        if (!empty($slider->getBannersPosition())) {
            $oldBanners = $slider->getBannersPosition();
        } else {
            $oldBanners = [];
        }

        $insert = array_diff_key($banners, $oldBanners);
        $delete = array_diff_key($oldBanners, $banners);

        /**
         * Find banner ids which are presented in both arrays
         * and saved before (check $oldBanners array)
         */
        $update = array_intersect_key($banners, $oldBanners);
        $update = array_diff_assoc($update, $oldBanners);
        $connection = $this->getConnection();
        /**
         * Delete banners from slider
         */
        if (!empty($delete)) {
            $cond = ['banner_id IN(?)' => array_keys($delete), 'slider_id=?' => $id];
            $connection->delete($this->getSliderBannerTable(), $cond);
            
            foreach ($delete as $bannerId => $position) {
                $_banner = $this->bannerFactory->create()->load($bannerId);
                $sliders = explode(',', $_banner->getSliderId());
                $updatedSliders = $this->deleteElement($id, $sliders);
                $_banner->setSliderId(implode(',', $updatedSliders))->save();
            }
        }

        /**
         * Add banners to slider
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $bannerId => $position) {
                $data[] = [
                    'slider_id' => (int)$id,
                    'banner_id' => (int)$bannerId,
                    'position' => (int)$position,
                ];

                $_banner = $this->bannerFactory->create()->load($bannerId);
                $sliders = explode(',', $_banner->getSliderId());
                if (!in_array($id, $sliders)) {
                    array_push($sliders, $id);
                    $_banner->setSliderId(implode(',', $sliders))->save();
                }
            }
            $connection->insertMultiple($this->getSliderBannerTable(), $data);
        }

        /**
         * Update banner positions in slider
         */
        if (!empty($update)) {
            foreach ($update as $bannerId => $position) {
                $where = ['slider_id = ?' => (int)$id, 'banner_id = ?' => (int)$bannerId];
                $bind = ['position' => (int)$position];
                $connection->update($this->getSliderBannerTable(), $bind, $where);
            }
        }

        if (!empty($insert) || !empty($delete)) {
            $bannerIds = array_unique(array_merge(array_keys($insert), array_keys($delete)));
            $this->_eventManager->dispatch(
                'amici_slider_change_banners',
                ['slider' => $slider, 'banner_ids' => $bannerIds]
            );
            $slider->setChangedBannerIds($bannerIds);
        }

        if (!empty($insert) || !empty($update) || !empty($delete)) {
            $slider->setIsChangedBannerList(true);

            /**
             * Setting affected banners to slider for third party engine index refresh
             */
            $bannerIds = array_keys($insert + $delete + $update);
            $slider->setAffectedBannerIds($bannerIds);
        }
        return $this;
    }

    /**
     * @param $element
     * @param $array
     * @return mixed
     */
    public function deleteElement($element, &$array)
    {
        $index = array_search($element, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
        return $array;
    }

    /**
     * Get positions of associated to slider products
     *
     * @param \Amici\BannerSlider\Model\Slider $slider
     * @return array
     */
    public function getBannersPosition($slider)
    {
        $select = $this->getConnection()->select()->from(
            $this->getSliderBannerTable(),
            ['banner_id', 'position']
        )->where(
            'slider_id = :slider_id'
        );
        $bind = ['slider_id' => (int)$slider->getId()];

        return $this->getConnection()->fetchPairs($select, $bind);
    }

    /**
     * Slider product table name getter
     *
     * @return string
     */
    public function getSliderBannerTable()
    {
        if (!$this->_sliderBannerTable) {
            $this->_sliderBannerTable = $this->getTable('amici_slider_banner');
        }
        return $this->_sliderBannerTable;
    }
}
