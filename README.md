
Objectif

L'objectif de ce projet était (a la base) de recréer un réseau social comme twitter en utilisant Symfony pour pouvoir s'incrire/ participer à des évenemenent sportifs de tous type que ce soit local où international.

Les Etapes à suivres pour installer le projet:

Installer PHP 7.2
sudo apt-get update
sudo apt-get install php7.2-cli php7.2-xml php7.2-curl zip

Installer MariaDB et créer un utilisateur

sudo apt-get install mariadb-server
sudo service mysql start

sudo mysql -uroot
USE mysql;
DELETE FROM user WHERE user = "";
CREATE USER "#USERNAME#"@"%" IDENTIFIED BY "#PASSWORD#";
GRANT ALL PRIVILEGES ON *.* TO "#USERNAME#"@"%";
FLUSH PRIVILEGES;
exit;

Maintenant on en vient à l'étape de cloner le projet

clone git@github.com:tentacode-classroom/twitter-mais-sportevents.git

Va a l'intérieur du dossier du projet que tu viens juste de cloner et effectue les commandes suivantes:
composer i

Tu n'as plus qu'à installer le projet
php bin/console app:install
