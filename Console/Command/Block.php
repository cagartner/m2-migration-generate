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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Block extends Command
{

    const NAME_ARGUMENT = "name";
    const IDENTIFIER_ARGUMENT = "identifier";

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

        } catch (\Exception $e) {

        }

        $output->writeln("Hello " . $name);
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
