1) create a .env.local file, then copy .env content and past it in .env.local. Set your database, mailer login infos and developers.facebook acces
2) run composer install
3) run yarn install
4) run bin/console d:d:c
5) run bin/console doctrine:make:migration
6) run yarn encore production
7) enjoy !
