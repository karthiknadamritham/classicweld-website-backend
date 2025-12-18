<?php
$iniPath = 'C:/PHP/php.ini';
if (!file_exists($iniPath)) {
    die("php.ini not found at $iniPath");
}
$content = file_get_contents($iniPath);

// Enable pdo_mysql
$content = str_replace(';extension=pdo_mysql', 'extension=pdo_mysql', $content);

// Enable mysqli
$content = str_replace(';extension=mysqli', 'extension=mysqli', $content);

// Ensure extension_dir is active (optional, but good to check. Often commented out)
// We won't touch it blindly as it might break things if incorrect path.
// Usually Uncommenting the extension lines is enough if ext dir is standard.

if (file_put_contents($iniPath, $content)) {
    echo "SUCCESS: Extensions enabled in php.ini\n";
} else {
    echo "FAILURE: Could not write to php.ini. Check permissions.\n";
}
