# Generate your CMS Blocks/Pages Migrations

## Installment
    composer require cagartner/module-generatemigration

## Usage
In your console execute the following commands, the output class file will be in /var/migration

Copy your generated class and put in your migration module.

You can call your migrations in your Setup/installData.php or Setup/upgradeData.php with this code:

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $objectManager->create(Your\Module\Setup\migrationName::class)->run();

### Blocks:
    bin/magento make:migration:block {indentifier} {nameOfMigration}
    # Exemplo
    bin/magento make:migration:block contact-us-info updateBlockInfo

### Pages
@todo

### Emails Templates
@todo

### Configs
@todo