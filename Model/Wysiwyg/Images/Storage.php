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

namespace Amici\BannerSlider\Model\Wysiwyg\Images;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Amici\BannerSlider\Helper\Wysiwyg\Images;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 * @package Amici\BannerSlider\Model\Wysiwyg\Images
 */
class Storage extends \Magento\Framework\DataObject
{
    const DIRECTORY_NAME_REGEXP = '/^[a-z0-9\-\_]+$/si';

    const THUMBS_DIRECTORY_NAME = '.thumbs';

    const THUMB_PLACEHOLDER_PATH_SUFFIX = 'Amici_BannerSlider::images/placeholder_thumbnail.jpg';

    /**
     * Config object
     *
     * @var \Magento\Framework\App\Config\Element
     */
    protected $config;

    /**
     * Config object as array
     *
     * @var array
     */
    protected $configAsArray;

    /**
     * @var \Magento\Framework\Filesystem\Directory\Write
     */
    protected $directory;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * Core file storage database
     *
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $coreFileStorageDb = null;

    /**
     * Cms wysiwyg images
     *
     * @var \Amici\BannerSlider\Helper\Wysiwyg\Images
     */
    protected $cmsWysiwygImages = null;

    /**
     * @var array
     */
    protected $resizeParameters;

    /**
     * @var array
     */
    protected $extensions;

    /**
     * @var array
     */
    protected $dirs;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $session;

    /**
     * Directory database factory
     *
     * @var \Magento\MediaStorage\Model\File\Storage\Directory\DatabaseFactory
     */
    protected $directoryDatabaseFactory;

    /**
     * Storage database factory
     *
     * @var \Magento\MediaStorage\Model\File\Storage\DatabaseFactory
     */
    protected $storageDatabaseFactory;

    /**
     * Storage file factory
     *
     * @var \Magento\MediaStorage\Model\File\Storage\FileFactory
     */
    protected $storageFileFactory;

    /**
     * Storage collection factory
     *
     * @var \Amici\BannerSlider\Model\Wysiwyg\Images\Storage\CollectionFactory
     */
    protected $storageCollectionFactory;

    /**
     * Uploader factory
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * Construct
     *
     * @param \Magento\Backend\Model\Session $session
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Amici\BannerSlider\Helper\Wysiwyg\Images $cmsWysiwygImages
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDb
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Image\AdapterFactory $imageFactory
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Amici\BannerSlider\Model\Wysiwyg\Images\Storage\CollectionFactory $storageCollectionFactory
     * @param \Magento\MediaStorage\Model\File\Storage\FileFactory $storageFileFactory
     * @param \Magento\MediaStorage\Model\File\Storage\DatabaseFactory $storageDatabaseFactory
     * @param \Magento\MediaStorage\Model\File\Storage\Directory\DatabaseFactory $directoryDatabaseFactory
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param array $resizeParameters
     * @param array $extensions
     * @param array $dirs
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Model\Session $session,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Cms\Helper\Wysiwyg\Images $cmsWysiwygImages,
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDb,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Amici\BannerSlider\Model\Wysiwyg\Images\Storage\CollectionFactory $storageCollectionFactory,
        \Magento\MediaStorage\Model\File\Storage\FileFactory $storageFileFactory,
        \Magento\MediaStorage\Model\File\Storage\DatabaseFactory $storageDatabaseFactory,
        \Magento\MediaStorage\Model\File\Storage\Directory\DatabaseFactory $directoryDatabaseFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        array $resizeParameters = [],
        array $extensions = [],
        array $dirs = [],
        array $data = []
    ) {
        $this->session = $session;
        $this->backendUrl = $backendUrl;
        $this->cmsWysiwygImages = $cmsWysiwygImages;
        $this->coreFileStorageDb = $coreFileStorageDb;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->imageFactory = $imageFactory;
        $this->assetRepo = $assetRepo;
        $this->storageCollectionFactory = $storageCollectionFactory;
        $this->storageFileFactory = $storageFileFactory;
        $this->storageDatabaseFactory = $storageDatabaseFactory;
        $this->directoryDatabaseFactory = $directoryDatabaseFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->resizeParameters = $resizeParameters;
        $this->extensions = $extensions;
        $this->dirs = $dirs;
        parent::__construct($data);
    }

    /**
     * Create sub directories if DB storage is used
     *
     * @param string $path
     * @return void
     */
    protected function createSubDirectories($path)
    {
        if ($this->coreFileStorageDb->checkDbUsage()) {
            /** @var \Magento\MediaStorage\Model\File\Storage\Directory\Database $subDirectories */
            $subDirectories = $this->directoryDatabaseFactory->create();
            $directories = $subDirectories->getSubdirectories($path);
            foreach ($directories as $directory) {
                $fullPath = rtrim($path, '/') . '/' . $directory['name'];
                $this->directory->create($fullPath);
            }
        }
    }

