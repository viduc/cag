Viduc/Cag
=======


AUTEUR
------
[![Viduc](https://www.shareicon.net/data/48x48/2016/01/02/229394_cylon_256x256.png)](https://github.com/viduc)
[![Mail](https://www.shareicon.net/data/48x48/2016/03/20/444954_mail_200x200.png)](mailto:viduc@mail.fr?subject=[GitHub]%20Source%20Han%20Sans)

STATUT
------
[![Software License](https://img.shields.io/badge/license-GPL%20V3-blue.svg?style=flat-square)](gpl-3.0.md)
[![Maintainability](https://api.codeclimate.com/v1/badges/b2d03518588df2109640/maintainability)](https://codeclimate.com/github/viduc/cag/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b2d03518588df2109640/test_coverage)](https://codeclimate.com/github/viduc/cag/test_coverage)

LICENSE
-------

Copyright [2020] [Tristan FLeury]

Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

    https://www.gnu.org/licenses/gpl-3.0.fr.html

The GNU General Public License is a free, copyleft license for
software and other kinds of works.

The licenses for most software and other practical works are designed
to take away your freedom to share and change the works.  By contrast,
the GNU General Public License is intended to guarantee your freedom to
share and change all versions of a program--to make sure it remains free
software for all its users.  We, the Free Software Foundation, use the
GNU General Public License for most of our software; it applies also to
any other work released this way by its authors.  You can apply it to
your programs, too.

CLEAN ARCHITECTURE GENERATOR - CAG
-------
Le projet CAG permet de créer une structure de développement en se basant sur les principes de l'architecture hexagonale.

Celle ci permet d'isoler totalement le code métier du reste du projet (infrastructure, base de données, librairies etc...).

Le projet est à installer au sein de votre framework en mode développement.

Une fois votre projet créé, il est conseillé de supprimer cag, il ne sera plus utilisé par la suite:


LANGAGE
-------
![badge](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/viduc/0b7d92547a358f4b3cf944145315170f/raw/php_8.0.json)
![badge](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/viduc/47feab281f5de327b2a210b785710946/raw/php_8.1.json)
![badge](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/viduc/e67a73e720803cc15d12339389d7d0c2/raw/php_8.2.json)

PROJECT
-------


INSTALLATION
-------

    composer remove viduc/cag

SUPPRESSION
-------

    composer require viduc/cag --dev

Créer un nouveau projet:
-------
Ouvrez un terminal à la racine de votre projet et entrez cette commande:

`php ./vendor/bin/cag project create`

1. Choisissez un nom pour votre projet (ex Domain, Job...), Il sera utilisé comma namespace pour vos class.
2. Choisissez un path pour votre projet, ce sera le dossier dans lequel tout les fichiers et dossiers seront créés.
3. Choisissez si vous souhaitez ajouter votre projet à l'autoload de composer. Si vous ne savez pas choisissez oui par défaut. Cette action modifiera votre composer.json en ajoutant le namespace à la paprtie autoload/PSR4.
4. Enfin acceptez de créer le projet

![create_project.png](.%2FDocumentation%2Fcreate_project.png)