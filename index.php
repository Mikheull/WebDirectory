<?php
/**
 * modification du thème de la page
 * vous pouvez utiliser un des thèmes disponibles en changeant par ( dark - light - modern )
 * ou bien en choisir un custom en changeant par ( custom ) et en indiquant le lien du fichier css ci-dessous
 * 
 */
define('theme', 'dark');
define('theme_custom_link', 'https://votre-lien.fr');

/**
 * modification du format de la date
 * vous pouvez sélectionner votre propre format de date (Jour/Mois/année par exemple)
 * documentation du format ici -> http://php.net/manual/fr/function.date.php
 * 
 */
define('date_format', 'j-n-Y H:i:s');

/**
 * modification des messages
 * vous pouvez sélectionner le langage qui vous convient en changeant par ( FR - EN - ES - AL (voir les langages sur le github))
 * ou bien installer le votre en changeant par ( custom ) et en indiquant le lien du fichier ci-dessous
 * 
 */
define('langage', 'FR');
define('langage_custom_link', 'https://votre-lien.fr');

/**
 * modification du pack d'icons
 * 
 */
define('', '');

/**
 * quelques réglages
 * 
 * 
 */
define('cdn_link', 'https://cdn.rawgit.com/Mikheull/WebDirectory/master/');
define('', '');






//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//                                           CODE, Merci de ne pas toucher si vous ne savez pas ce que vous faites !                                    //
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------


/**
 * Fonction pour récupérer un message (traduction)
 * 
 *  getMessage($param)
 *  @param = nom de la node json a récupérer
 *  @return = le message ou un message français si null
 * 
 */

// function getMessage($n){
//     $get = file_get_contents(cdn_link .'resources/translate/'. langage .'.json');
//     if($get == ''){
//         $get = file_get_contents(cdn_link .'resources/translate/FR.json');
//     }
//     $response = json_decode($get);
//     if(isset($response -> $n)){
//         return $response -> $n;
//     }else{
//         $get = file_get_contents(cdn_link .'resources/translate/FR.json');
//         $response = json_decode($get);
//         return $response -> $n;
//     }  
// }



/**
 * Fonction pour convertir une taille (pas de moi)
 */

