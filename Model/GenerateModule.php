<?php
namespace Cagartner\GenerateMigration\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class GenerateModule
 * @package Cagartner\GenerateMigration\Model
 */
class GenerateModule extends GenerateFile
{
    /**
     * @var vendor module name
     */
    protected $vendor;
    /**
     * @var module name
     */
    protected $name;
    /**
     * @var new module dir
     */
    protected $newModuleDir;

    /**
     * @return mixed
     */
    public function getNewModuleDir()
    {
        return $this->newModuleDir;
    }

    /**
     * Set the new module dir based in the name and vendor
     */
    public function setNewModuleDir(): void
    {
        $this->newModuleDir = $this->directoryList->getPath(DirectoryList::APP) . '/code/' . $this->getVendor() . '/' . $this->getName() . '/';
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor($vendor): void
    {
        $this->vendor = $vendor;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool|int
     * @throws \Exception
     */
    public function createComposerJson()
    {
        $name = $this->getVendor() . '_' . $this->getName();
        $psr = $this->getVendor() . '\\\\' . $this->getName() . '\\\\';
        $content = $this->blade->render('module.composer', compact('name', 'psr'));
        $this->io->checkAndCreateFolder($this->getNewModuleDir());
        $this->io->open(['path' => $this->getNewModuleDir()]);
        return $this->io->write('composer.json', $content, 0666);
    }

    /**
     * @return bool|int
     */
    public function createRegistrationPhp()
    {
        $name = $this->getVendor() . '_' . $this->getName();
        $content = $this->blade->render('module.registration', compact('name'));
        $this->io->open(['path' => $this->getNewModuleDir()]);
        return $this->io->write('registration.php', $content, 0666);
    }

    /**
     * @return bool|int
     * @throws \Exception
     */
    public function createModuleXml()
    {
        $name = $this->getVendor() . '_' . $this->getName();
        $version =  '1.0.0';
        $content = $this->blade->render('module.module', compact('name', 'version'));
        $this->io->checkAndCreateFolder($this->getNewModuleDir() . '/etc');
        $this->io->open(['path' => $this->getNewModuleDir() . '/etc']);
        return $this->io->write('module.xml', $content, 0666);
    }

    /**
     * @return bool|int
     * @throws \Exception
     */
    public function createInstallDataPhp()
    {
        $namespace = $this->getVendor() . '\\' . $this->getName() . '\\' . 'Setup';
        $content = $this->blade->render('module.installData', compact('namespace'));
        $this->io->checkAndCreateFolder($this->getNewModuleDir() . '/Setup');
        $this->io->open(['path' => $this->getNewModuleDir() . '/Setup']);
        return $this->io->write('InstallData.php', $content, 0666);
    }

    /**
     * @return bool|int
     */
    public function createUpgradeDataPhp()
    {
        $namespace = $this->getVendor() . '\\' . $this->getName() . '\\' . 'Setup';
        $content = $this->blade->render('module.upgradeData', compact('namespace'));
        $this->io->open(['path' => $this->getNewModuleDir() . '/Setup']);
        return $this->io->write('UpgradeData.php', $content, 0666);
    }

    /**
     * @throws \Exception
     */
    public function generate()
    {
        // Create module structure
        $this->setNewModuleDir();
        $this->createComposerJson();
        $this->createRegistrationPhp();
        $this->createModuleXml();
        $this->createInstallDataPhp();
        $this->createUpgradeDataPhp();

        // Save info in bd for use when one migration is created
        $this->helper->setMigrationModuleDir($this->getNewModuleDir());
        $this->helper->setMigrationModuleNamespace($this->getVendor() . '\\' . $this->getName() );
    }
}