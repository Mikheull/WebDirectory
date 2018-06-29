<style>
ul {list-style: none}
a {text-decoration: none}
body, html {font-family: "Tahoma";background: #FDFDFD;color: #2A2A2A}
.index {color: #b34f36;font-size: 20px;margin: 2vh 2.5vw}
.index span {font-style: italic}

.item {width: 100%;float: left}
.item li {float: left;margin: 15px 1vw;border-radius: 3px;border: solid 1px rgba(58, 58, 58, 0.3);height: 30px;min-width: 10vw;line-height: 30px}
.item li span {color: brown;margin: 0 5px}
.item .time, .item .size {float: right;line-height: 30px;color: rgba(51, 51, 51, 0.8);padding: 0 10px}
</style>


<?php
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
?>

<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
<a href="../"> <i class="fas fa-arrow-left fa-2x fa-pull-left fa-border"></i> </a>
<h1 class="index"> Index de <span><?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ;?></span> </h1>

<ul>
    <?php
    
    foreach(new DirectoryIterator(dirname(__FILE__)) as $f ){
        if ( !$f->isDot() && $f->getFilename() !== "index.php"){

            ?>
            <div class="item">
                <div class="infos">
                    <li> <span><i class="fas fa-folder"></i></span> <a href="<?php echo $f ;?>/"><?php echo $f ;?></a> </li>
 
                    <span class="time">
                        <?php 
                            echo date('d/m/Y H:i:s', $f->getMTime());
                        ;?>
                    </span>
                    <span class="size">
                        <?php 
                            $size = $f->getSize();
                            
                            echo $f->getSize();
                        ;?>
                    </span>
                </div>
            </div>
            <?php
            
        }
    }

    ?>
</ul>