    /**
     * Prepare and get conditions for exclude directories
     *
     * @return array
     */
    protected function getConditionsForExcludeDirs()
    {
        $conditions = ['reg_exp' => [], 'plain' => []];

        if ($this->dirs['exclude']) {
            foreach ($this->dirs['exclude'] as $dir) {
                $conditions[!empty($dir['regexp']) ? 'reg_exp' : 'plain'][$dir['name']] = true;
            }
        }

        // "include" section takes precedence and can revoke directory exclusion
        if ($this->dirs['include']) {
            foreach ($this->dirs['include'] as $dir) {
                unset($conditions['reg_exp'][$dir['name']], $conditions['plain'][$dir['name']]);
            }
        }

        return $conditions;
    }

    /**
     * Remove excluded directories from collection
     *
     * @param \Magento\Framework\Data\Collection\Filesystem $collection
     * @param array $conditions
     * @return \Magento\Framework\Data\Collection\Filesystem
     */
    protected function removeItemFromCollection($collection, $conditions)
    {
        $regExp = $conditions['reg_exp'] ? '~' . implode('|', array_keys($conditions['reg_exp'])) . '~i' : null;
        $storageRootLength = strlen($this->cmsWysiwygImages->getStorageRoot());

        foreach ($collection as $key => $value) {
            $rootChildParts = explode('/', substr($value->getFilename(), $storageRootLength));

            if (array_key_exists($rootChildParts[1], $conditions['plain'])
                || ($regExp && preg_match($regExp, $value->getFilename()))) {
                $collection->removeItemByKey($key);
            }
        }

        return $collection;
    }

    /**
     * Return one-level child directories for specified path
     *
     * @param string $path Parent directory path
     * @return \Magento\Framework\Data\Collection\Filesystem
     */
    public function getDirsCollection($path)
    {
        $this->createSubDirectories($path);

        $collection = $this->getCollection($path)
            ->setCollectDirs(true)
            ->setCollectFiles(false)
            ->setCollectRecursively(false);

        $conditions = $this->getConditionsForExcludeDirs();

        return $this->removeItemFromCollection($collection, $conditions);
    }

    /**
     * Return files
     *
     * @param string $path Parent directory path
     * @param string $type Type of storage, e.g. image, media etc.
     * @return \Magento\Framework\Data\Collection\Filesystem
     */
    public function getFilesCollection($path, $type = null)
    {
        if ($this->coreFileStorageDb->checkDbUsage()) {
            $files = $this->storageDatabaseFactory->create()->getDirectoryFiles($path);

            /** @var \Magento\MediaStorage\Model\File\Storage\File $fileStorageModel */
            $fileStorageModel = $this->storageFileFactory->create();
            foreach ($files as $file) {
                $fileStorageModel->saveFile($file);
            }
        }

        $collection = $this->getCollection(
            $path
        )->setCollectDirs(
            false
        )->setCollectFiles(
            true
        )->setCollectRecursively(
            false
        )->setOrder(
            'mtime',
            \Magento\Framework\Data\Collection::SORT_ORDER_ASC
        );

        // Add files extension filter
        if ($allowed = $this->getAllowedExtensions($type)) {
            $collection->setFilesFilter('/\.(' . implode('|', $allowed) . ')$/i');
        }

        // prepare items
        foreach ($collection as $item) {
            $item->setId($this->cmsWysiwygImages->idEncode($item->getBasename()));
            $item->setName($item->getBasename());
            $item->setShortName($this->_cmsWysiwygImages->getShortFilename($item->getBasename()));
            $item->setUrl($this->cmsWysiwygImages->getCurrentUrl() . $item->getBasename());

            if ($this->isImage($item->getBasename())) {
                $thumbUrl = $this->getThumbnailUrl($item->getFilename(), true);
                // generate thumbnail "on the fly" if it does not exists
                if (!$thumbUrl) {
                    $thumbUrl = $this->backendUrl->getUrl('cms/*/thumbnail', ['file' => $item->getId()]);
                }
                // phpcs:ignore Generic.PHP.NoSilencedErrors
                $size = @getimagesize($item->getFilename());

                if (is_array($size)) {
                    $item->setWidth($size[0]);
                    $item->setHeight($size[1]);
                }
            } else {
                $thumbUrl = $this->assetRepo->getUrl(self::THUMB_PLACEHOLDER_PATH_SUFFIX);
            }

            $item->setThumbUrl($thumbUrl);
        }

        return $collection;
    }

