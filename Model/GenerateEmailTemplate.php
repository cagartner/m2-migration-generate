<?php
/**
 * GenerateBlock
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Cagartner\GenerateMigration\Model;

class GenerateEmailTemplate extends GenerateFile
{
    protected $block;
    protected $migrationName;

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

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function getNamespace()
    {
        if ($namespace = $this->helper->getMigrationModuleNamespace()) {
            return $namespace . '\Setup\migrations';
        }
        throw new \Exception(self::NO_MIGRATE_MODULE);
    }

    /**
     * @param array $data
     * @return bool|int
     * @throws \Exception
     */
    public function generate($data = [])
    {
        $this->io->checkAndCreateFolder($this->getOutputDir());

        $fileData =  [
            'namespace' => $this->getNamespace(),
            'migrationName' => $this->getMigrationName(),
        ];

        $fileContent = $this->blade->render(self::TYPE_EMAIL, array_merge($fileData, $data));
        $fileName = $this->getMigrationName() . '.php';

        $this->io->open(['path' => $this->getOutputDir()]);
        return $this->io->write($fileName, $fileContent, 0666);
    }
}