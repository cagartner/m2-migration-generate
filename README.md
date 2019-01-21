# Generate your CMS Blocks/Pages Migrations (Beta)

## Installment
    composer require cagartner/module-generatemigration

## Usage
In your console execute the following commands, the output class file will be in /var/migration

Copy your generated class and put in your migration module.

### Setup Migration:

Before create any migration your need to setup de migration module, for this run:

    bin/magento make:migration:init <Vendor> <NameofModule>
    # Example
    bin/magento make:migration:init Cagartner Migration

This command will create a new module in app/code folder of magento structure.

    app
    |-- code
        |-- Cagartner
            |-- Migration
                |-- etc
                    -- module.xml
                |-- Setup
                    |-- migrations
                    |-- InstallData.php
                    |-- UpgradeData.php
                |-- composer.json
                |-- registration.php
                
Every migration that you create will be generated into migrations folder in that module

### Blocks:
    bin/magento make:migration:block {indentifier} {nameOfMigration}
    # Example
    bin/magento make:migration:block contact-us-info updateBlockInfo

### Pages
    bin/magento make:migration:page {indentifier} {nameOfMigration}
    # Example
    bin/magento make:migration:page home updateHomePage

### Emails Templates
@todo

### Configs
@todo
