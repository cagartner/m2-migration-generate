<?php echo '<?php' ?>

namespace {{ $namespace }};

use Magento\Cms\Model\BlockRepository;
use Magento\Cms\Model\BlockFactory;

/**
* Copy this class to your  migration module and put this line to your migration
* $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
* $objectManager->create(Your\Migration\{{ $migrationName}}::class)->run();
*/
class {{ $migrationName }}
{
    protected $blockRepository;
    protected $blockFactory;

    public function __construct(
        BlockRepository $blockRepository,
        BlockFactory $blockFactory
    )
    {
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
    }

    public static function run()
    {
        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockRepository->getById({{ var_export($block->getIdentifier()) }});

        if (!$block->getId()) {
            // If not exist, create a new block
            $block = $this->blockFactory->create();
        }
        <?php
            $data = $block->getData();
            // Remove not important data
            unset($data['block_id']);
            unset($data['creation_time']);
            unset($data['update_time']);
            unset($data['stores']);
        ?>
        $block->setData({{ var_export($data) }});
        return $this->blockRepository->save($block);
    }
}