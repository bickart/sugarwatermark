#!/usr/bin/env php
<?php
// Copyright 2016 SugarCRM Inc.  Licensed by SugarCRM under the Apache 2.0 license.

$packageID = "POWERHOUR_SUGAR_WATERMARK";
$packageLabel = "PowerHour | Watermark";
$acceptableSugarFlavors = array('ENT');
$description = 'Adds watermark to the background if Sugar';

if (empty($argv[1])) {
    if (file_exists("version")) {
        $version = file_get_contents("version");
    }
} else {
    $version = $argv[1];
}

if (empty($version)) {
    die("Use $argv[0] [version]\n");
}

$id = "{$packageID}_{$version}";

chdir(dirname(__FILE__, 2));

$directory = "builds";
if (!is_dir($directory)) {
    mkdir($directory);
}

$zipFile = $directory . strtolower("/{$id}.zip");


if (file_exists($zipFile)) {
    die("Error:  Release $zipFile already exists, so a new zip was not created. To generate a new zip, either delete the"
        . " existing zip file or update the version number in the version file AND then run the script to build the"
        . " module again. \n");
}

$manifest = array(
    'id' => $packageID,
    'name' => $packageLabel,
    'description' => $description,
    'version' => $version,
    'author' => 'Jeff Bickart',
    'is_uninstallable' => 'true',
    'published_date' => date("Y-m-d H:i:s"),
    'type' => 'module',
    'remove_tables' => '',
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array(
            '11\\.(.*?)\\.(.*?)',         //any 11.0.x release
            '12\\.(.*?)\\.(.*?)',         //any 12.0.x release
            '13\\.(.*?)\\.(.*?)',         //any 13.0.x release
            '14\\.(.*?)\\.(.*?)',         //any 14.0.x release
            '15\\.(.*?)\\.(.*?)',         //any 15.0.x release
            '16\\.(.*?)\\.(.*?)',         //any 16.0.x release
        ),
    ),
    'acceptable_sugar_flavors' => $acceptableSugarFlavors,
);

$installdefs = array(
    'id' => $packageID,
);

echo "Creating {$zipFile} ... \n";
$zip = new ZipArchive();
$zip->open($zipFile, ZipArchive::CREATE);

addFiles($zip, 'crm', $installdefs);

$zip->addFile('LICENSE', 'LICENSE.txt');
$zip->addFile('README.md', 'README.txt');


$manifestContent = sprintf(
    "<?php\n\$manifest = %s;\n\$installdefs = %s;\n",
    var_export($manifest, true),
    var_export($installdefs, true)
);
$zip->addFromString('manifest.php', $manifestContent);
$zip->close();
echo "Done creating {$zipFile}\n\n";
exit(0);

function addFiles($zip, $dir, &$installdefs)
{
    $basePath = realpath($dir);
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (isValidFileName($name)) {
            $language = false;
            if ($file->isFile()) {
                $fileReal = $file->getRealPath();
                $fileRelative = $dir . str_replace($basePath, '', $fileReal);
                echo " [*] $fileRelative \n";
                $zip->addFile($fileReal, $fileRelative);

                if (strpos($fileRelative, 'custom/Extension') != false) {
                    if (strpos($fileRelative, 'Language') != false) {
                        $language = true;
                    }
                }

                if (!$language) {
                    $installdefs['copy'][] = array(
                        'from' => '<basepath>/' . $fileRelative,
                        'to' => preg_replace('/^crm[\/\\\](.*)/', '$1', $fileRelative),
                    );
                } else {
                    $module = substr($fileRelative, (strpos($fileRelative, 'custom/Extension') + 17));
                    $module = substr($module, 0, strpos($module, '/'));
                    if ($module == 'modules') {
                        $module = substr($fileRelative, (strpos($fileRelative, 'custom/Extension/modules') + 25));
                        $module = substr($module, 0, strpos($module, '/'));
                    }
                    $installdefs['language'][] = array(
                        'from' => '<basepath>/' . $fileRelative,
                        'to_module' => $module,
                        'language' => 'en_us'
                    );
                }
            }
        }
    }
}


function isValidFileName($filename)
{
    $invalidExt = [
        '.DS_Store',
        '.gitkeep',
        '.gitignore',
        '.json',
        '.xml',
        '.md',
        '.dist',
        '.yml',
        '.lock',
        '.bak',
        '.txt',
        '.custom',
        'tests',
        '.gitattributes',
        'bin',
        'composer',
        'MimeMappingBuilder.php',
        'MimeMappingGenerator.php',
        'index.html',
        'autoload.php'
    ];
    foreach ($invalidExt as $ext) {
        if (strpos($filename, $ext) !== false) {
            return false;
        }
    }

    return true;
}