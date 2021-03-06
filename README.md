### gestImmo
A real estate and tenant manage

**Minimum requirements :**
* composer (global install)
* PHP 7.2.17 (or more)
* HTTPS

**Setup on ubuntu :**
* 1) create a .env.local file, then copy .env content and paste it in .env.local. Set your database, mailer login infos, mailer address and developers.facebook acces
* 2) run composer install
* 3) run yarn install
* 4) run bin/console d:d:c
* 5) run bin/console doctrine:make:migration
* 6) run yarn encore production
* 7) set your facebook OAUTH id and facebook OAUTH secret in .env.local
* 8) active HTTPS (https://www.youtube.com/watch?v=1daMCJeh5yM if you're in localhost), https://doc.ubuntu-fr.org/tutoriel/securiser_apache2_avec_ssl if you've got a domain name and a server
* 9) follow this documentation (https://developers.facebook.com/docs/facebook-login/security#strict_mode) to configure your app on facebook
* 10) run sudo apt-get upgrade -y
* 11) run (sudo) apt-get install xvfb -y
* 12) run (sudo) apt-get install libqt5webkit5 -y
* 13) run (sudo) apt-get install libqt5svg5 -y
* 14) run crontab -e then paste '0 3 1 * * /path/to/your/project/bin/console rent:release' without '' and complete the path to run bin/console rent:release first day of each month at 3 am
* 14) enjoy !

### Langages
* HTML 5
* CSS 3
* JavaScript
* PHP 7.2

### Frameworks
* Bootstrap 4
* Symfony 4 (Doctrine 2 + Twig)

### Versioning
* Git / Git Workflow

### Outils
* PhpStorm
* LXC

### CI
* Travis CI
* Guardrails

### Contributors
* Thomas Coumes - [ThomasCms](https://github.com/ThomasCms)

### Dependencies
* [composer.json](composer.json)
* [package.json](package.json)
