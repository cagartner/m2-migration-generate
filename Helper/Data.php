<?php
namespace Cagartner\GenerateMigration\Helper;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const CONFIG_NAMESPACE = 'cagartner/generate_migration/module_namespace';
    const CONFIG_DIR = 'cagartner/generate_migration/module_dir';

    protected $writer;

    /**
     * Data constructor.
     */
    public function __construct(
        WriterInterface $writer,
        Context $context
    )
    {
        $this->writer = $writer;
        parent::__construct($context);
    }

    public function setMigrationModuleNamespace($namespace)
    {
        $this->writer->save(self::CONFIG_NAMESPACE, $namespace);
    }

    public function getMigrationModuleNamespace()
    {
        return $this->scopeConfig->getValue(self::CONFIG_NAMESPACE);
    }

    public function setMigrationModuleDir($moduleDir)
    {
        $this->writer->save(self::CONFIG_DIR, $moduleDir);
    }

    public function getMigrationModuleDir()
    {
        return $this->scopeConfig->getValue(self::CONFIG_DIR);
    }
}