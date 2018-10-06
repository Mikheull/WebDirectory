# WebIE

![alt text](https://i.imgur.com/rWCAkUe.png "Logo Title Text 1") <br><br>
[WebIE](https://mikhaelbailly.fr/tools/WebIE) est un explorateur de **fichiers** / **dossiers** pour le web. <br>
Il inclus une multitude d'outils utiles pour la gestion de vos fichiers <br>

Features
------
- Liste de tout les fichiers du répertoire
- Outil de création de fichiers
- Outil de gestion de fichiers
- Raccourcis claviers
- Système d'authentifications
- Multi-langage ( customisable )
- Multi-thème ( customisable )
<br><br>

Requirements
------
- Un serveur php
- Des fichiers
<br><br>

Installation
------
Pour l'installation, il vous suffit **uniquement** de télécharger le fichier [index.php](https://github.com/Mikheull/WebIE/blob/master/index.php) et de l'ajouter dans les répertoires voulus.
<br><br>

Configuration
------
Une **très grande** partie de **WebIE** est ouverte a la configuration, pour vous permettre d'avoir votre version parfaite.<br>
*Les configurations sont remises par défaut lors d'une mise a jour*


**1. Les thèmes** <br>
*Installez le thème qui vous plait, ou créez le votre* <br>
remplacer **value** par un thème parmis ceux ci-dessous
- [x] dark
- [x] light
- [x] blue
- [x] red
- [x] green
- [x] orange
- [x] purple
- [x] yellow

ou bien par **custom** pour définir le votre. Si vous choisissez **custom** vous devrez indiquer votre lien. 

**Syntaxe**
```php
define('theme', 'value')
```
**Exemple**
```php
define('theme', 'dark')
```
**UNIQUEMENT POUR LES CUSTOM**
```php
define('theme_custom_link', 'https://votre-lien.fr')
```

<br><br> 
**2. Le format de date** <br>
*Modifiez votre format de date, une documentation est disponible [ici](http://php.net/manual/fr/function.date.php)* <br>
remplacer **value** par votre patern

**Syntaxe**
```php
define('date_format', 'value')
```
**Exemple**
```php
define('date_format', 'j-n-Y H:i:s')
```

<br><br> 
**3. Les icons de fichiers** <br>
*Personnalisez vos icons de fichiers*
remplacer **value** par un pack disponible ci-dessous **(soon)**

**Syntaxe**
```php
define('icon_pack', 'value')
```
**Exemple**
```php
define('icon_pack', 'font-awesome')
```

<br><br> 
**4. Les messages** <br>
*Prenez votre langage favori*
remplacer **value** par un langage disponible ci-dessous
- [x] FR
- [x] EN
- [x] ES
- [x] AL
- [x] IT

ou bien par **custom** pour définir le votre. Si vous choisissez **custom** vous devrez indiquer votre lien. 

**Syntaxe**
```php
define('langage', 'value')
```
**Exemple**
```php
define('langage', 'FR')
```
**UNIQUEMENT POUR LES CUSTOM**
```php
define('langage', 'https://votre-lien.fr')
```

<br><br> 
**5. Quelques réglages** <br>
*Activer / Désactiver des options*
remplacer **value** par un true (oui) ou false (non)

**Syntaxe**
*Outil de création de fichiers*
```php
define('file_creator', 'value')
```
*Outil de création de dossiers*
```php
define('folder_creator', 'value')
```
*Outil de gestion de fichiers*
```php
define('element_edit', 'value')
```
*Affichage de notifications*
```php
define('notifications', value);
```

<br><br> 
**6. Authentification** <br>
*Ajouter une authentification*
remplacer **value** par true (oui) ou false (non)

**Syntaxe**
```php
define('auth', 'value')
```
**Exemple**
```php
define('auth', 'false')
```

remplacer **value** par un mot de passe sécurisé

**Syntaxe**
```php
define('token', 'value')
```
**Exemple**
```php
define('token', 'MmPq04rSA24N0aS4')
```

<br><br> 
**7. Les notifications** <br>
*Configurez vos notifications*
remplacer **value** par une position disponible ci-dessous
- [x] top-left
- [x] top-center
- [x] top-right
- [x] bottom-left
- [x] bottom-center
- [x] bottom-right

**Syntaxe**
```php
define('notifications_position', 'value')
```
**Exemple**
```php
define('notifications_position', 'top-center')
```

---
#### Developers



### TO-DO :
- [x] affichage des fichiers/dossiers
- [x] support des icons de fichiers
- [x] fonction de retour en arriere
- [x] création de dossier
- [x] création de fichier
- [x] ajouter les traductions
- [x] faire le menu d'aide
- [x] ajouter les raccourcis clavier
- [x] editer les réglages de configuration directement dans WebIE
- [x] effectuer une mise a jour
- [x] ajouter des nouveaux thèmes
- [x] créer la possibilité d'ajouter un theme custom 
- [x] créer la possibilité d'ajouter un langage custom 
- [x] supprimer un élément
- [x] archiver un élément (accessible dans une liste cachée en bas de page)
- [x] dupliquer un élément
- [x] télécharger un élément
- [x] ajouter un système d'authentification (désactivable)
- [x] securité sur la création de dossiers/fichiers
- [x] ajouter des popups ( d'erreur, de succes, de confirmations )
- [ ] trier les listes
- [ ] detecter les mise a jour et mettre un message en cookie
- [ ] ajouter un système de recherche (bouton, CTRL F)
- [ ] renommer un élément
- [ ] ajouter les packs d'icons
- [ ] ajouter plus de compatiblité d'icons de fichiers
- [ ] cloner un fichier / dossier dans un AUTRE dossier
- [ ] améliorer la vitesse d'affichage, afficher uniquement des divs vides au début, puis les remplir avec le chargement
- [ ] intégrer GoogleDrive, Dropbox et GitHub pour stocker les fichiers/dossiers
- [ ] rendre compatible tout navigateur, tout OS
- [ ] rendre responsive l'outil
- [ ] créer le site de presentation de cet outil (page github)
