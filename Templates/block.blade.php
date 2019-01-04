<?php echo '<?php' ?>

namespace {{ $namespace }};

use Magento\Cms\Model\BlockRepository;
use Magento\Cms\Model\BlockFactory;

/**
* Copy this class to your  migration module and put this line to your migration

  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
  $objectManager->create(\{{ $namespace }}\{{ $migrationName}}::class)->run();

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

    public function run()
    {
        /** @var \Magento\Cms\Model\Block $block */
        $block = $this->blockRepository->getById({{ var_export($block->getIdentifier()) }});

        if (!$block->getId()) {
            // If not exist, create a new block
            $block = $this->blockFactory->create();
            $block->setIdentifier({{ var_export($block->getIdentifier()) }});
        }

        $block->setTitle({{ var_export($block->getTitle()) }});
        $block->setContent({{ var_export($block->getContent()) }});
        $block->setIsActive({{ (boolean) $block->getData('is_active') }});
        $block->setStoreId({{ var_export($block->getData('store_id')) }});

        return $this->blockRepository->save($block);
    }
}