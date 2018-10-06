<?php
/**
 * modification du thème de la page
 * vous pouvez utiliser un des thèmes disponibles en changeant par ( dark - light )
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
define('date_format', 'j-n-Y H:i');

/**
 * modification des messages
 * vous pouvez sélectionner le langage qui vous convient en changeant par ( FR - EN - ES - AL - IT (voir les langages sur le github))
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
// A mettre quand je lance en prod
// define('cdn_link', 'https://cdn.rawgit.com/Mikheull/WebIE/master/');
define('cdn_link', 'https://rawgit.com/Mikheull/WebIE/master/');
define('file_creator', true);
define('folder_creator', true);
define('element_edit', true);



/**
 * Ajouter une Connexion
 * 
 */
define('auth', false);
// Modifier ce token par le votre
define('token', 'root');


/**
 * Système de notifications
 * vous pouvez sélectionner l'emplacement qui vous convient pour les notifications en changeant par
 * top-left
 * top-center
 * top-right
 * bottom-left
 * bottom-center
 * bottom-right
 */
define('notifications', true);
define('notifications_position', 'top-center');



//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//                                           CODE, Merci de ne pas toucher si vous ne savez pas ce que vous faites !                                    //
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------

session_start();

/**
 * Fonction de traduction des messages
 */
if( langage == 'custom'){ $link_message = langage_custom_link; }
else{ $link_message = cdn_link.'resources/translate/'. langage .'.json'; }

$get = file_get_contents($link_message);
$json_message = json_decode($get);



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
    if(isset($_POST['name'])){
        if($_POST['mode'] == 'folder'){
            foreach(new DirectoryIterator(dirname(__FILE__)) as $file ){
                if($file -> getFilename() == $_POST['name'] && $file->isDir()){
                    $error = true;
                }
            }
            if(!isset($error)){
                mkdir($_POST['name'], 0777); 
                file_put_contents($_POST['name'].'/index.php', fopen("index.php", 'r'));
                ?> <script> notifme('<?= $json_message ->{'notif_folder_created'} ?>', 'success'); </script> <?php
            }else{
                ?> <script> notifme('<?= $json_message ->{'notif_error_name_already_taken'} ?>', 'error'); </script> <?php
            }
        
        }

        if($_POST['mode'] == 'file'){
            foreach(new DirectoryIterator(dirname(__FILE__)) as $file ){
                if($file -> getFilename() == $_POST['name'] && !$file->isDir()){
                    $error = true;
                }
            }
            if(!isset($error)){
                $create = fopen($_POST['name'], 'w');
                fputs($create, ' ');
                ?> <script> notifme('<?= $json_message ->{'notif_file_created'} ?>', 'success'); </script> <?php
            }else{
                ?> <script> notifme('<?= $json_message ->{'notif_error_name_already_taken'} ?>', 'error'); </script> <?php
            }
        }
    }
    
}



if(isset($_POST['theme'])){
    $file = file_get_contents('index.php');
    $new_theme = $_POST['theme'];
    $new_date_format = $_POST['date_format'];
    $new_langage = $_POST['langage'];
    $replace = str_replace("define('theme', '". theme ."');", "define('theme', '". $new_theme ."');", $file);
    $replace = str_replace("define('date_format', '". date_format ."');", "define('date_format', '". $new_date_format ."');", $replace);
    $replace = str_replace("define('langage', '". langage ."');", "define('langage', '". $new_langage ."');", $replace);

    $fin = file_put_contents('index.php', $replace);
    ?> <script> window.location.reload(true); </script> <?php
    ?> <script> notifme('<?= $json_message ->{'notif_config_save'} ?>', 'success'); </script> <?php
}


if(isset($_POST['update'])){
    file_put_contents('index.php', fopen(cdn_link ."/index.php", 'r'));
    ?> <script> window.location.reload(true); </script> <?php
    ?> <script> notifme('<?= $json_message ->{'notif_updated'} ?>', 'success'); </script> <?php
}




