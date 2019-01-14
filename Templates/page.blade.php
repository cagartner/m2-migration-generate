<?php echo '<?php' ?>

namespace {{ $namespace }};

use Magento\Cms\Model\PageRepository;
use Magento\Cms\Model\PageFactory;

/**
* Copy this class to your  migration module and put this line to your migration

  $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
  $objectManager->create(\{{ $namespace }}\{{ $migrationName}}::class)->run();

*/
class {{ $migrationName }}
{
    protected $pageRepository;
    protected $pageFactory;

    public function __construct(
        PageRepository $pageRepository,
        PageFactory $pageFactory
    )
    {
        $this->pageRepository = $pageRepository;
        $this->pageFactory = $pageFactory;
    }

    public function run()
    {
        /** @var \Magento\Cms\Model\Page $page */
        try {
            $page = $this->pageRepository->getById('new-home');
        } catch (\Exception $e) {
            // If not exist, create a new page
            $page = $this->pageFactory->create();
            $page->setIdentifier({{ var_export($page->getIdentifier()) }});
        }

        $page->setTitle({{ var_export($page->getTitle()) }});
        $page->setPageLayout({{ var_export($page->getPageLayout()) }});
        $page->setMetaTitle({{ var_export($page->getMetaTitle()) }});
        $page->setMetaKeywords({{ var_export($page->getMetaKeywords()) }});
        $page->setMetaDescription({{ var_export($page->getMetaDescription()) }});
        $page->setContentHeading({{ var_export($page->getContentHeading()) }});
        $page->setContent({{ var_export($page->getContent()) }});
        $page->setSortOrder({{ var_export($page->getSortOrder()) }});
        $page->setLayoutUpdateXml({{ var_export($page->getLayoutUpdateXml()) }});
        $page->setCustomTheme({{ var_export($page->getCustomTheme()) }});
        $page->setCustomRootTemplate({{ var_export($page->getCustomRootTemplate()) }});
        $page->setCustomThemeFrom({{ var_export($page->getCustomThemeFrom()) }});
        $page->setCustomThemeTo({{ var_export($page->getCustomThemeTo()) }});
        $page->setCustomLayoutUpdateXml({{ var_export($page->getCustomLayoutUpdateXml()) }});
        $page->setIsActive({{ (boolean) $page->getData('is_active') }});
        $page->setStoreId({{ var_export($page->getData('store_id')) }});

        return $this->pageRepository->save($page);
    }
}