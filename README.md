# CakePHP 2.x Mailjet Transport

Allows sending emails via Mailjet by using the provided Mailjet SDK.

## Requirements

* PHP >= 5.4
* Composer

## Installation

* Install with composer by running `composer require hd-cms/cakephp-mailjet`
* Include the plugin in your bootstrap's `CakePlugin::load('Mailjet')` or `CakePlugin::loadAll()`

## Supported CakePHP Params

Currently you can send emails with the following parameters: `to`, `from` and `attachments`.
Also you can set multiple `to` recipients. Read more on the official [CakePHP Mail Documentation](https://book.cakephp.org/2.0/en/core-utility-libraries/email.html)

## Example configuration

```php
<?php

class EmailConfig {

    public $mailjet = array(
        'transport' => 'Mailjet.Mailjet',
        'mj_api_key' => 'mailjet-api-key',
	'mj_api_secret' => 'mailjet-api-secret',
	'from' => array('no-reply@my-app.com' => 'My App'),
    );
}
```

## Send Transactional Email templates
To send a transactional template from Mailjet you must set the TemplateID as
custom header param. In this case, all template variables set to viewVars
are available inside the transactional template.

Example usage of Mailjet templating:

```php
$email = new CakeEmail('mailjet');
$email->addHeaders(['TemplateID' => 12345678]);
$email->viewVars(['key' => 'value']);
$email->send();
```
