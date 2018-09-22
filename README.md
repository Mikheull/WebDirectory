# WebDirectory

**WebDirectory** est un explorateur de fichiers/dossiers pour le web. Avec cet outil vous pourrez naviguez facilement entre vos dossiers, et créer autant de fichiers/dossiers que vous voulez directement depuis votre page web.
Vous pourrez également faire des actions sur les fichiers ( dupliquer, supprimer, télécharger )
**WebDirectory** a été conçu pour plaire au maximum de gens, de ce fait il est configurable vous pouvez choisir un thème d'explorateur (dark, light, modern ..) ou mettre un des votres, changer le pack d'icon et la traduction de l'outil.
<br>

#### Requirements :
* Php server


<br><hr>
#### Installation :
Pour l'installation rien de plus simple, télécharger le fichier [index.php](https://raw.githubusercontent.com/Mikheull/WebDirectory/master/index.php) et glisser le simplement dans les dossiers ou vous voulez avoir le **WebDirectory** .
Voilà c'est tout, le script, par la suite, s'occupera de télécharger les fichiers dépendants tout seul.


#### Configuration :
Une grande partie de l'outil est ouvert a la configuration pour vous permettre d'avoir votre version de **WebDirectory** parfaite.
*toutes les configurations se font en haut de la page index.php*

1) Thème :<br>
*Installez le thème qui vous plait, ou créer le votre*
```php
$theme = "dark";
```
- [x] dark
- [x] light
- [ ] modern
<br>

2) Format de la date :<br>
*modifiez votre format*
```php
$format_date = "j-n-Y H:i:s";
```
*documentation du format ici -> http://php.net/manual/fr/function.date.php*
<br>

3) Pack d'icon :<br>
*personnalisez vos icons de fichiers*
```php
```
<br>

4) Traductions :<br>
*prenez votre langage favoris*
```php
```
<br><hr>

#### TO-DO :
- [x] affichage des fichiers/dossiers
- [x] support des icons de fichiers
- [x] fonction de retour en arriere
- [x] création de dossier
- [x] création de fichier
- [ ] securité sur la création de dossiers/fichiers
- [ ] supprimer un élément
- [ ] renommer un élément
- [ ] dupliquer un élément
- [ ] télécharger un élément
- [ ] ajouter les traductions
- [ ] ajouter les packs d'icons
- [ ] faire le thème modern
- [ ] ajouter des nouveaux thèmes
- [ ] faire le menu d'aide
- [ ] ajouter les raccourcis clavier
