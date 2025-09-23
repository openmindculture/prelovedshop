# prelovedshop

E-commeerce proof of concept and public beta testing page for software, themes and extensions.

Current evaluation round: WooCommerce

Since September 2025, prelovedshop runs on WordPress and WooCommerce with a minimally modified Twenty Twenty-Five Child theme based on [wp_block_theme_child](https://github.com/openmindculture/wp_block_theme_child) which is now its upstream source code repository.

Demo content is partially placeholder text, Wikipedia material, and partially actual second-hand products that are or were for sale as individual items, like a pair of black boots, a red designer chair, and a fairly used set of loudspeaker boxes, as well as a piece of Aleppa soap that also serves as a semi-realistic example for using right-to-left written arabic text.

Maintainer: [Ingo Steinke, web developer](https://www.ingo-steinke.com/), Berlin.

TODO: link blog post about evaluating alternative open-source (or freemium) self-hosted e-commerce solutions.

## Prestashop vs. Shopware vs. WooCommerce

Public beta: https://prelovedshop.de/

### History, Archives

- WooCommerce (2025)
- PrestaShop (2025)
- Shopware (2024)
- [Placeholder](https://web.archive.org/web/20241113091206/https://www.prelovedshop.de/) (2024)

### WordPress Setup

Create a ZIP archive file of the contents of `themes/twentytwentyfive-child` as `prelovedshoptheme.zip` and upload it in the `wp-admin` WordPress backoffice dashboard.

You can use a local Docker-based WordPress installation for development and preview, as described in the [wp_block_theme_child](https://github.com/openmindculture/wp_block_theme_child) repository.

A local installation _might_ run on

http://localhost:9750 (as in 975 = PLS)

after successful setup.

### Prestashop Setup

Create a ZIP archive file of the contents of `prestashop/child_classic` as `child_classic.zip`, upload and activate as shop theme.

### Shopware Setup

Maintainer: [Ingo Steinke, web developer](https://www.ingo-steinke.com/),
[certified Shopware Developer](https://www.ingo-steinke.com/services/certified-shopware-developer-berlin.html)
and [Shopware Extension Partner](https://store.shopware.com/en/search?manufacturer=a6c4febdaf702cfcbef6008a43ab8476&search=ingo%20steinke&properties=00b8a0c9aacf4e8b4e085afe3819df45|ca1b9eb6b5f340b3b53694d0858e727f|cea1dbd38c8fc53eafa1a66a421897c8&isManufacturerPage=true).

For local development, run a dev setup like dockware like the one preconfigured for [sw-IngoSMasonry theme](https://github.com/openmindculture/sw-IngoSMasonryTheme).

This repository contains concepts, placeholder text, and customizations.

Reusable customizations should be moved to independent modules.

#### Shopware Requirements, Dependencies, Recommendations

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

#### Shopware Configuration and Installation

##### Preparation

Developers should prefer the command-line to web installers/updaters for more control and detailed information.

Start in an empty directory which is accessbile from a browser, and have a fresh SQL database ready.

It might be necessary to call a specific PHP interpreter if `php -v` does not meet the required minimum version, e.g.

`/usr/local/phpfarm/inst/php-8.2.18/bin/php`

This might make it necessary to call `composer` with its full path.

Consequently, we must use the full PHP path for `bin/console` as well!

We might also need to increase the defaul memory limit by adding `-d memory_limit=512M`.

We might want to define an alias e.g.

`alias php82='/usr/local/phpfarm/inst/php-8.2.18/bin/php -d memory_limit=512M'`

##### Shopware Composer Configuration

Use composer to generate the configuration and install it

`/usr/local/phpfarm/inst/php-8.2.18/bin/php /usr/local/bin/composer create-project shopware/production .`

`/usr/local/phpfarm/inst/php-8.2.18/bin/php /usr/local/bin/composer install`

Verify that `bin/console` is ready to use:

`/usr/local/phpfarm/inst/php-8.2.18/bin/php bin/console` should print available command, but no error message.

Then edit the configuration before proceeding to install Shopware.

##### Shopware System Configuration

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

##### Shopware 6 System Installation

`bin/console system:install --basic-setup`

This installs Shopware and creates a default sales channel with Shopware's default Administration credentials
(admin:shopware). Change these credentials after finishing the installation.

Source: https://developer.shopware.com/docs/guides/installation/template.html#local-installation

Finally, map the webserver root to the `public` folder and open

https://prelovedshop.de/admin

in a browser to finish the installation.

##### Shopware Troubleshooting

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

###### Activate the Shopware store and install recommended extension

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

#### Shopware Best Practices

##### Shopware Backups and Restore

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

##### Shopware Customization

###### Add common product properties

How to add fields to specify size, color, or ISBN easily in a recommended or common way (without variations)?

- Add appropriate properties in the UI or keep helpful ones when deleting demo data.
- Shouldn't we better ensure them programmatically in a plugin, like we did with cost transparency?

#### Show a selection of all products on the home page

- use dynamic product groups

##### Shopware Test Automization

##### Shopware Web Performance and Sustainability

##### Frontend Accessibility: [WCAG (Web Content Accessibility Guidelines)](https://de.wikipedia.org/wiki/Web_Content_Accessibility_Guidelines) and SEO

## Roadmap

- [x] register domain
- [x] release placeholder text with backlinks
- [x] install and configure shop and extensions
- [x] add example content and customization
- [x] run audits and document results (Lighthouse, WAVE, WebPageTest, WebsiteCarbon, Green Web Check, Domain Authority)
- [x] list and link the shop website to increase incoming backlinks
- [ ] add and verify payment methods
- [ ] localize shop (German and English)
- [ ] add more products
- [x] test alternative software: Prestashop
- [ ] test alternative software: WooCommerce

# Generic Upstream Documenation

## WordPress Block Theme Child Template

[wp_block_theme_child](https://github.com/openmindculture/wp_block_theme_child) is a local host WordPress setup using Docker, docker-compose, and wp-cli
to install themes and plugins, including a simple template skeleton for a Twenty-something child
theme using the template engine (`theme.json`), block editor and full-site editing.

## TODO / Work in Progress

This is an unfinished stub, based on `wp_cli_docker` (see below). Ideas and learning takeaways from other (open source) projects should be ported back to and collected in this repository.

## White Label / Template Customization

### zip and ship

There is **no build step**, unless you need custom blocks, you can zip and ship the theme folder as it is. This also means that you cannot use SCSS, TypeScript, or any other experimental synatx that is not widely supported by major browsers (see MDN or caniuse if in doubt).

### fork or add Upstream

To use this repository as a template for a new WordPress theme, fork it on GitHub or set it as a remote upstream of an existing project. Modify the `twentytwentyfive-child` theme according to your (customers') requirements.

- `git remote add upstream git@github.com:openmindculture/wp_block_theme_child.git`

Use `git remote -v` to verify (or list) the configured remote repositories.

To synchronize/pull upstream updates, we can use it similar to working with branches:

- `git fetch upstream`
- `git merge upstream/main --allow-unrelated-histories`

### WP child theme with custom title

You can change the display name and screenshot to make the theme appear as an individual customer theme, while the technical name (textdomain) stays twentytwentyfive-child making it a child theme of the official WordPress theme Twenty Twenty-Five.

### multiple inheritance, sort of

Effectively, you will have two upstreams providing you with updates: twentytwentyfive (at run time via WordPress updates) and this template respository, `wp_block_theme_child`, only when you chose to check and pull updates into your forked/downstream version.

### example content

The example-content directory contains code that you can paste in code mode to fill three example pages, plus four blog posts three of which will be featured on the home page.

Example content might mix German and English examples, as well as classic Lorem Ipsum placeholder text, and some Japanese, Ukrainian and Arabic sample text to ensure multiple character sets and writing directions are supported correctly.

"Blog" is often called "news", but we can stick to the built-on blog `post` post type. Even when we think we need different post types, this might get done using categories.

Product examples are inspired by actual second hand items that I used to offer at [Prelovedshop](https://www.prelovedshop.de/) , Kijiji, and Kleinanzeigen, as well as public open source content from Wikipedia, the free encyclopedia.

### optional plugin options

Recommendations based on small customer projects in recent years:

- Akismet
- Contact Form 7
- Display Featured Image in Post List
- Incompatibility Status
- Polylang
- Post Types Order
- UpdraftPlus
- WooCommerce
- Yoast (WP-SEO)

and any image optimization and/or caching plugin, unless your (managed) host already provides that functionality.

Polylang is a proven plugin for multi-language localization, especially for small sites that might be fine using the free version.

Contact Form 7, Updraft Plus, and W3 Total Cache are proven plugins that used to work well for small sites even without a paid pro license.

WooCommerce is fine for a small shop that doesn't need much customization, otherwise you might want to consider alternatives that allow for more customization and performance optimization. Likewise, you should check out alternatives to other plugins suggested above.

### minimalism and best practices

Adhere to WordPress best practices, apply minimal changes and prefer content and configuration over modification to avoid conflicting side effects of any future update!

## Repository Usage

### Initial Setup

Run
- `npm install`
- `docker compose up --build`
- open http://localhost:8026/wp-admin (replace `8026` with the configured port) in your browser.
- Log in with the default demo credentials (user: `admin`, password: `secret`).

The following directories are mounted below the project root directory by default:

- plugins
- themes
  - themes/twentytwentyfive-child
- wp_data

They are set to be ignored in `.gitignore`, except for the child themes.

Check an edit your IDE settings to exclude or exclude these directories for search / indexing. Edit write permissions
if necessary before editing the child theme, e.g.

```
sudo chown -R your_username:your_group themes
sudo chmod -R ug+rw themes
```

Likewise, we might have to explicitly allow uploads by clients:

`sudo chmod -R ugo+rwx wp_data/uploads`

Most warnings can be safely ignored, especially warnings about deprecations and vulnerabilities at development time, as we only ship minimal custom code, no keys or production passwords, and shouldn't normally be affected by any memory leaks due to the limited number of files and directory depth.

#### Redirect Issue

If you keep getting redirected to a wrong localhost port,
- ensure that all ports are configured correctly in `docker-compose.yml`

and try

- shutting down the setup: `docker compose down -v`
- optionally clean up any other docker related data
- alternatively, try another browser as it might be a caching issue
- try adding `/wp-admin` to prevent the frontend redirect

#### WordPress Updates

If there is a more recent WordPress version that in the `wordpress:latest` Docker image, you should be able to update the local system in your `wp-admin` dashboard.

### Start, Stop, Destroy

- `npm start` (re)starts the local WordPress server
- `npm stop` will retain local data after stopping
- `npm run destroy` stops and removes local data

## Customization

- functions.php
- screenshot.png
- style.css
- theme.json

optionally:
- custom assets (fonts, images)
- custom scripts
- custom blocks, block variations, or template parts

## Further Reading, Alternatives, and Known Issues

### References

#### theme.json Reference (WordPress.org)

https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/

#### theme.json Font Definition

https://fullsiteediting.com/lessons/theme-json-typography-options/#using-the-web-fonts-api-with-theme-json

TODO: check for updated possibilities and best practices like WP font API

Font choice: many commercial fonts have slightly similar alternatives that might be good enough for a startup with limited budget, like using Nunito instead of Avenir or Futura. Note that there are at least two different Nunito designs, so don't use the rounded one when looking for the classic (retro-)futuristic style.

Popular pairings include Lora, Alegreya, Roboto and Open Sans. Noto is known as a minimalist sans-serif font that supports as many international languages as possible.

Markazi Text is a free font found on Google Fonts useful for an elegant but readable Arabic business site. Roman letters have serifs and a similar overall appearance. Use the Aleppo Soap example product for a preview.

Atkinson Hyperlegible might look a little too technical for marketing puropose, however it was designed for maximum legibility in the sense of accessibility and glyph disambiguation.

The example theme uses a combination of Markazi and Nunito, the latter only used for second-level sub-headlines for the sake of demonstrating how to provide different default web fonts in a theme.

#### full site editing child themes

https://fullsiteediting.com/lessons/child-themes/

### Origin and Alternatives

This respository was based on a fork of [wp_cli_docker](https://github.com/openmindculture/wp_cli_docker) and follows the opposite direction of the classic / hybrid
[wp_template_opinionated](https://github.com/openmindculture/wp_template_opinionated) theme template.

### Issues

The child template is an incomplete stub including references to non-existing assset files in
`themes/twentytwentythree-child/theme.json`. The theme needs to be edited and verified!

The installation script has been conceived to work anywhere, but it has actually been tested and used mostly on Ubuntu Linux. There have been configuration and performance issues especially on slow Windows WSL Docker systems.

![screenshot](doc/screenshot-themes.png)

## Requirements

- npm
- Docker (incl. Docker compose)

## Development Setup Configuration

### Configure pre-installed Themes and Plugins

Modify [install-local-environment.js](./install-local-environment.js) to select which themes and plugins will be installed automatically using `wp-cli`.
You must specify the technical names (text domains), not the current titles! The technical names are the same as the
directory names in the plugin paths.

```js
/* specify the technical names (text domain) of plugins to be installed */
'wp plugin install --activate incompatibility-status';
```

Some commercial / paid plugins cannot be installed automatically. They have to be uploaded or installed manually later.

### Configure WordPress Core, Web Server, PHP Version used

Modify [docker/WordPress.Dockerfile](./docker/WordPress.Dockerfile) to choose one of various predefined configurations using different PHP versions
like 7.4, 8.0, 8.1 etc. and popular web servers like Apache or nginx to copy our customer's web hosting provider's
technical setup as good as possible.

See https://hub.docker.com/_/wordpress/ for available docker tags, or keep `wordpress:latest` for the newest (latest) stable release.

```Dockerfile
FROM wordpress:latest
# use other tags in docker/wordpress.Dockerfile to test specific versions, see
# https://hub.docker.com/_/wordpress/
# FROM wordpress:6.1.1-php8.0-apache
```

### Technical Notes

The `copyfiles` module causes a warning about its `inflight` dependency which is officially deprecated due to an alleged memory leak. However, for a small project like this with less than a hundred files in total in a handful of directories nested no deeper than three levels, the severity is likely minimal or negligible.

## Preview (seriously, you should replace that image)

![screenshot](themes/twentytwentyfive-child/screenshot.png)

TODO: replace that ugly placeholder image with a beautiful screenshot of your actual theme!