if(element_edit == true){
    if(isset($_POST['act'])){
        if($_POST['act'] == 'archive'){
            $name = $_POST['name'];
            $new_name = '___archived___'.$_POST['name'];
            rename($name, $new_name);
            ?> <script> notifme('<?= $json_message ->{'notif_file_archived'} ?>', 'success'); </script> <?php
        }
        if($_POST['act'] == 'unarchive'){
            $name = $_POST['name'];
            $new_name = str_replace("___archived___", "", $name);
            rename($name, $new_name);
            ?> <script> notifme('<?= $json_message ->{'notif_file_unarchived'} ?>', 'success'); </script> <?php
        }
        if($_POST['act'] == 'delete'){
            $name = $_POST['name'];
            unlink($name);
            ?> <script> notifme('<?= $json_message ->{'notif_file_deleted'} ?>', 'success'); </script> <?php
        }
        if($_POST['act'] == 'clone'){
            $name = $_POST['name'];
            $new_name = '1-'.$_POST['name'];
            file_put_contents($new_name, fopen($name, 'r'));
            ?> <script> notifme('<?= $json_message ->{'notif_file_clone'} ?>', 'success'); </script> <?php
        }
    }
}


if(auth == true){
    if(isset($_POST['login'])){
        $token = $_POST['token'];
        if(token == $token){
            $_SESSION['connected'] = true;
            ?> <script> notifme('<?= $json_message ->{'notif_login'} ?>', 'success'); </script> <?php
        }

    }
    if(isset($_POST['logout'])){
        unset($_SESSION['connected']);
        ?> <script> notifme('<?= $json_message ->{'notif_logout'} ?>', 'success'); </script> <?php
    }
}



