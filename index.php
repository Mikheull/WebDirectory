<?php
/**
 * Configuration :
 *  Configurer la page comme vous voulez ici
 * 
*/

/**
 * Theme = (dark - light - modern)
 * remplasser ci-dessous par le thème voulu (si vous voulez un custom remplacer simplement le link plus bas par le votre)
*/
$theme = "dark";

/**
 * Format de date
 *  documentation du format ici -> http://php.net/manual/fr/function.date.php
*/
$format_date = "j-n-Y H:i:s";


 /**
  * Code -! 
  *     Merci de ne pas toucher si vous ne savez pas ce que vous faites !
  *
  */


    $pages = explode('/', $_SERVER['SCRIPT_NAME']);
    $explode = explode('/', $_SERVER['REQUEST_URI']);
    $page_name = $explode[sizeof($explode) - 2];

    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="https://raw.githubusercontent.com/Mikheull/WebDirectory/master/resources/icons/favicon.ico" type="image/ico" />
    
    <title><?= $page_name ;?> | Explorateur de fichiers</title>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.rawgit.com/Mikheull/WebDirectory/1f0b8a84/resources/themes/reset.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/Mikheull/WebDirectory/1f0b8a84/resources/themes/<?= $theme ;?>.css">
</head>



<body>

    <header>
        <div class="centered">
            <div class="title">
                <h2>
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
                </h2>
            </div>
            <div class="actions">
                <ul>
                    <li class="help" style="padding: 5px"> <i class="far fa-question-circle"></i> </li>
                    <li class="new_folder btn"> <i class="fas fa-folder-plus"></i> <span>NEW</span> </li>
                    <li class="new_file btn"> <i class="fas fa-file-medical"></i> <span>NEW</span> </li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container">
        <div class="centered">
            <ul>
                <li class="head">
                    <div class="columns c-6">
                        <p>Nom</p>
                    </div>
                    <div class="columns c-2">
                        <p>Taille</p>
                    </div>
                    <div class="columns c-2">
                        <p>Date de modification</p>
                    </div>
                </li>
                
                <?php 
                    if(isset($pages[2])){
                        ?>
                        <li class="item">
                            <a href="../">
                                <div class="columns c-6 title">
                                    <i class="fas fa-arrow-left"></i><span>...</span>
                                </div>
                                <div class="columns c-2">
                                    <p>-</p>
                                </div>
                                <div class="columns c-2">
                                    <p>-</p>
                                </div>
                            </a>    
                        </li>
                        <?php
                    }
                ?>
                
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
                            <div class="columns c-6 title">
                                <i class="<?= $extension_icon ;?>"></i><span><?= $file -> getFilename() ;?></span>
                            </div>
                            <div class="columns c-2">
                                <p><?= convertToReadableSize($file -> getSize()) ;?></p>
                            </div>
                            <div class="columns c-2">
                                <p><?= date ($format_date, $file->getATime()) ;?></p>
                            </div>
                        </a>    
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>

        </div>
    </section>

</body>
</html>