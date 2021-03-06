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
use Cagartner\GenerateMigration\Model\GenerateEmailTemplate;
use Magento\Email\Model\Template;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Email extends Command
{
    const NAME_ARGUMENT = 'name';
    const IDENTIFIER_ARGUMENT = 'identifier';

    protected $template;
    protected $templateFile;
    protected $state;

    /**
     * Email constructor.
     * @param Template $template
     * @param GenerateEmailTemplate $templateFile
     * @param State $state
     */
    public function __construct(
        Template $template,
        GenerateEmailTemplate $templateFile,
        State $state
    )
    {
        $this->template = $template;
        $this->templateFile = $templateFile;
        $this->state = $state;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->state->setAreaCode(Area::AREA_FRONTEND);

        $name = $input->getArgument(self::NAME_ARGUMENT);
        $identifier = $input->getArgument(self::IDENTIFIER_ARGUMENT);

        try {
            $template = $this->template->load($identifier);

            $this->templateFile->setMigrationName($name);
            $this->templateFile->generate(compact('template'));

            $output->writeln("New email migration created in: " . $this->templateFile->getOutputDir() . 'Setup/migrations/' . $name . '.php');
        } catch (\Exception $e) {
            $output->writeln("Error in generate file: " . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(Config::NAMESPACE . ":email");
        $this->setDescription("Generate E-mail Template Migration");
        $this->setDefinition([
            new InputArgument(self::IDENTIFIER_ARGUMENT, InputArgument::REQUIRED, "Identifier of page"),
            new InputArgument(self::NAME_ARGUMENT, InputArgument::REQUIRED, "Name of migration")
        ]);
        parent::configure();
    }
}
