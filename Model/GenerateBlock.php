<?php
/**
 * GenerateBlock
 *
 * @copyright Copyright © 2018 Staempfli AG. All rights reserved.
 * @author    juan.alonso@staempfli.com
 */

namespace Cagartner\GenerateMigration\Model;

use Jenssegers\Blade\Blade;
use Magento\Framework\Module\Dir\Reader;

class GenerateBlock extends GenerateFile
{
    protected $block;

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block): void
    {
        $this->block = $block;
    }
}