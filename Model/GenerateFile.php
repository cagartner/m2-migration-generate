<?php
/**
 * GenerateFile
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Cagartner\GenerateMigration\Model;

use Cagartner\GenerateMigration\Helper\Data as MigrationHelper;
use Jenssegers\Blade\Blade;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Module\Dir\Reader;

/**
 * Class GenerateFile
 * @package Cagartner\GenerateMigration\Model
 */
class GenerateFile
{
    /**
     * Type block
     */
    const TYPE_BLOCK = 'block';
    /**
     *
     */
    const TYPE_PAGE = 'page';
    /**
     *
     */
    const TYPE_CONFIG = 'config';
    /**
     *
     */
    const TYPE_EMAIL = 'email';

    const NO_MIGRATE_MODULE = 'Migration Module not configured, please run: bin/magento make:migration:init <Vendor> <Name>';

    /**
     * @var Reader
     */
    protected $moduleReader;
    /**
     * @var
     */
    protected $moduleDir;
    /**
     * @var DirectoryList
     */
    protected $directoryList;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var
     */
    protected $namespace;
    /**
     * @var File
     */
    protected $io;
    /**
     * @var Blade
     */
    protected $blade;

    protected $helper;

    /**
     * GenerateFile constructor.
     * @param Reader $moduleReader
     * @param DirectoryList $directoryList
     * @param Filesystem $filesystem
     * @param File $io
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Reader $moduleReader,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        File $io,
        MigrationHelper $helper
    )
    {
        $this->moduleReader = $moduleReader;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->io = $io;
        $this->helper = $helper;
        $this->initiate();
    }

    /**
     * @return mixed
     */
    public function getModuleDir()
    {
        return $this->moduleDir;
    }

    /**
     *
     */
    public function setModuleDir(): void
    {
        $viewDir = $this->moduleReader->getModuleDir(
            \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
            Config::MODULE_NAME
        );
        $this->moduleDir = str_replace('view', '', $viewDir);
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace): void
    {
        $this->namespace = str_replace('/', '\\', $namespace);
    }

    /**
     * @return string
     */
    public function getTemplateDir()
    {
        return $this->getModuleDir() . 'Templates';
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getCacheDir()
    {
        return $this->directoryList->getPath(DirectoryList::CACHE);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getOutputDir()
    {
        if ($outputDir = $this->helper->getMigrationModuleDir()) {
            return $outputDir . 'Setup/migrations';
        }
        throw new \Exception(self::NO_MIGRATE_MODULE);
    }

    /**
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function initiate()
    {
        $this->setModuleDir();
        $this->io->checkAndCreateFolder($this->getCacheDir());
        $this->blade = new Blade($this->getTemplateDir(), $this->getCacheDir());
    }
}