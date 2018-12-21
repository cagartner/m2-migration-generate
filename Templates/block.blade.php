<?php echo '<?php' ?>

namespace {{ $namespace }}

use \Magento\Cms\Model\BlockRepository;

/**
* Copy this class to your  migration module and put this line to your migration
* $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
* $objectManager->create(Your\Migration\{{ $migrationName}}::class)->run();
*/
class {{ $migrationName }}
{
    protected $blockRepository;

    public function __construct(BlockRepository $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    public static function run()
    {
        if ($block = $this->blockRepository->getById('{{ $block['identifier'] }}')) {

        }
    }
}