function getIconExt($extension){
    if($extension == 'php'){return 'fab fa-php';}
    if($extension == 'css'){return 'fab fa-css3-alt';}
    if($extension == 'js'){return 'fab fa-js';}
    if($extension == 'html'){return 'fab fa-html5';}
    if($extension == 'txt'){return 'fas fa-font';}
    if($extension == 'md'){return 'fab fa-markdown';}
    if($extension == 'xml'){return 'fab fa-file-excel';}
    if($extension == 'pdf'){return 'fas fa-file-pdf';}

    return 'far fa-file';
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
    <?php
    if( theme == 'custom'){
        ?> <link rel="stylesheet" href="<?= theme_custom_link ?>"> <?php
    }else{
        ?> <link rel="stylesheet" href="<?= cdn_link ?>resources/themes/<?= theme ;?>.css"> <?php


    }
    ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">

    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
    <title><?= $page_name .' - '. $json_message ->{'title'} ?></title>
</head>






<body>
    <div class="notif_container"> <span class="notification <?= notifications_position ?>"> </span> </div>
    
    <?php

    // BUG sur le isset
    if(isset($_SESSION['connected'])){
        
        ?>
        <div class="login_container">
            <h2><?= $json_message ->{'login_title'} ?></h2>
            <h3><?= $json_message ->{'login_subtitle'} ?></h3>
            <form method="post">
                <input type="text" name="token" id="token" placeholder="<?= $json_message ->{'login_token'} ?>">
                <input type="submit" name="login" value="<?= $json_message ->{'login_button'} ?>">
            </form>
        </div>
        <?php
    }else{

    ?>

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
                <li style="padding: 5px"> <a href=""><i class="fas fa-sync-alt"></i></a> </li>
                
                <?php                
                if(auth == true){ ?> <li class="logout" style="padding: 5px"> <i class="fas fa-sign-out-alt"></i> </li> <?php }
                if(folder_creator == true){ ?> <li class="new_folder btn"> <i class="far fa-folder"></i> <span><?= $json_message ->{'new_folder'} ?></span> </li> <?php }
                if(file_creator == true){ ?> <li class="new_file btn"> <i class="far fa-file"></i> <span><?= $json_message ->{'new_file'} ?></span> </li> <?php }
                ?>
            </ul>
        </div>
        </div>
    </header>


    <section class="container">
        <div class="centered">

            <ul>
                <li class="head">
                    <div class="columns c-6"> <p><?= $json_message ->{'name'} ?></p> </div>
                    <div class="columns c-2"> <p><?= $json_message ->{'size'} ?></p> </div>
                    <div class="columns c-2"> <p><?= $json_message ->{'date'} ?></p> </div>
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
                        if(strstr($file -> getFilename(), '___archived___')){ $containArchivedFile = true ;}

                        if ( !$file->isDot() && $file -> getFilename() !== '.DS_Store' && !strstr($file -> getFilename(), '___archived___')){
                            $extension_icon = 'far fa-file';
                            $data_mode = 'undefined';

                            if($file -> getExtension() == 'php'){$extension_icon = 'fab fa-php'; $data_mode = 'file';}
                            if($file -> getExtension() == 'css'){$extension_icon = 'fab fa-css3-alt'; $data_mode = 'file';}
                            if($file -> getExtension() == 'js'){$extension_icon = 'fab fa-js'; $data_mode = 'file';}
                            if($file -> getExtension() == 'html'){$extension_icon = 'fab fa-html5'; $data_mode = 'file';}
                            if($file -> getExtension() == 'txt'){$extension_icon = 'fas fa-font'; $data_mode = 'file';}
                            if($file -> getExtension() == 'md'){$extension_icon = 'fab fa-markdown'; $data_mode = 'file';}
                            if($file -> getExtension() == 'xml'){$extension_icon = 'fab fa-file-excel'; $data_mode = 'file';}
                            if($file -> getExtension() == 'pdf'){$extension_icon = 'fas fa-file-pdf'; $data_mode = 'file';}
                            if($file -> isDir()){$extension_icon = 'far fa-folder'; $data_mode = 'folder';}
                            if(@is_array(getimagesize($file))){ $extension_icon = 'far fa-image'; $data_mode = 'image'; }
                            if(is_resource($zip = zip_open($file))){ zip_close($zip); $extension_icon = 'far fa-file-archive'; $data_mode = 'archive'; }
                            if(preg_match('/^.*\.(mp4|mov)$/i', $file)){ $extension_icon = 'far fa-file-video'; $data_mode = 'video'; }
                        ?>
                        <li class="popover item" data-id="<?= $file -> getInode() ;?>">
                            <?php if(element_edit == true){ ?>
                                <div id="<?= $file -> getInode() ;?>" class="act_popover">
                                    <?php 
                                    if($data_mode == 'file' OR $data_mode == 'video' OR $data_mode == 'image' OR $data_mode == 'archive'){
                                    ?>
                                    <div class='body'>
                                        <ul> 
                                            <li class="item" data-mode="rename"><a> <i class='far fa-edit'></i> </a></li> 
                                            <li class="item" data-mode="clone" data-name="<?= $file -> getFilename() ;?>"><a> <i class='far fa-clone'></i> </a></li> 
                                            <li class="item" data-mode="download"> <a href="<?= $file -> getFilename() ;?>" download> <i class='fas fa-download'></i> </a></li> 
                                            <li class="item" data-mode="delete" data-name="<?= $file -> getFilename() ;?>"><a> <i class='far fa-trash-alt'></i> </a></li> 
                                            <li class="item" data-mode="archive" data-name="<?= $file -> getFilename() ;?>"><a> <i class='fas fa-archive'></i> </a></li> 
                                        </ul>
                                        <div class="pp"></div>
                                    </div>
                                    <?php
                                    }else if($data_mode == 'folder'){
                                    ?>
                                    <div class='body'>
                                        <ul> 
                                            <li class='item' data-mode="rename"><a> <i class='far fa-edit'></i> </a></li> 
                                            <li class='item' data-mode="delete" data-name="<?= $file -> getFilename() ;?>"><a> <i class='far fa-trash-alt'></i> </a></li> 
                                            <li class='item' data-mode="archive" data-name="<?= $file -> getFilename() ;?>"><a> <i class='fas fa-archive'></i> </a></li> 
                                        </ul>
                                    </div>
                                    <?php
                                    }else{
                                    ?>
                                    <div class='body'>
                                        <ul> 
                                            <li class='item' data-mode="rename"><a> <i class='far fa-edit'></i> </a></li> 
                                            <li class='item' data-mode="download"><a href="<?= $file -> getFilename() ;?>" download> <i class='fas fa-download'></i> </a></li> 
                                            <li class='item' data-mode="delete" data-name="<?= $file -> getFilename() ;?>"><a> <i class='far fa-trash-alt'></i> </a></li> 
                                            <li class='item' data-mode="archive" data-name="<?= $file -> getFilename() ;?>"><a> <i class='fas fa-archive'></i> </a></li> 
                                        </ul>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="arrow-down"></div>
                                </div>
                            <?php } ?>
                            
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


                <?php
                if(element_edit == true){
                    if(isset($containArchivedFile)){
                    ?>
                    <ul class="archived_files">
                        <details>
                        <summary><?= $json_message ->{'archived'} ?></summary>
                    
                        
                        <?php
                        foreach(new DirectoryIterator(dirname(__FILE__)) as $file ){
                            if ( !$file->isDot() && $file -> getFilename() !== '.DS_Store' && strstr($file -> getFilename(), '___archived___')){
                            ?>
                            <li class="popover item" data-id="<?= $file -> getInode() ;?>">
                                <div id="<?= $file -> getInode() ;?>" class="act_popover">
                                    
                                    <div class='body'>
                                        <ul> 
                                            <li class='item' data-mode="unarchive" data-name="<?= $file -> getFilename() ;?>"><a> <i class='fas fa-box-open'></i> </a></li> 
                                        </ul>
                                    </div>
                                    
                                    <div class="arrow-down"></div>
                                </div>
                                
                                <a href="<?= $file -> getFilename() ;?>">
                                    <div class="columns c-6 title"> <i class="<?= getIconExt($file -> getExtension()) ;?>"></i> <span><?= str_replace("___archived___", "", $file -> getFilename()); ;?></span> </div>
                                    <div class="columns c-2"> <p><?= convertToReadableSize($file -> getSize()) ;?></p> </div>
                                    <div class="columns c-2"> <p><?= date (date_format, $file->getATime()) ;?></p> </div>
                                </a>
                            </li>
                            <?php
                            }
                        } 
                    }
                    ?>
                </details> 
            </ul>
            <?php
                }
            ?>

        </div>
    </section>


    
    <footer>
        <div class="centered">
            <p><a href="https://github.com/Mikheull/WebIE">WebIE</a> <?= $json_message ->{'footer_cop'} ?> <a href="https://mikhaelbailly.fr/">Mikhaël Bailly</a></p>
        </div>
    </footer>



    <section class="modal">
        <div class="mdl help_modal">
            <div class="mdl_container">
                <div class="head">
                    <p class="title"><?= $json_message ->{'help_mdl_title'} ?></p> <div class="key"><span>CTRL</span> <span>/</span></div>
                    <p class="subtitle"><?= $json_message ->{'help_mdl_subtitle'} ?></p>
                </div>
                
                <div class="body">
                    <?php 
                        if(folder_creator == true){ ?> 
                            <div class="item">
                                <div class="title"><?= $json_message ->{'help_mdl_folder_create_title'} ?></div>
                                <div class="key"> <span>SHIFT</span> <span>D</span> </div>
                            </div>
                        <?php }
                
                        if(file_creator == true){ ?> 
                            <div class="item">
                                <div class="title"><?= $json_message ->{'help_mdl_file_create_title'} ?></div>
                                <div class="key"> <span>SHIFT</span> <span>F</span> </div>
                            </div>
                        <?php }
                    ?>
                
                    <div class="item">
                        <div class="title"><?= $json_message ->{'help_mdl_update'} ?></div>
                        <div class="key"> <span>SHIFT</span> <span>U</span> </div>
                    </div>
                    <div class="item">
                        <div class="title"><?= $json_message ->{'help_mdl_config'} ?></div>
                        <div class="key"> <span>SHIFT</span> <span>C</span> </div>
                    </div>
                    <div class="item">
                        <div class="title"><?= $json_message ->{'help_mdl_github'} ?></div>
                        <div class="key"> <span>SHIFT</span> <span>G</span> </div>
                    </div>
                    <div class="item">
                        <div class="title"><?= $json_message ->{'help_mdl_esc'} ?></div>
                        <div class="key"> <span>ESC</span> </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl config_modal">
            <div class="mdl_container">
                <div class="head">
                    <p class="title"><?= $json_message ->{'config_mdl_title'} ?></p> <div class="key"><span>SHIFT</span> <span>C</span></div>
                    <p class="subtitle"><?= $json_message ->{'config_mdl_subtitle'} ?></p>
                </div>
                
                <div class="body">
                    <div class="input-group">
                        <label for="theme"><?= $json_message ->{'config_mdl_theme_title'} ?></label>
                        <small><?= $json_message ->{'config_mdl_theme_subtitle'} ?></small>
                        <span><i class="fas fa-palette"></i></span>
                        <select name="theme" id="theme">
                            <option value="<?= theme ?>"><?= theme ?></option>
                            <?php
                                if( theme !== 'dark'){ ?> <option value="dark">dark</option> <?php }
                                if( theme !== 'light'){ ?> <option value="light">light</option> <?php }
                                if( theme !== 'blue'){ ?> <option value="blue">blue</option> <?php }
                                if( theme !== 'green'){ ?> <option value="green">green</option> <?php }
                                if( theme !== 'orange'){ ?> <option value="orange">orange</option> <?php }
                                if( theme !== 'purple'){ ?> <option value="purple">purple</option> <?php }
                                if( theme !== 'red'){ ?> <option value="red">red</option> <?php }
                                if( theme !== 'yellow'){ ?> <option value="yellow">yellow</option> <?php }
                            ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="date_format"><?= $json_message ->{'config_mdl_date_title'} ?></label>
                        <small><?= $json_message ->{'config_mdl_date_subtitle'} ?> <a href="http://php.net/manual/fr/function.date.php" target="blank"><?= $json_message ->{'config_mdl_date_subtitle_doc'} ?></a> </small>
                        <span><i class="fas fa-calendar-alt"></i></span>
                        <input type="text" value="<?= date_format ?>" id="date_format" placeholder="Date format">
                    </div>

                    <div class="input-group">
                        <label for="langage"><?= $json_message ->{'config_mdl_langage_title'} ?></label>
                        <small><?= $json_message ->{'config_mdl_langage_subtitle'} ?></small>
                        <span><i class="fas fa-language"></i></span>
                        <select name="langage" id="langage">
                            <option value="<?= langage ?>"><?= langage ?></option>
                            <?php
                                if( langage !== 'FR'){ ?> <option value="FR">FR</option> <?php }
                                if( langage !== 'EN'){ ?> <option value="EN">EN</option> <?php }
                                if( langage !== 'ES'){ ?> <option value="ES">ES</option> <?php }
                                if( langage !== 'AL'){ ?> <option value="AL">AL</option> <?php }
                            ?>
                        </select>
                    </div>

                    <span class="save_config"><?= $json_message ->{'save_button'} ?></span>
                </div>
            </div>
        </div>
    </section>


<script>
    // Bouton de création de fichier / dossiers
    <?php
        if(folder_creator == true){ ?> 
            $( ".new_folder" ).click(function() {
                if ( $( ".input_folder" ).length === 0 ) {
                    OpenCreateFolder();
                }
            });
        <?php }
    ?>

    <?php
        if(file_creator == true){ ?> 
            $( ".new_file" ).click(function() {
                if ( $( ".input_file" ).length === 0) {
                    OpenCreateFile();
                }
            });
        <?php }
    ?>

    // Bouton d'aide
    $( ".help" ).click(function() {
        OpenHelp();
    });

    $( ".save_config" ).click(function() {
        var theme = $('#theme').val();
        var date_format = $('#date_format').val();
        var langage = $('#langage').val();
        // var file_creator = $('#file_creator').val();
        // var folder_creator = $('#folder_creator').val();
        $.ajax({
            method: 'POST',
            url: 'index.php',
            data: {theme: theme, date_format: date_format, langage: langage},
            success: function(data) {
                $('body').html(data);
            } 
        });
    });

    // Bouton de deconnexion
    $( ".logout" ).click(function() {
        $.ajax({
            method: 'POST',
            url: 'index.php',
            data: {logout: true},
            success: function(data) {
                $('body').html(data);
            } 
        });
    });




    // Actions avec le clavier
    $(document).bind('keydown', function(e) {
        //console.log(e.which)

        // Raccourci clavier -> Menu d'aide
        if(e.ctrlKey && (e.which == 58)) {
            e.preventDefault();
            OpenHelp();
            return false;
        }
        // Raccourci clavier -> Menu de config
        if(e.shiftKey && (e.which == 67)) {
            e.preventDefault();
            OpenConfig();
            return false;
        }
        // Raccourci clavier -> Menu d'aide
        if(e.shiftKey && (e.which == 85)) {
            e.preventDefault();
            if (confirm("<?= $json_message ->{'update'} ?>")) {
                $.ajax({
                    method: 'POST',
                    url: 'index.php',
                    data: {update: 'true'},
                    success: function(data) {
                        $('body').html(data);
                    } 
                });
            }
            return false;
        }
        
        <?php
            if(folder_creator == true){ ?> 
                // Raccourci clavier -> Créer un dossier
                if(e.shiftKey && (e.which == 68)) {
                    e.preventDefault();
                    if ( $( ".input_folder" ).length === 0 ) {
                        OpenCreateFolder();
                    }   
                    return false;
                }
            <?php }
            if(file_creator == true){ ?> 
                // Raccourci clavier -> Créer un fichier
                if(e.shiftKey && (e.which == 70)) {
                    e.preventDefault();
                    if ( $( ".input_file" ).length === 0 ) {
                        OpenCreateFile();
                    }   
                    return false;
                }
            <?php }
        ?>
        
        
        
        // Raccourci clavier -> Aller au github
        if(e.shiftKey && (e.which == 71)) {
            e.preventDefault();
            window.open('https://github.com/Mikheull/WebIE','_blank');
            return false;
        }


        // Bouton Echap pour quitter la création de fichiers / dossiers
        if(e.which == 27) {
            if ( $( ".add_item" ).length ) {
                e.preventDefault();
                $( ".add_item" ).remove();
            }
            if ( $( ".help_modal" ).length ) {
                e.preventDefault();
                $('header, footer, .container').removeClass('blur');
                $( ".help_modal" ).hide();
            }
            if ( $( ".config_modal" ).length ) {
                e.preventDefault();
                $('header, footer, .container').removeClass('blur');
                $( ".config_modal" ).hide();
            }
            if ( $( ".act_popover" ).length ) {
                e.preventDefault();
                $( ".act_popover" ).hide();
            }
            if ( $( ".notification" ).length ) {
                e.preventDefault();
                removeNotif();
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
    <?php if(element_edit == true){ ?>
        $('.popover').contextmenu(function(e) {
            e.preventDefault();
            var id = this.dataset.id;

            $( ".act_popover" ).hide();
            $( "#" + id ).show();
            var offset = $(this).offset();
            $( "#" + id ).css("top", '0');
            $( "#" + id ).css("top", e.pageY - offset.top - 40);
        });
        
        $( ".popover .item" ).click(function() {
            var name = this.dataset.name;
            var act = this.dataset.mode;
            $.ajax({
                method: 'POST',
                url: 'index.php',
                data: {act: act, name: name},
                success: function(data) {
                    $('body').html(data);
                } 
            });
        });
        $( ".popover .item" ).hover(function() {
            var act = this.dataset.mode;
            $( ".pp" ).empty();
            $( ".pp" ).append( act );
        }, function() {
            $( ".pp" ).empty();
            $( ".pp" ).append( '-' );
        });
    <?php } ?>


    // Fonctions globales
    function OpenHelp(){
        $('header, footer, .container').addClass('blur');
        $('.help_modal').show();
    }

    function OpenConfig(){
        $('header, footer, .container').addClass('blur');
        $('.config_modal').show();
    }
    
    <?php
        if(folder_creator == true){ ?> 
            function OpenCreateFolder(){
                $( ".input_file" ).remove();
                $( "#new" ).append( "<li class='item add_item input_folder'> <div class='columns c-6 title'> <i class='far fa-folder'></i> <input type='text' class='create_input' placeholder='<?= $json_message ->{'folder_name'} ?>'> </div> </li>" );
                $( "input" ).focus();
                notifme('<?= $json_message ->{'notif_create_folder'} ?>', 'info');
            }
        <?php }
        if(file_creator == true){ ?> 
            function OpenCreateFile(){
                $( ".input_folder" ).remove();
                $( "#new" ).append( "<li class='item add_item input_file'> <div class='columns c-6 title'> <i class='far fa-file'></i> <input type='text' class='create_input' placeholder='<?= $json_message ->{'file_name'} ?>'> </div> </li>" );
                $( "input" ).focus();
                notifme('<?= $json_message ->{'notif_create_file'} ?>', 'info');
            }
        <?php }
    ?>
    
    // Notifications
    function notifme(message, mode){
        <?php if(notifications == true){ ?>
            removeNotif();
            $( ".notification" ).fadeIn("slow").append(message); 
            if(mode == 'success'){
                $( ".notification" ).css( "background", "#DFF2BF" ); 
                $( ".notification" ).css( "color", "4F8A10" ); 
            }
            if(mode == 'error'){
                $( ".notification" ).css( "background", "#FFBABA" ); 
                $( ".notification" ).css( "color", "D8000C" ); 
            }
            if(mode == 'info'){
                $( ".notification" ).css( "background", "#BDE5F8" ); 
                $( ".notification" ).css( "color", "00529B" );
            }
        <?php } ?>
    }
    function removeNotif(){
        $( ".notification" ).empty();
        $( ".notification" ).hide();
    }
    $( ".notification" ).click(function(){
        removeNotif();
    });

</script>

<?php
// Fin du if auth
}   

?>

</body>
</html>
