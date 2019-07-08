<?php
namespace MyApp\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use \XWEB;

class ClientController
{
   protected $container;
   public $basePath;
   public $xwebPath;
   public $port;
   public $ip;
   public $scriptsPath;


   public function __construct(ContainerInterface $container) {
       $this->container = $container;
       $this->setBasePath();
       $this->setXwebPath();
       $this->setScriptsPath();
       //$this->setPort($this->findPort());
       $this->setPort('7666');
       $this->setIp('195.245.221.33');
       //$this->setIp('127.0.0.1');

      if(!defined('STDIN'))  define('STDIN',  fopen('php://stdin',  'r'));
      if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'w'));
      if(!defined('STDERR')) define('STDERR', fopen('php://stderr', 'w'));

   }

   public function test() {
      $navigate = new \XWEB\XHEBrowser($this->ip . ":" . $this->port);
      $navigate->navigate('google.com');
      $click = new \XWEB\XHEAnchor($this->ip . ":" .   $this->port);
      $click->get_by_number(0)->click();
   }

  public function getScriptsPath() {
    return $this->scriptsPath;
  }

  public function getXwebPath() {
    return $this->xwebPath;
  }

  public function getBasePath() {
    return $this->basePath;
  }


  public function setBasePath() {
    $this->basePath = dirname($_SERVER["DOCUMENT_ROOT"]);  
    return $this;
  }

  public function setXwebPath() {
    $this->xwebPath = ($this->basePath . "\\vendor\xweb\xweb-lite\\");
    return $this;
  }  

  public function setScriptsPath() {
    $this->scriptsPath = ($this->basePath . "\\src\Custom\\");
    return $this;
  }  

  public function findPort() {
    return file_get_contents(($this->getXwebPath() . "\Settings\port.txt"));
  }


  public function setPort($port) {
    $this->port = $port;
    return $this;
  }

  public function setIp($ip) {
    $this->ip = ($ip);
    return $this;
  }

  public function getPort() {
    return $this->port;
  }

  public function getIp() {
    return $this->ip;
  }



  public function create($request, $response, $args) {

        $sql = "INSERT INTO application.clients  (profileId, command, message, created_at) VALUES (:profileId, :command, :message, :created_at);";
    
          $stmt = $this->container->db->prepare($sql);

          $data = $request->getParsedBody();
          
          $now = date("Y-m-d H:i:s");
          extract($data);

          $scriptsPath = ($this->getScriptsPath() . (($scriptName) ?? "\\$scriptName"));
          $xwebPath = ($this->getXwebPath());
          $xwebClientPath = $xwebPath . ($clientRt == "true" ? "XWeb Human Emulator Studio RT" : "XWeb Human Emulator Studio") . ".exe\"";
          putenv("xweb=\"" . $xwebClientPath . "\"");
          putenv("script=\"" . $scriptsPath . "\"");

          $command = ($this->getIp() . ":" . $this->getPort());
          $stmt->bindParam(':command', $command);
          $stmt->bindParam(':profileId', $profileId);
          $stmt->bindParam(':message', $message);
          $stmt->bindParam(':created_at', $now);


          $stmt->execute();
          $db = null;
        
          $this->startClient(
              array(
                'port' => $this->getPort(),
                'script' => $scriptsPath,
                'script_args' => [$command, $xwebPath],
                'in_tray' => $inTray
              )
          );
        return $response;
   }



  public function startClient(array $args) {
      extract($args);

      $script_args = count($script_args) > 1 ? implode(' ', $script_args) : $script_args;
      $cmd = 'psexec -d %xweb% /port:' . $port . ' /script:"' . $script . '" /script_args:"' . $script_args . '" /in_tray:' . $in_tray . ' ping -n 1 -w 5000 192.168.254.254 >nul';

      return $this->execute($cmd);
   }

   public function execute($cmd) {
      flush();
      
      $proc = proc_open($cmd, [['pipe','r'],['pipe','w'],['pipe','w']], $pipes);
      var_dump(stream_get_wrappers());
      while(($line = fgets($pipes[1])) !== false) {
                fwrite(STDOUT,$line);
      }
      while(($line = fgets($pipes[2])) !== false) {
                fwrite(STDERR,$line);
      }
      fclose($pipes[0]);
      fclose($pipes[1]);
      fclose($pipes[2]);

      proc_close($proc);


  }

   public function createForm($request, $response, $args) {
        $this->container->get('logger')->info("Slim-Skeleton '/' route");

        return $this->container->get('renderer')->render($response, 'newclient.phtml', $args)->setName('client');
   }


}
