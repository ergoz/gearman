<?php

class Monitor_Gearman_Server {

    /**
     * @var string
     */
    protected $host = "127.0.0.1";
    /**
     * @var int
     */
    protected $port = 4730;

    /**
     * @param string $host
     * @param int $port
     */
    public function __construct($host=null,$port=null){
        if( !is_null($host) ){
            $this->host = $host;
        }
        if( !is_null($port) ){
            $this->port = $port;
        }
    }

    /**
     * @return array | null
     */
    public function getStatus(){
        $status = null;
        $handle = fsockopen($this->host,$this->port,$errorNumber,$errorString,30);
        if($handle!=null){
            fwrite($handle,"status\n");
            echo "|\tfunction\t|\ttotal\t|\trunning\t|\tworkers\t|".PHP_EOL;
            while (!feof($handle)) {
                $line = fgets($handle, 4096);
                if( $line==".\n"){
                    break;
                }
                if( preg_match("~^(.*)[ \t](\d+)[ \t](\d+)[ \t](\d+)~",$line,$matches) ){
                    echo "|\t".$matches[1]."\t\t|\t".$matches[2]."\t|\t".$matches[3]."\t|\t".$matches[4]."\t|".PHP_EOL;
                }
            }
            fclose($handle);
        }

        return $status;
    }
}

$monitor = new Monitor_Gearman_Server();
print_r($monitor->getStatus());