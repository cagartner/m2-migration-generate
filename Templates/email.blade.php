<?php echo '<?php' ?>

namespace {{ $namespace }};

use Magento\Email\Model\Template;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;

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
        Template $template,
        State $state
    )
    {
        $this->template = $template;
        $this->state = $state;
    }

    public function run()
    {
        /** @var \Magento\Cms\Model\Page $page */
        try {
            $page = $this->template->load();
        } catch (\Exception $e) {
            // If not exist, create a new page
            $page = $this->pageFactory->create();
        }

        $template->setTemplateCode({{ var_export($template->getTemplateCode()) }});
        $template->setTemplateText({{ var_export($template->getTemplateText()) }});
        $template->setTemplateStyles({{ var_export($template->getTemplateStyles()) }});
        $template->setTemplateType({{ var_export($template->getTemplateType()) }});
        $template->setTemplateSubject({{ var_export($template->getTemplateSubject()) }});
        $template->setTemplateSenderName({{ var_export($template->getTemplateSenderName()) }});
        $template->setTemplateSenderEmail({{ var_export($template->getTemplateSenderEmail()) }});
        $template->setOrigTemplateCode({{ var_export($template->getOrigTemplateCode()) }});
        $template->setOrigTemplateVariables({{ var_export($template->getOrigTemplateVariables()) }});

        return $this->pageRepository->save($page);
    }
}