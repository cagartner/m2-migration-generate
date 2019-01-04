<?php
/**
 * Config
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Cagartner\GenerateMigration\Model;


/**
 * Class Config
 * @package Cagartner\GenerateMigration\Model
 */
abstract class Config
{
    const MODULE_NAME = 'Cagartner_GenerateMigration';

    /**
     *
     */
    const NAMESPACE = 'make:migration';

    /**
     *
     */
    const MIGRATION_PATH = 'Setup/migration/';
}