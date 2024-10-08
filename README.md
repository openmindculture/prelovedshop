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
  - COMPOSER_HOME=/var/cache/composer

### Shopware 6 System Installation

`bin/console system:install --basic-setup`

This installs Shopware and creates a default sales channel with Shopware's default Administration credentials
(admin:shopware). Change these credentials after finishing the installation.

Source: https://developer.shopware.com/docs/guides/installation/template.html#local-installation

Finally, map the webserver root to the `public` folder and open

https://prelovedshop.de/admin

in a browser to finish the installation.

### Troubleshooting

> The HOME or COMPOSER_HOME environment variable must be set for composer to run correctly.

Add `COMPOSER_HOME="/var/cache/composer"` to `.env.local` as [suggested on StackOverflow](https://stackoverflow.com/questions/74317137/shopware-6-the-home-or-composer-home-environment-variable-must-be-set-for-comp)
only when necessary.

> Internal Server Error: Allowed memory size of ... bytes exhausted (tried to allocate ...

- raise the default memory limit for web applications in your virtual host setting
- try to raise the default memory limit in `.htaccess` e.g. `php_value memory_limit 512M` (caused Internal Server Error)
- try to raise it in `php.ini`: `memory_limit=512M` (had no effect)
- try to raise it in `.user.ini`: `memory_limit=512M` (had no effect)
- use the command-line instead of the admin UI and specify the memory limit explicitly
- retry (sometimes, the second try succeeds, maybe thanks to cached partial results of the first try)

#### Activate the Shopware store and install recommended extension

Logging into the shop account to activate the extension store might [fail with different error messages for various reasons](https://stackoverflow.com/questions/74530621/shopware-6-store-activation-causes-generic-error-message-in-admin-ui). Preferably we should use the CLI, not the UI, as well.

- Requirement: the shop domain must be registered in the shopware account (which should have happened when selecting
  "create new shop" in the installation wizard.
- secret requirment: add a "verification hash" using a sw-domain-hash.html, but that file should be generated dynamically
  as soon as a hash has been entered in the backend. (worked: https://prelovedshop.de/sw-domain-hash.html)
- We can try variations of our customer number or credentials, as nobody seems capable of answering
  [how to find one's ShopwareID](https://forum.shopware.com/t/shopware-id-wo-finde-ich-diese/68515/8),
  see [Activate Extension store fails with Internal server error](https://forum.shopware.com/t/activate-extension-store-fails-with-internal-server-error/96605/10). We can try something along those lines (and never use the `--password` to prevent storing it in our bash history):

- `bin/console store:login --user 123456`
- `bin/console store:login -i 123456`
- `bin/console store:login -i kontakt@prelovedshop.de`

Workaround:
- upload plugins using FTP
- install and activate plugins on the command line

## Best Practices

### Shopware Backups and Restore

Shopware state in their update documentation that there is no automatic backup option,
and that users and/or hosters are responsible for creating backups.

A popular option, often recommended in many blogs, is creating an SQL dump and backup all files.

> Make a backup of the MySQL and all your files. It is simple as that. If you want incremental backups,
> make a full file backup and further only store changes.

Source: https://forum.shopware.com/t/full-system-backup-procedure/101439

- `mysqldump -h host -u user -p dbname > backup.sql` (see `.env.local` for database credentials)
- `mysqldump -h host -u user -p --no-tablespaces dbname > backup.sql` (if the above causes an error)
- zip all files: `zip -r backup.zip prelovedshop`
- or use rsync: `rsync -av source_directory target_directory`

We should be able to restore our data:
- `mysql -h host -u user -p dbname < backup.sql`
- `mv prelovedshop prelovedshop_renamed && unzip backup.zip`

No matter what you did, always clear the cache at the end:
- `bin/console cache:clear`

### Shopware Customization

#### Add common product properties

How to add fields to specify size, color, or ISBN easily in a recommended or common way (without variations)?

- Add appropriate properties in the UI or keep helpful ones when deleting demo data.
- Shouldn't we better ensure them programmatically in a plugin, like we did with cost transparency?

#### Show a selection of all products on the home page

- use dynamic product groups

### Shopware Test Automization

### Shopware Web Performance and Sustainability

### Frontend Accessibility: [WCAG (Web Content Accessibility Guidelines)](https://de.wikipedia.org/wiki/Web_Content_Accessibility_Guidelines) and SEO

## Roadmap

- [x] register domain
- [x] release placeholder text with backlinks
- [x] install and configure shop and extensions
- [ ] add example content and customization
- [ ] run audits and document results (Lighthouse, WAVE, WebPageTest, WebsiteCarbon, Green Web Check, Domain Authority)
- [ ] list and link the shop website to increase incoming backlinks
- [ ] add and verify payment methods
- [ ] localize shop (German and English)
- [ ] add more products