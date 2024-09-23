
@REM effacer les fichiers de migration
del migrations\Version*
@REM effacer la BD
symfony console doctrine:database:drop --force --no-interaction
@REM creer la BD
symfony console doctrine:database:create
@REM creer une migration
symfony console make:migration --no-interaction
@REM lancer la migration
symfony console doctrine:migrations:migrate --no-interaction
@REM lancer les fixtures
symfony console doctrine:fixtures:load --no-interaction

