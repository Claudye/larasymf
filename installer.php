<?php
define('SEPERATOR', '/');
define('INS_NAME', '_program');


/**
 * Join file
 *
 * @param string ...$path
 * @return string
 */
function joinPath(string ...$path)
{

    $num_args = func_num_args();
    $args = func_get_args();
    $path = trim($args[0], SEPERATOR);

    if ($num_args > 1) {
        for ($i = 1; $i < $num_args; $i++) {
            $path .= SEPERATOR . trim($args[$i], SEPERATOR);
        }
    }

    return $path;
}


/**
 * Installer class
 * @author Claude Fassinou <dev.claudy@gmail>
 * @license 
 * @copyright 2021
 */

class Installer
{
    /**
     * Dir can be  explored
     *
     * @var string
     */
    protected $explorer = '';
    /**
     *  SplFileInfo[] 
     *
     * @var @var SplFileInfo[] 
     */
    private $files = [];
    /**
     * Root of code source
     *
     * @var string
     */
    public $from = __DIR__;

    /**
     * Final zip file
     * @var string
     */
    public $to;

    /**
     * Zip class
     * @var ZipArchive
     */
    private $zip;

    public $errors =[];

    public function __construct()
    {
        $this->zip = new  ZipArchive;
        $this->zipTo();
    }

    /**
     * Unzip code source
     *
     * @param string|null $to
     * @return void
     */
    public function unzip(string $to = null)
    {
        $this->zipTo();
        if ($this->zip->open($to ?? $this->to) === true) {
            $su = $this->zip->extractTo('.');
            
            return $this->zip->close();
        }
        $this->errors []=  "Can't open $this->to file";
        return false;
    }

    /**
     * Zip code source
     *
     * @return void
     */
    public function zip()
    {
        
        $this->scandir($this->from);
        // Get real path for our folder
        $rootPath = realpath($this->from);

        if (!is_file($this->to)) {

            $this->zip->open($this->to, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($this->files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $sourceFilePath = $file->getRealPath();
                    if (!in_array($file->getFileName(), [basename(__FILE__), $this->to])) {

                        $relativePath = substr($sourceFilePath, strlen($rootPath) + 1);

                        $relativePath = str_replace(DIRECTORY_SEPARATOR, SEPERATOR, $relativePath);

                        // Add current file to archive
                        $this->zip->addFile($sourceFilePath, $relativePath);
                    }
                }
            }
            return $this->zip->close();
        }

        $this->errors [] = "The project named $this->to already exist ";
        return false ;
    }

    /**
     * Scan a dir
     *
     * @param string $dir
     * @return void
     */
    public function scandir(string $dir)
    {
        $this->explorer = $dir;
        $rootPath = realpath($this->explorer);
        // Create recursive directory iterator
        /** @var SplFileInfo[] $files*/
        $this->files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
    }
    /**
     * Set final zip file name
     *
     * @param string|null $to
     * @return void
     */
    private function zipTo(string $to = null)
    {
        $t = INS_NAME;
        $this->to = $to ?? joinPath($t . '.zip');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installing ...</title>
    <style>
        body {
            background-color: rgb(240, 240, 240);
        }

        .wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            width: 400px;
            background-color: white;
            box-shadow: 0 3px 20px #aba;
            padding: 1em;
        }

        .btn-box {
            margin: 12px 0;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="box">
            <h4>Installing ...</h4>
            <div class="btn-box">
                <button type="button" onclick="window.location='<?= basename(__FILE__)?>'">Restart</button>
                <button type="button" <?= isset($_GET['step']) && 'compress' === $_GET['step'] ? "disabled" :''  ?> onclick="window.location='?step=compress'">Compresser</button>
                <button type="button" <?= isset($_GET['step']) && 'install' === $_GET['step'] ? "disabled" :''  ?> onclick="window.location='?step=install'"> Installer </button>
            </div>
            <?php

            if (isset($_GET['step'])) {
                $installer = new Installer();
                if ('install' === $_GET['step']) {
                    $success= $installer->unzip();
                    $message = $success ? 'Installation done !' :'Installation failed';
                }
                if ('compress' === $_GET['step']) {
                    $success= $installer->zip();
                    $message = $success ? '</small>Project compressed with success ! and named to </small>' .$installer->to :'Compression failed';
                }
                if (isset($success)) {
                    echo '<mark><b>'.$message.'</b></mark> <br>';
                    if (!$success) {
                        echo '<b>Reason(s) ! </b><br>';
                       foreach ($installer->errors as  $error) {
                          echo $error .'<br>';
                       }
                    }
                }
            }
            ?>
        </div>
    </div>
</body>

</html>