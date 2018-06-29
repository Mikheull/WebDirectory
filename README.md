# WebFolderInterface

Ce fichier sert a remplacer l'apparence des explorateurs de fichiers de base des navigateurs.
Il vous suffit simplement de le glisser dans vos dossiers, puis en ouvrant la page du dossier sur un naviguateur vous verrez la nouvelle apparence

La page requiert FontAwesome pour quelques icons, 
Vous pouvez modifier les couleurs, polices etc..

```css
<style>
    body, html {font-family: "Tahoma";background: #FDFDFD;color: #2A2A2A}
    .index {color: #b34f36;font-size: 20px;margin: 2vh 2.5vw}
    .index span {font-style: italic}

    .item {width: 100%;float: left}
    .item li {float: left;margin: 15px 1vw;border-radius: 3px;border: solid 1px rgba(58, 58, 58, 0.3);height: 30px;min-width: 10vw;line-height: 30px}
    .item li span {color: brown;margin: 0 5px}
    .item .time, .item .size {float: right;line-height: 30px;color: rgba(51, 51, 51, 0.8);padding: 0 10px}
</style>
```
