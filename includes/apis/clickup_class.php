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
    //Está com o id do space Sandbox
    static $space_id = '3209515';

    //disparando a classe
    public function __construct(){
        $this->clickupSetaClienteAPI();
    }
  
    public function clickupSetaClienteAPI(){
        require __DIR__."/../../vendor/autoload.php";
        self::$cliente = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.clickup.com/api/v2/',
            'headers' => [
                'Authorization' => 'pk_3107782_NEBGITMKOL2CCD4ECS3WPAZUR200G1MU',
            ]
        ]);
    }


    public function clickupPegaSpaces(){
        $space = self::$cliente->request('GET','team/'.self::$organization_id.'/space?archived=false');
        $space = $space->getBody();
        $space = json_decode($space);
        return $space;
    }


    public function clickupPegaFolders(){
        $folders = self::$cliente->request('GET','space/'.self::$space_id.'/folder?archived=false');
        $folders = $folders->getBody();
        $folders = json_decode($folders);
        return $folders;
    }

    public function clickCriaFolder($nome_projeto){
        $folder_criado = self::$cliente->request('POST','space/'.self::$space_id.'/folder',
            array(
                'form_params' => array(
                    'name' => $nome_projeto
                )
            )
        );
        $folder_criado = $folder_criado->getBody();
        $folder_criado = json_decode($folder_criado);
        //retornando o id do folder recém criado
        return $folder_criado->id;
        
    }

    public function clickCriaList($nome_frente, $data_inicio, $data_fim, $assignee, $folder_id){
        $list_criada = self::$cliente->request('POST','folder/'.$folder_id.'/list',
            array(
                'form_params' => array(
                    'name' => $nome_frente,
                    'description' => $descricao,
                    'start_date' => $data_inicio.'000',
                    'start_date_time' => 'false',
                    'due_date' => $data_fim.'000',
                    'due_date_time' => 'false',
                    'assignee' => $assignee,
                    'time_estimate' => 8640000

                )
            )
        );
        $list_criada = $list_criada->getBody();
        $list_criada = json_decode($list_criada);
        //retornando o id do folder recém criado
        return $list_criada->id;
        
    }

    public function clickMissoesGestao($list_id, $data_inicio,$guardiao){
        $missoes_start_frente = get_field('start_de_frente', 'missoes_de_gestao');
        $missoes_andamento_frente = get_field('andamento_da_frente', 'missoes_de_gestao');
        $missoes_fechamento_frente = get_field('fechamento_de_frente', 'missoes_de_gestao');
        /*
        $user_query = new WP_User_Query( array( 'search' => $guardiao ) );
        $authors = $user_query->get_results();
        foreach ($authors as $author)
        {   
            $id_do_clickup = get_field('id_do_clickup', 'user_'. $author->ID);
        }*/
        //Rodar um foreach em cima de um template, cadastrado como options
        set_transient('missao',
                array(
                    $missoes_start_frente
                )
            );
        foreach($missoes_start_frente as $key => $missao_start_frente){

            $dias_antes = '- '.$missao_start_frente['dias_antes_do_start_da_frente'].' day';
            $data_da_missao = $data_inicio->modify($dias_antes);
            $data_da_missao = $data_inicio->getTimestamp();
            set_transient('missao',
                array(
                    $dias_antes,
                    $data_inicio,

                    $missao_start_frente['missao'],
                    $data_da_missao.'000',
                    $data_da_missao.'000',
                    $missao_start_frente['tempo']*60*60,
                    $guardiao
                )
            );
            // NÃO ESTÁ CRIANDO O TEMPO NEM COLOCANDO OS REPONSÁVEIS
            $task_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'form_params' => array(
                        'name' => $missao_start_frente['missao'].$guardiao,
                        'assignee' => $guardiao,
                        'tags' => ['1', '2'],
                        'due_date' => $data_da_missao.'000',
                        'due_date_time' => 'false',
                        'time_estimate' => $missao_start_frente['tempo'],
                        'start_date' => $data_da_missao.'000',
                        'start_date_time' => 'false',
                    )
                )
            );
            $task_criada = $task_criada->getBody();
            $task_criada = json_decode($task_criada);
            //retornando o id da missao
        }
        return $task_criada->id;
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


?>