# CakePHP Mailjet Transport

Allows sending emails via Mailjet by using the provided Mailjet SDK.

Supports email parameters listed in https://dev.mailjet.com/guides/.

## Requirements

* PHP >= 5.4
* Composer

## Installation

* Install with composer by running `composer require hd-cms/cakephp-mailjet`
* Include the plugin in your bootstrap's `CakePlugin::load('Mailjet')` or `CakePlugin::loadAll()`

## Example of configuration

```php
<?php

class EmailConfig {

    public $mailjet = array(
        'transport' => 'Mailjet.Mailjet',
        'mj_domain' => 'domain.mailjet.org',
        'mj_api_key' => 'mailjet-api-key',
	'mj_api_secret' => 'mailjet-api-secret',
	'from' => array('no-reply@my-app.com' => 'My App'),
    );
}
```

