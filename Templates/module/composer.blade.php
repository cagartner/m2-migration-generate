{
    "name": "{{ $name }}",
    "description": "Generate migration for your cms pages/blocks, configs, email template",
    "type": "magento2-module",
    "license": "GPL-3.0",
    "authors": [
        {
            "email": "contato@carlosgartner.com.br",
            "name": "Carlos Gartner"
        }
    ],
    "minimum-stability": "dev",
    "require": {},
    "autoload": {
        "psr-4": {
            "{{ $psr }}": ""
        },
        "files": [
            "registration.php"
        ]
    }
}