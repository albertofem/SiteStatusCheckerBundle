SiteStatusCheckerBundle
=======================

[![build status](https://secure.travis-ci.org/albertofem/SiteStatusCheckerBundle.png)](http://travis-ci.org/albertofem/SiteStatusCheckerBundle)

Symfony2 bundle to perform site status checks. It was made to use with NewRelic ping service, but can be be used easily with another services (like Nagios).

Installation
------------

Require it in composer:

    composer require albertofem/sitestatuschecker-bundle dev-master

Install it:

    composer update albertofem/sitestatuschecker-bundle

Add it to your bundles:

```php
$bundles = array(
    ...,
    new AFM\Bundle\SiteStatusCheckerBundle\SiteStatusCheckerBundle()
);
```

Usage
-----

1. Configure it:

    site_status_checker:
        token: my_secure_token
        checkers:
            - doctrine

You can register `checkers` referencing services than implements `CheckerInterface`:

```yaml
site_status_checker:
    token: my_secure_token
    checkers:
        - doctrine
        - my_custom_service # CheckInterface implemented
```

There are a number of bundled checkers. You only have to reference them in your checkers by writing their names:

* Doctrine: Performs database connection checks. Usage: `doctrine`

Feel free to extend these checkers replacing it's classes or registering another service and using it instead.

2. Register the controller in your routes:

```yaml
status_checker:
    resource: "@SiteStatusCheckerBundle/Resources/config/routing.yml"
    prefix: /status
```

This will create a route under your prefix: `/status/check/{token}` which will return appropiate response codes:

* `403`: invalid token
* `200`: all checks performed correctly
* `500`: some checks are failling

The response is `application/json` encoded, which contains in it's body the data returned from the checkers. Feel free to use your custom controller to show fancy human readable interface.

You should also put the route under your firewall to prevent unauthorized access.