<?Php
header("Connection: Keep-Alive");
header("Keep-Alive: timeout=5, max=100"); 
define('SEPT', DIRECTORY_SEPARATOR);
define('BASEDIR', dirname(__FILE__).SEPT);
define('LIBRARY', BASEDIR.'library'.SEPT);
define('TEMA', BASEDIR.'theme'.SEPT);
define('CACHE', BASEDIR.'cache'.SEPT);
define('PLUGIN', BASEDIR.'plugin'.SEPT);


require_once(LIBRARY.'database.php');
require_once(LIBRARY.'blog_load.php');

unset($ayar, $veri, $yukle, $makale, $kategori, $mysqli, $sql);
?>