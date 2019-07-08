<?php
function execute($cmd) {
      flush();
      $proc = proc_open($cmd, [['pipe','r'],['pipe','w'],['pipe','w']], $pipes, 'C:\XWeb\My Scripts', array());
      while(($line = fgets($pipes[1])) !== false) {
          fwrite(STDOUT,$line);
      }
      while(($line = fgets($pipes[2])) !== false) {
          fwrite(STDERR,$line);
      }
      fclose($pipes[0]);
      fclose($pipes[1]);
      fclose($pipes[2]);

      return ($proc);
  }

  function startClient(array $args) {
      extract($args);
      $cmd = "start \"XHE\" $file /port:$port /script:\"$script\" /script_args:$script_args /in_tray:\"$in_tray\" ping -n 1 -w 5000 192.168.254.254 >nul";

      $process = shell_exec($cmd);

   }
echo startClient(array(
                'file' => 'C:\XWeb\XWeb.exe', 
                'port' => 7010,
                'script' => 'C:\XWeb\My Scripts\init.php',
                'script_args' => 7010,
                'in_tray' => false
              ));

