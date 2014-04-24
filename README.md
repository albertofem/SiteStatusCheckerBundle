SiteStatusCheckerBundle
=======================

[![build status](https://secure.travis-ci.org/albertofem/SiteStatusCheckerBundle.png)](http://travis-ci.org/albertofem/SiteStatusCheckerBundle)

Symfony2 bundle to perform site status, relying on `LiipMonitorBundle`. It's specifically made for ping services, like the one from New Relic.

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
    new \Liip\MonitorBundle\LiipMonitorBundle(),
    new \AFM\Bundle\SiteStatusCheckerBundle\SiteStatusCheckerBundle()
);
```

Usage
-----

### Configure `LiipMonitorBundle`

Please referer to the bundle documentation: https://github.com/liip/LiipMonitorBundle

### Configure it:

```yaml
site_status_checker:
    token: my_secure_token
```

### Register the controller in your routes:

```yaml
status_checker:
    resource: "@SiteStatusCheckerBundle/Resources/config/routing.yml"
    prefix: /status
```

This will create a route under your prefix: `/status/check/{token}` which will return appropiate response codes:

* `403`: invalid token. Body content: `KO`
* `200`: all checks performed correctly. Body content: `OK`
* `500`: some checks are failling. Body content: `KO`