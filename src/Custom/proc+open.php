<?php
//header("Content-type: text/plain");
//disable_ob();

function disable_ob() {
    // Turn off output buffering
    ini_set('output_buffering', 'off');
    // Turn off PHP output compression
    ini_set('zlib.output_compression', false);
    // Implicitly flush the buffer(s)
    ini_set('implicit_flush', true);
    ob_implicit_flush(true);
    // Clear, and turn off output buffering
    while (ob_get_level() > 0) {
        // Get the curent level
        $level = ob_get_level();
        // End the buffering
        ob_end_clean();
        // If the current level has not changed, abort
        if (ob_get_level() == $level) break;
    }
    // Disable apache output buffering/compression
    if (function_exists('apache_setenv')) {
        apache_setenv('no-gzip', '1');
        apache_setenv('dont-vary', '1');
    }
}

function execute($cmd) {
	flush();
    $proc = proc_open($cmd, [['pipe','r'],['pipe','w'],['pipe','w']], $pipes, realpath('../'), array());
    while(($line = fgets($pipes[1])) !== false) {
        fwrite(STDOUT,$line);
    }
    while(($line = fgets($pipes[2])) !== false) {
        fwrite(STDERR,$line);
    }
    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    return proc_close($proc);
}


$file = realpath('../') . "\XWeb.exe";
$port = rand(7010, 7999);
$script = realpath('./') . "\init.php";
$script_args = $port;
$in_tray = false;

$cmd = "$file /port:$port /script:\"$script\" /script_args:$script_args /in_tray:$in_tray ping -n 1 -w 5000 192.168.254.254 >nul";

$process = execute($cmd);



echo "<pre>";
if (is_resource($process)) {
    while ($s = fgets($pipes[1])) {
        print $s;
        flush();
    }
}
echo "</pre>";

