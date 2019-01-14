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
use Cagartner\GenerateMigration\Model\GeneratePage;
use Magento\Cms\Model\PageRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Page extends Command
{

    const NAME_ARGUMENT = 'name';
    const IDENTIFIER_ARGUMENT = 'identifier';

    protected $pageRepository;
    protected $pageFile;

    /**
     * Page constructor.
     */
    public function __construct(
        PageRepository $pageRepository,
        GeneratePage $pageFile
    )
    {
        $this->pageRepository = $pageRepository;
        $this->pageFile = $pageFile;
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
            /** @var \Magento\Cms\Model\Page $page */
            $page = $this->pageRepository->getById($identifier);

            $this->pageFile->setMigrationName($name);
            $this->pageFile->generate(compact('page'));

            $output->writeln("New page migration created in: " . $this->pageFile->getOutputDir() . 'Setup/migrations/' . $name . '.php');
        } catch (\Exception $e) {
            $output->writeln("Error in generate file: " . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(Config::NAMESPACE . ":page");
        $this->setDescription("Generate Page Migration");
        $this->setDefinition([
            new InputArgument(self::IDENTIFIER_ARGUMENT, InputArgument::REQUIRED, "Identifier of page"),
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "Name of migration"),
        ]);
        parent::configure();
    }
}
