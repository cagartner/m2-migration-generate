<?php
/**
 * GenerateFile
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Cagartner\GenerateMigration\Model;


use Jenssegers\Blade\Blade;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Module\Dir\Reader;

class GenerateFile
{
    const TYPE_BLOCK = 'block';
    const TYPE_PAGE = 'page';
    const TYPE_CONFIG = 'config';
    const TYPE_EMAIL = 'email';

    protected $moduleReader;
    protected $moduleDir;
    protected $directoryList;
    protected $filesystem;
    protected $namespace;
    protected $migrationName;
    protected $io;

    public function __construct(
        Reader $moduleReader,
        DirectoryList $directoryList,
        Filesystem $filesystem,
        File $io
    )
    {
        $this->moduleReader = $moduleReader;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->io = $io;
        $this->setModuleDir();
    }

    /**
     * @return mixed
     */
    public function getModuleDir()
    {
        return $this->moduleDir;
    }

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
     * @return mixed
     */
    public function getMigrationName()
    {
        return $this->migrationName;
    }

    /**
     * @param mixed $migrationName
     */
    public function setMigrationName($migrationName): void
    {
        $this->migrationName = $migrationName;
    }

    public function getTemplateDir()
    {
        return $this->moduleDir . 'Templates';
    }

    public function getCacheDir()
    {
        return $this->directoryList->getPath(DirectoryList::CACHE);
    }

    public function getOutputDir()
    {
        return $this->directoryList->getPath(DirectoryList::VAR_DIR) . '/migration/';
    }

    public function output()
    {
        return '/path/of/output';
    }

    public function generate($type=self::TYPE_BLOCK, $data = [])
    {
        $this->io->checkAndCreateFolder($this->getCacheDir());
        $this->io->checkAndCreateFolder($this->getOutputDir());

        $blade = new Blade($this->getTemplateDir(), $this->getCacheDir());

        $fileData =  [
            'namespace' => $this->getNamespace(),
            'migrationName' => $this->getMigrationName(),
            'namespace' => $this->getNamespace()
        ];

        $fileContent = $blade->render($type, array_merge($fileData, $data));
        $fileName = $this->getMigrationName() . '.php';

        $this->io->open(['path' => $this->getOutputDir()]);
        return $this->io->write($fileName, $fileContent, 0666);
    }
}