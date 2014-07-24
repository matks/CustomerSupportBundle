CustomerSupportBundle
=====================

Tickets-based bundle to integrate customer exchange in your symfony2 application

## Installation

### Step 1: composer requirements

Add the private repository metadata in your composer.json
```json
{
    "require": {
        "matks/customer-support-bundle": "0.1.*"
    },
}
```
## Tests

### Stand alone context

In a bundle isolation context, just install the dev dependencies with composer
```bash
$ composer install --dev
```

Run the unit tests suite with phpunit binary
```bash
$ vendor/bin/phpunit --bootstrap vendor/autoload.php Tests/Units
```