    /**
     * Storage collection
     *
     * @param string $path Path to the directory
     * @return \Amici\BannerSlider\Model\Wysiwyg\Images\Storage\Collection
     */
    public function getCollection($path = null)
    {
        /** @var \Amici\BannerSlider\Model\Wysiwyg\Images\Storage\Collection $collection */
        $collection = $this->storageCollectionFactory->create();
        if ($path !== null) {
            $collection->addTargetDir($path);
        }
        return $collection;
    }

    /**
     * Create new directory in storage
     *
     * @param string $name New directory name
     * @param string $path Parent directory path
     * @return array New directory info
     * @throws LocalizedException
     */
    public function createDirectory($name, $path)
    {
        if (!preg_match(self::DIRECTORY_NAME_REGEXP, $name)) {
            throw new LocalizedException(
                __('Please rename the folder using only letters, numbers, underscores and dashes.')
            );
        }

        $relativePath = $this->directory->getRelativePath($path);
        if (!$this->directory->isDirectory($relativePath) || !$this->directory->isWritable($relativePath)) {
            $path = $this->cmsWysiwygImages->getStorageRoot();
        }

        $newPath = $path . '/' . $name;
        $relativeNewPath = $this->directory->getRelativePath($newPath);
        if ($this->directory->isDirectory($relativeNewPath)) {
            throw new LocalizedException(
                __('We found a directory with the same name. Please try another folder name.')
            );
        }

        $this->directory->create($relativeNewPath);
        try {
            if ($this->coreFileStorageDb->checkDbUsage()) {
                $relativePath = $this->coreFileStorageDb->getMediaRelativePath($newPath);
                $this->directoryDatabaseFactory->create()->createRecursive($relativePath);
            }

            $result = [
                'name' => $name,
                'short_name' => $this->cmsWysiwygImages->getShortFilename($name),
                'path' => $newPath,
                'id' => $this->cmsWysiwygImages->convertPathToId($newPath),
            ];
            return $result;
        } catch (FileSystemException $e) {
            throw new LocalizedException(__('We cannot create a new directory.'));
        }
    }

    /**
     * Recursively delete directory from storage
     *
     * @param string $path Target dir
     * @return void
     * @throws LocalizedException
     */
    public function deleteDirectory($path)
    {
        if ($this->coreFileStorageDb->checkDbUsage()) {
            $this->directoryDatabaseFactory->create()->deleteDirectory($path);
        }
        try {
            $this->_deleteByPath($path);
            $path = $this->getThumbnailRoot() . $this->_getRelativePathToRoot($path);
            $this->_deleteByPath($path);
        } catch (FileSystemException $e) {
            throw new LocalizedException(__('We cannot delete directory %1.', $path));
        }
    }

    /**
     * Delete by path
     *
     * @param string $path
     * @return void
     */
    protected function _deleteByPath($path)
    {
        $path = $this->_sanitizePath($path);
        if (!empty($path)) {
            $this->_validatePath($path);
            $this->directory->delete($this->directory->getRelativePath($path));
        }
    }

