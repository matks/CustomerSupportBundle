CustomerSupportBundle
=====================

[![Latest Stable Version](https://poser.pugx.org/matks/customer-support-bundle/v/stable.svg)](https://packagist.org/packages/matks/customer-support-bundle)
[![Build Status](https://travis-ci.org/matks/CustomerSupportBundle.png)](https://travis-ci.org/matks/CustomerSupportBundle)
[![Latest Unstable Version](https://poser.pugx.org/matks/customer-support-bundle/v/unstable.svg)](https://packagist.org/packages/matks/customer-support-bundle)
[![License](https://poser.pugx.org/matks/customer-support-bundle/license.svg)](https://packagist.org/packages/matks/customer-support-bundle)

Tickets-based bundle to integrate customer exchange in your symfony2 application

## Installation

### Step 1: composer requirements

Add the private repository metadata in your composer.json
```json
{
    "require": {
        "matks/customer-support-bundle": "1.0"
    },
}
```

Then run the composer command
```bash
$ php composer.phar install
```

### Step 2: Enable the bundle in your Symfony application

```php
<?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Matks\Bundle\CustomerSupportBundle\CustomerSupportBundle(),
        )
    }
```

### Step 3: Configure doctrine entity resolver

```yml
doctrine:
    orm:
        resolve_target_entities:
            Matks\Bundle\CustomerSupportBundle\Model\UserInterface: Matks\Bundle\CustomerSupportBundle\Entity\User
            Matks\Bundle\CustomerSupportBundle\Model\MessageInterface: Matks\Bundle\CustomerSupportBundle\Entity\Message
            Matks\Bundle\CustomerSupportBundle\Model\TicketInterface: Matks\Bundle\CustomerSupportBundle\Entity\Ticket
            Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface: Matks\Bundle\CustomerSupportBundle\Entity\Category
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

Run acceptance tests with behat binary using the fixture application and sqlite
```bash
$ vendor/bin/behat -c behat.ci.yml
```
