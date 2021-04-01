<?php
/*
* Clickup
* Classe para controlar as requisições no clickup
* 
*/

class clickup{

    //variaveis
    public static $cliente;
    static $organization_id = '3059599';
    static $space_id = '3120689';

    //disparando a classe
    public function __construct(){
        $this->seta_cliente();
    }
  
    public function seta_cliente(){
        require __DIR__."/../../vendor/autoload.php";
        self::$cliente = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.clickup.com/api/v2/',
            'headers' => [
                'Authorization' => 'pk_3107782_OVY2E0F8AEQ3KAXKS9MR3GBU9559XD2N',
            ]
        ]);
    }



    public function pega_spaces(){
        $space = self::$cliente->request('GET','team/'.self::$organization_id.'/space?archived=false');
        $space = $space->getBody();
        $space = json_decode($space);
        return $space;
    }


    public function pega_folders(){
        $folders = self::$cliente->request('GET','team/'.self::$space_id.'/folder?archived=false');
        $folders = $folders->getBody();
        $folders = json_decode($folders);
        return $folders;
    }


    //SPACES AND TEAMS
    //$res = $cliente->request('GET','team/3059599/space?archived=false');
    //FOLDERS
    //$res = $cliente->request('GET','space/3120689/folder?archived=false');
    //LISTS
    //$res = $cliente->request('GET','folder/5299448/list?archived=false');
    //TASKS
    //$res = $cliente->request('GET','list/11455804/task?archived=false&include_closed=true');
    //$body = $res->getBody();
    //$array = json_decode($body);

}

//Criando o objeto
$clickup = new clickup;


echo "<pre>";
var_dump($clickup::pega_spaces());
echo "</pre>";

?>