    /**
     * Delete file (and its thumbnail if exists) from storage
     *
     * @param string $target File path to be deleted
     * @return $this
     */
    public function deleteFile($target)
    {
        $relativePath = $this->directory->getRelativePath($target);
        if ($this->directory->isFile($relativePath)) {
            $this->directory->delete($relativePath);
        }
        $this->coreFileStorageDb->deleteFile($target);

        $thumb = $this->getThumbnailPath($target, true);
        $relativePathThumb = $this->directory->getRelativePath($thumb);
        if ($thumb) {
            if ($this->directory->isFile($relativePathThumb)) {
                $this->directory->delete($relativePathThumb);
            }
            $this->coreFileStorageDb->deleteFile($thumb);
        }
        return $this;
    }

    /**
     * Upload and resize new file
     *
     * @param string $targetPath Target directory
     * @param string $type Type of storage, e.g. image, media etc.
     * @return array File info Array
     * @throws LocalizedException
     */
    public function uploadFile($targetPath, $type = null)
    {
        /** @var \Magento\MediaStorage\Model\File\Uploader $uploader */
        $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
        $allowed = $this->getAllowedExtensions($type);
        if ($allowed) {
            $uploader->setAllowedExtensions($allowed);
        }
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $result = $uploader->save($targetPath);

        if (!$result) {
            throw new LocalizedException(__('We can\'t upload the file right now.'));
        }

        // create thumbnail
        $this->resizeFile($targetPath . '/' . $uploader->getUploadedFileName(), true);

        $result['cookie'] = [
            'name' => $this->getSession()->getName(),
            'value' => $this->getSession()->getSessionId(),
            'lifetime' => $this->getSession()->getCookieLifetime(),
            'path' => $this->getSession()->getCookiePath(),
            'domain' => $this->getSession()->getCookieDomain(),
        ];

        return $result;
    }

    /**
     * Thumbnail path getter
     *
     * @param  string $filePath original file path
     * @param  bool $checkFile OPTIONAL is it necessary to check file availability
     * @return string|false
     */
    public function getThumbnailPath($filePath, $checkFile = false)
    {
        $mediaRootDir = $this->cmsWysiwygImages->getStorageRoot();

        if (strpos($filePath, $mediaRootDir) === 0) {
            $thumbPath = $this->getThumbnailRoot() . substr($filePath, strlen($mediaRootDir));

            if (!$checkFile || $this->directory->isExist($this->directory->getRelativePath($thumbPath))) {
                return $thumbPath;
            }
        }

        return false;
    }

    /**
     * Thumbnail URL getter
     *
     * @param  string $filePath original file path
     * @param  bool $checkFile OPTIONAL is it necessary to check file availability
     * @return string|false
     */
    public function getThumbnailUrl($filePath, $checkFile = false)
    {
        $mediaRootDir = $this->cmsWysiwygImages->getStorageRoot();

        if (strpos($filePath, $mediaRootDir) === 0) {
            $thumbSuffix = self::THUMBS_DIRECTORY_NAME . substr($filePath, strlen($mediaRootDir));
            if (!$checkFile || $this->directory->isExist(
                $this->directory->getRelativePath($mediaRootDir . '/' . $thumbSuffix)
            )
            ) {
                $thumbSuffix = substr(
                    $mediaRootDir,
                    strlen($this->directory->getAbsolutePath())
                ) . '/' . $thumbSuffix;
                $randomIndex = '?rand=' . time();
                return str_replace('\\', '/', $this->cmsWysiwygImages->getBaseUrl() . $thumbSuffix) . $randomIndex;
            }
        }

        return false;
    }

    /**
     * Create thumbnail for image and save it to thumbnails directory
     *
     * @param string $source Image path to be resized
     * @param bool $keepRation Keep aspect ratio or not
     * @return bool|string Resized filepath or false if errors were occurred
     */
    public function resizeFile($source, $keepRation = true)
    {
        $realPath = $this->directory->getRelativePath($source);
        if (!$this->directory->isFile($realPath) || !$this->directory->isExist($realPath)) {
            return false;
        }

        $targetDir = $this->getThumbsPath($source);
        $pathTargetDir = $this->directory->getRelativePath($targetDir);
        if (!$this->directory->isExist($pathTargetDir)) {
            $this->directory->create($pathTargetDir);
        }
        if (!$this->directory->isExist($pathTargetDir)) {
            return false;
        }
        $image = $this->imageFactory->create();
        $image->open($source);
        $image->keepAspectRatio($keepRation);
        $image->resize($this->resizeParameters['width'], $this->resizeParameters['height']);
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $dest = $targetDir . '/' . pathinfo($source, PATHINFO_BASENAME);
        $image->save($dest);
        if ($this->directory->isFile($this->directory->getRelativePath($dest))) {
            return $dest;
        }
        return false;
    }

