
# Atelier Symfony : Spécial ArchLinux & MariaDB

## Installation

Activer l'AUR:

Installer PHP, composer, mariadb et npm
```
# pacman -Syu php composer nodejs npm mariadb
```

Installer Symfony CLI sur l'AUR
```
$ yay -S symfony-cli
```

Ajouter les extensions nécessaires dans `/etc/php/php.ini`
```ini
extension=iconv
extension=ext-inconv
```


Installer les paquets npm et les dépendances composer
```sh
$ npm install
$ composer install
```

## Configuration de MariaDB

Selon le [wiki](https://wiki.archlinux.org/title/MariaDB), configurer MariaDB comme ça
```
# mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql
# systemctl enable --now mariadb
```

Créer un utilisateur pour gestion_conges_stats
```
# mariadb -u root -p
MariaDB> CREATE USER 'conges'@'localhost' IDENTIFIED BY 'some_pass';
MariaDB> GRANT ALL PRIVILEGES ON conges.* TO 'conges'@'localhost';
MariaDB> quit
```

Dans le fichier env, changer le DATABASE_URL:
```ini
DATABASE_URL="mysql://conges:some_pass@127.0.0.1:3306/conges"
```

Dans config/packages/doctrine.yaml, activer mysql
```yaml
doctrine:
    dbal:
        driver: 'pdo_mysql'
        url: '%env(resolve:DATABASE_URL)%'
```

Vérifier le schéma 
```
$ symfony console doctrine:schema:validate
```

Si ça marche pas (dangereux)
```
$ symfony console doctrine:schema:update --force
```

## Charger les fixtures
```
$ symfony console doctrine:fixtures:load
```

## Servir
Démarrer le serveur
```
$ symfony serve
```