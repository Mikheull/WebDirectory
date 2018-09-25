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
// A mettre quand je lance en prod
// define('cdn_link', 'https://cdn.rawgit.com/Mikheull/WebDirectory/master/');
define('cdn_link', 'https://rawgit.com/Mikheull/WebDirectory/master/');
define('file_creator', true);
define('folder_creator', true);






//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//                                           CODE, Merci de ne pas toucher si vous ne savez pas ce que vous faites !                                    //
//--------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------

/**
 * Fonction de traduction des messages
 */
$get = file_get_contents(cdn_link.'resources/translate/'. langage .'.json');
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
    }


    if(isset($_POST['update'])){
        file_put_contents('index.php', fopen(cdn_link ."/index.php", 'r'));
        ?> <script> window.location.reload(true); </script> <?php
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

    <title><?= $page_name .' - '. $json_message ->{'title'} ?></title>
</head>


<body id="translate">

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
                <?php
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
                    if ( !$file->isDot() && $file -> getFilename() !== '.DS_Store'){
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


    
    <footer>
        <div class="centered">
            <p><a href="https://github.com/Mikheull/WebDirectory">WebDirectory</a> <?= $json_message ->{'footer_cop'} ?> <a href="https://mikhaelbailly.fr/">Mikhaël Bailly</a></p>
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
                                if( theme !== 'custom'){ ?> <option value="custom">custom</option> <?php }
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
                                if( langage !== 'custom'){ ?> <option value="custom">custom</option> <?php }
                            ?>
                        </select>
                    </div>

                    <span class="save_config"><?= $json_message ->{'save_button'} ?></span>
                </div>
            </div>
        </div>

        <div class="mdl file-action_modal">
            <a href="temp.html" download> file_name </a>
        </div>

        <div class="mdl folder-action_modal">

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
            window.open('https://github.com/Mikheull/WebDirectory','_blank');
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
        alert("Clic droit");
        $( this + "span" ).hide();
    });


    
    


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
            }
        <?php }
        if(file_creator == true){ ?> 
            function OpenCreateFile(){
                $( ".input_folder" ).remove();
                $( "#new" ).append( "<li class='item add_item input_file'> <div class='columns c-6 title'> <i class='far fa-file'></i> <input type='text' class='create_input' placeholder='<?= $json_message ->{'file_name'} ?>'> </div> </li>" );
                $( "input" ).focus();
            }
        <?php }
    ?>
    


    function isMacintosh() {
        return navigator.platform.indexOf('Mac') > -1
    }

    function isWindows() {
        return navigator.platform.indexOf('Win') > -1
    }
    //alert(isWindows());

</script>

</body>
</html>