# prelovedshop

Shopware 6 proof of concept and public beta testing page for themes and extensions.

Maintainer: [Ingo Steinke, web developer](https://www.ingo-steinke.com/), 
[certified Shopware Developer](https://www.ingo-steinke.com/services/certified-shopware-developer-berlin.html) 
and [Shopware Extension Partner](https://store.shopware.com/en/search?manufacturer=a6c4febdaf702cfcbef6008a43ab8476&search=ingo%20steinke&properties=00b8a0c9aacf4e8b4e085afe3819df45|ca1b9eb6b5f340b3b53694d0858e727f|cea1dbd38c8fc53eafa1a66a421897c8&isManufacturerPage=true).

Public beta: https://prelovedshop.de/

This repository contains concepts, placeholder text, and customizations.

Reusable customizations should be moved to independent modules:

## Requirements, Dependencies, Recommendations

- Shopware 6 Installation/Hosting
  - mySQL ("Distrib" server version in `mysql --version`) 8 +
  - PHP 8.2 + (check `php -v`)
  - PHP memory_limit : 512M minimum (check `php -i | grep memory_limit`)
  - PHP extensions, see [installation requirments](https://developer.shopware.com/docs/guides/installation/requirements.html)
  - composer (check `composer -v`)
- Shopware 6 Development
  - [Cost Transparency](https://github.com/openmindculture/sw-IngoSCostTransparency) extension
  - [Masonry theme](https://github.com/openmindculture/sw-IngoSMasonryTheme)
  - [Cypress](https://www.cypress.io/)
  - PhpStorm with
    - 👍 [Symfony Support](https://plugins.jetbrains.com/plugin/7219-symfony-support) is another commercial extension, 
    - but [Shyim](https://shyim.me/), one of Shopware's most renowned developer, recommended it recently (in 2024).
    - 👍 [Shopware 6 Toolbox](https://plugins.jetbrains.com/plugin/17632-shopware-6-toolbox) is released and maintained 
    - by Shyim and it's free and open source software.

Further reading:
[Shopware dev productivity and plugin validation](https://dev.to/ingosteinke/shopware-dev-productivity-and-plugin-validation-14jm)

## Configuration and Installation

### Preparation

Developers should prefer the command-line to web installers/updaters for more control and detailed information.

Start in an empty directory which is accessbile from a browser, and have a fresh SQL database ready.

It might be necessary to call a specific PHP interpreter if `php -v` does not meet the required minimum version, e.g.

`/usr/local/phpfarm/inst/php-8.2.18/bin/php`

This might make it necessary to call `composer` with its full path.

Consequently, we must use the full PHP path for `bin/console` as well!

We might also need to increase the defaul memory limit by adding `-d memory_limit=512M`.

We might want to define an alias e.g. 

`alias php82='/usr/local/phpfarm/inst/php-8.2.18/bin/php -d memory_limit=512M'`

### Composer Configuration

Use composer to generate the configuration and install it

`/usr/local/phpfarm/inst/php-8.2.18/bin/php /usr/local/bin/composer create-project shopware/production .`

`/usr/local/phpfarm/inst/php-8.2.18/bin/php /usr/local/bin/composer install`

Verify that `bin/console` is ready to use:

`/usr/local/phpfarm/inst/php-8.2.18/bin/php bin/console` should print available command, but no error message.

Then edit the configuration before proceeding to install Shopware.

### System Configuration

As of Shopware version 6.5.0.0, the described changes should be made in the .env.local file instead of the .env file.
With Shopware 6.4.17.0 the MAILER_DSN variable will be used in this template instead of MAILER_URL.
([Shopware docs: notes to the APP_URL](https://docs.shopware.com/en/shopware-6-en/tutorials-and-faq/notes-to-the-APP-URL))
DATABASE_URL example taken from a [forum thread](https://forum.shopware.com/t/nach-db-wechsel-could-not-connect-to-database/102408).
If the database password contains special characters, they must 
[be escaped in the .env file](https://forum.shopware.com/t/datenbank-passwort-in-der-env-richtig-escapen/91906).

The secret `.env` files must be ignored by git to prevent publicly exposing server secrets.

```
# Secrets
.env
.env.local
```

- `.env.local`
  - APP_ENV=prod 
  - APP_URL=https://prelovedshop.de
  - DATABASE_URL=mysql://121409m93862_4:db_pass@localhost:3306/121409m93862_4
  - MAILER_DSN=smtp://localhost:465?encryption=ssl&auth_mode=login&username=&password=

### Shopware 6 System Installation

Command with explicit paths and parameters:

`/usr/local/phpfarm/inst/php-8.2.18/bin/php -d memory_limit=512M bin/console system:install --basic-setup`

Short version:

`bin/console system:install --basic-setup`

This installs Shopware and creates a default sales channel with Shopware's default Administration credentials
(admin:shopware). Change these credentials after finishing the installation.

Source: https://developer.shopware.com/docs/guides/installation/template.html#local-installation

## Best Practices

- Shopware customization
- Shopware backups
- Shopware test automization
- Shopware web performance and sustainability
- Frontend accessibility: [WCAG (Web Content Accessibility Guidelines)](https://de.wikipedia.org/wiki/Web_Content_Accessibility_Guidelines)

## Roadmap

- [x] register domain
- [x] release placeholder text with backlinks
- [ ] install and configure shop and extensions
- [ ] add example content and customization
- [ ] run audits and document results (Lighthouse, WAVE, WebPageTest, WebsiteCarbon, Green Web Check, Domain Authority)
- [ ] list and link the shop website to increase incoming backlinks
- [ ] add and verify payment methods
- [ ] localize shop (German and English)
- [ ] add more products