    /**
     * Resize images on the fly in controller action
     *
     * @param string $filename File basename
     * @return bool|string Thumbnail path or false for errors
     * @throws LocalizedException
     */
    public function resizeOnTheFly($filename)
    {
        $path = $this->getSession()->getCurrentPath();
        if (!$path) {
            $path = $this->cmsWysiwygImages->getCurrentPath();
        }
        return $this->resizeFile($path . '/' . $filename);
    }

    /**
     * Return thumbnails directory path for file/current directory
     *
     * @param bool|string $filePath Path to the file
     * @return string
     */
    public function getThumbsPath($filePath = false)
    {
        $mediaRootDir = $this->cmsWysiwygImages->getStorageRoot();
        $thumbnailDir = $this->getThumbnailRoot();
        if ($filePath && strpos($filePath, $mediaRootDir) === 0) {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            $thumbnailDir .= dirname(substr($filePath, strlen($mediaRootDir)));
        }

        return $thumbnailDir;
    }

    /**
     * Storage session
     *
     * @return \Magento\Backend\Model\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Prepare allowed_extensions config settings
     *
     * @param string $type Type of storage, e.g. image, media etc.
     * @return array Array of allowed file extensions
     */
    public function getAllowedExtensions($type = null)
    {
        if (is_string($type) && array_key_exists("{$type}_allowed", $this->extensions)) {
            $allowed = $this->extensions["{$type}_allowed"];
        } else {
            $allowed = $this->extensions['allowed'];
        }

        return array_keys(array_filter($allowed));
    }

    /**
     * Thumbnail root directory getter
     *
     * @return string
     */
    public function getThumbnailRoot()
    {
        return $this->cmsWysiwygImages->getStorageRoot() . '/' . self::THUMBS_DIRECTORY_NAME;
    }

    /**
     * Simple way to check whether file is image or not based on extension
     *
     * @param string $filename
     * @return bool
     */
    public function isImage($filename)
    {
        if (!$this->hasData('_image_extensions')) {
            $this->setData('_image_extensions', $this->getAllowedExtensions('image'));
        }
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $this->_getData('_image_extensions'));
    }

    /**
     * Get resize width
     *
     * @return int
     */
    public function getResizeWidth()
    {
        return $this->resizeParameters['width'];
    }

    /**
     * Get resize height
     *
     * @return int
     */
    public function getResizeHeight()
    {
        return $this->resizeParameters['height'];
    }

    /**
     * Get cms wysiwyg images helper
     *
     * @return Images|null
     */
    public function getCmsWysiwygImages()
    {
        return $this->cmsWysiwygImages;
    }

    /**
     * Is path under storage root directory
     *
     * @param string $path
     * @return void
     * @throws LocalizedException
     */
    protected function _validatePath($path)
    {
        $root = $this->_sanitizePath($this->cmsWysiwygImages->getStorageRoot());
        if ($root == $path) {
            throw new LocalizedException(
                __('We can\'t delete root directory %1 right now.', $path)
            );
        }
        if (strpos($path, $root) !== 0) {
            throw new LocalizedException(
                __('Directory %1 is not under storage root path.', $path)
            );
        }
    }

    /**
     * Sanitize path
     *
     * @param string $path
     * @return string
     */
    protected function _sanitizePath($path)
    {
        return rtrim(preg_replace('~[/\\\]+~', '/', $this->directory->getDriver()->getRealPath($path)), '/');
    }

    /**
     * Get path in root storage dir
     *
     * @param string $path
     * @return string|bool
     */
    protected function _getRelativePathToRoot($path)
    {
        return substr(
            $this->_sanitizePath($path),
            strlen($this->_sanitizePath($this->cmsWysiwygImages->getStorageRoot()))
        );
    }
}
