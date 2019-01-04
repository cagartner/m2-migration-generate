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

use Cagartner\GenerateMigration\Model\Config as ConfigSet;
use Cagartner\GenerateMigration\Model\GenerateModule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    const NAME_ARGUMENT = "name";
    const VENDOR_ARGUMENT = "vendor";

    protected $generateModule;

    public function __construct(
        GenerateModule $generateModule
    )
    {
        $this->generateModule = $generateModule;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $vendor = $input->getArgument(self::VENDOR_ARGUMENT);
        $name = $input->getArgument(self::NAME_ARGUMENT);

        $this->generateModule->setName($name);
        $this->generateModule->setVendor($vendor);

        try {
            $this->generateModule->generate();
            $output->writeln('Created a New Migrate Module, run "bin/magento setup:upgrade" for activate the new module');
        } catch (\Exception $e) {
            $output->writeln("Error in generate file " . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(ConfigSet::NAMESPACE . ":init");
        $this->setDescription("Initial configuration to create migration module");
        $this->setDefinition([
            new InputArgument(self::VENDOR_ARGUMENT, InputArgument::REQUIRED, "Vendor"),
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "Name"),
        ]);
        parent::configure();
    }
}