function convertToReadableSize($size){
    $base = log($size) / log(1024);
    $suffix = array("", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}




/**
 * Récupérer des informations sur la page actuelle
 */
$pages = explode('/', $_SERVER['SCRIPT_NAME']);
$explode = explode('/', $_SERVER['REQUEST_URI']);
$page_name = $explode[sizeof($explode) - 2];

   


/**
 * Création de fichiers / dossiers
 */
if(isset($_POST['mode'])){
    if($_POST['mode'] == 'folder'){
        if(isset($_POST['name'])){
            mkdir($_POST['name'], 0777); 
            file_put_contents($_POST['name'].'/index.php', fopen(cdn_link ."/index.php", 'r'));
        }
    }
    if($_POST['mode'] == 'file'){
        if(isset($_POST['name'])){
            $create = fopen($_POST['name'], 'w');
            fputs($create, ' ');
        }
    }
}
    

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="<?= cdn_link ?>icons/favicon.ico" type="image/ico" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= cdn_link ?>resources/themes/reset.css">
    <link rel="stylesheet" href="<?= cdn_link ?>resources/themes/<?= theme ;?>.css">

    <title data-translate='title'></title>
</head>


<body>

    <header>
        <div class="centered">
        <div class="title">
            <p>
                <?php
                if(sizeof($explode) !== 3){
                    foreach($explode as $exp){
                        if($exp !== '' AND $exp !== $explode[sizeof($explode) - 2]){
                            echo '<a href="../../'. $exp .'">'.$exp.'</a> / ';
                        }
                        if($exp == $explode[sizeof($explode) - 2]){
                            echo $exp;
                        }
                    }
                }else{
                    echo $page_name;
                }
                ?>
            </p>
        </div>
        <div class="actions">
            <ul>
                <li class="help" style="padding: 5px"> <i class="far fa-question-circle"></i> </li>
                <li class="new_folder btn"> <i class="far fa-folder"></i> <span data-translate='new_folder'></span> </li>
                <li class="new_file btn"> <i class="far fa-file"></i> <span data-translate='new_file'></span> </li>
            </ul>
        </div>
        </div>
    </header>


    <section class="container">
        <div class="centered">
            <ul>
                <li class="head">
                    <div class="columns c-6"> <p data-translate='name'></p> </div>
                    <div class="columns c-2"> <p data-translate='size'></p> </div>
                    <div class="columns c-2"> <p data-translate='date'></p> </div>
                </li>

                <?php
                if(isset($pages[2])){
                    ?>
                    <li class="item">
                        <a href="../">
                            <div class="columns c-6 title"> <i class="fas fa-arrow-left"></i><span>...</span> </div>
                            <div class="columns c-2"> <p>-</p> </div>
                            <div class="columns c-2"> <p>-</p> </div>
                        </a>
                    </li>
                    <?php
                }
                ?>

                <div id="new"></div>

                <?php
                foreach(new DirectoryIterator(dirname(__FILE__)) as $file ){
                    if ( !$file->isDot() && $file -> getFilename() !== 'index.php' && $file -> getFilename() !== '.DS_Store'){
                        $extension_icon = 'far fa-file';

                        if($file -> getExtension() == 'php'){$extension_icon = 'fab fa-php';}
                        if($file -> getExtension() == 'css'){$extension_icon = 'fab fa-css3-alt';}
                        if($file -> getExtension() == 'js'){$extension_icon = 'fab fa-js';}
                        if($file -> getExtension() == 'html'){$extension_icon = 'fab fa-html5';}
                        if($file -> getExtension() == 'txt'){$extension_icon = 'fas fa-font';}
                        if($file -> getExtension() == 'md'){$extension_icon = 'fab fa-markdown';}
                        if($file -> getExtension() == 'xml'){$extension_icon = 'fab fa-file-excel';}
                        if($file -> getExtension() == 'pdf'){$extension_icon = 'fas fa-file-pdf';}
                        if($file -> isDir()){$extension_icon = 'far fa-folder';}
                        if(@is_array(getimagesize($file))){ $extension_icon = 'far fa-image'; }
                        if(is_resource($zip = zip_open($file))){ zip_close($zip); $extension_icon = 'far fa-file-archive'; }
                        if(preg_match('/^.*\.(mp4|mov)$/i', $file)){ $extension_icon = 'far fa-file-video'; }
                    ?>
                    <li class="item">
                        <a href="<?= $file -> getFilename() ;?>">
                            <div class="columns c-6 title"> <i class="<?= $extension_icon ;?>"></i> <span><?= $file -> getFilename() ;?></span> </div>
                            <div class="columns c-2"> <p><?= convertToReadableSize($file -> getSize()) ;?></p> </div>
                            <div class="columns c-2"> <p><?= date (date_format, $file->getATime()) ;?></p> </div>
                        </a>
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>

        </div>
    </section>



<script>
    // Bouton de création de fichier / dossiers
    $( ".new_folder" ).click(function() {
        if ( $( ".input_folder" ).length === 0 ) {
            $( ".input_file" ).remove();
            $( "#new" ).append( "<li class='item add_item input_folder'> <div class='columns c-6 title'> <i class='far fa-folder'></i> <input type='text' class='create_input' placeholder='folder_name '> </div> </li>" );
            $( "input" ).focus();
        }
    });

    $( ".new_file" ).click(function() {
        if ( $( ".input_file" ).length === 0) {
            $( ".input_folder" ).remove();
            $( "#new" ).append( "<li class='item add_item input_file'> <div class='columns c-6 title'> <i class='far fa-file'></i> <input type='text' class='create_input' placeholder='file_name '> </div> </li>" );
            $( "input" ).focus();
        }
    });


    // Actions avec le clavier
    $(document).bind('keydown', function(e) {
        // console.log(e.which)
        
        // Bouton Echap pour quitter la création de fichiers / dossiers
        if(e.which == 27) {
            if ( $( ".add_item" ).length ) {
                e.preventDefault();
                $( ".add_item" ).remove();
            }
            return false;
        }

        // Bouton Entrer pour créer un fichier / dossier
        if (e.keyCode == 13) {
            if ( $( ".add_item" ).length ) {
                e.preventDefault();
                if ( $( ".input_folder" ).length ) { var mode = 'folder' ;}
                if ( $( ".input_file" ).length ) { var mode = 'file' ;}

                var name = $('input').val();
                $.ajax({
                    method: 'POST',
                    url: 'index.php',
                    data: {name: name, mode: mode},
                    success: function(data) {
                        $('body').html(data);
                    } 
                });
            }
            return false;
        }
    });


    // Clic gauche pour ourvir un menu sur un fichier / dossier
    $('.item').contextmenu(function(e) {
        e.preventDefault();
        alert("Right click");
    });


    // Récupérer les traductions des messages
    $.getJSON( "<?= cdn_link ?>resources/translate/<?= langage ?>.json", function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( val );
        });

        $("[data-translate='title']").html(items[0]);
        $("[data-translate='new_folder']").html(items[1]);
        $("[data-translate='new_file']").html(items[2]);
        $("[data-translate='name']").html(items[3]);
        $("[data-translate='size']").html(items[4]);
        $("[data-translate='date']").html(items[5]);
        $("[data-translate='folder_name']").html(items[6]);
        $("[data-translate='file_name']").html(items[7]);
    
    });
</script>


</body>
</html>