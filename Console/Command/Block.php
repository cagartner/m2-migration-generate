<?php
/**
 * Generate migration for your cms pages/blocks, configs, email template
 * Copyright (C) 2018  Carlos Gartner
 * 
 * This file is part of Cagartner/GenerateMigration.
 * 
 * Cagartner/GenerateMigration is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Cagartner\GenerateMigration\Console\Command;

use Cagartner\GenerateMigration\Model\Config;
use Cagartner\GenerateMigration\Model\GenerateBlock;
use Cagartner\GenerateMigration\Model\GenerateFile;
use Magento\Cms\Model\BlockRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Block extends Command
{

    const NAME_ARGUMENT = 'name';
    const IDENTIFIER_ARGUMENT = 'identifier';
    const DEFAULT_MIGRATION_NAME = 'block_migration_';

    protected $blockRepository;
    protected $blockFile;

    public function __construct(
        BlockRepository $blockRepository,
        GenerateBlock $generateBlock
    )
    {
        $this->blockRepository = $blockRepository;
        $this->blockFile = $generateBlock;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $name = $input->getArgument(self::NAME_ARGUMENT);
        $identifier = $input->getArgument(self::IDENTIFIER_ARGUMENT);

        try {
            /** @var \Magento\Cms\Model\Block $block */
            $block = $this->blockRepository->getById($identifier);
            $this->blockFile->setMigrationName($name ?: self::DEFAULT_MIGRATION_NAME . '_' . date('Ymdhis'));
            $this->blockFile->setNamespace(Config::MIGRATION_PATH);
            $this->blockFile->generate(GenerateFile::TYPE_BLOCK, compact('block'));

            $output->writeln("New block created in: " .  $this->blockFile->output());
        } catch (\Exception $e) {
            $output->writeln("Error in generate file " . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(Config::NAMESPACE . ":block");
        $this->setDescription("Generate Block Migration");
        $this->setDefinition([
            new InputArgument(self::IDENTIFIER_ARGUMENT, InputArgument::REQUIRED, "Identifier of block"),
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name of migration"),
        ]);
        parent::configure();
    }
}
