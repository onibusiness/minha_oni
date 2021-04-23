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

    public function clickCriaList($nome_frente, $data_inicio, $data_fim, $assignee, $horas, $folder_id){
        //Pegando o id do clickup pelo nome do usuário
        $user_query = new WP_User_Query( array( 'search' => $assignee ) );
        $authors = $user_query->get_results();
        foreach ($authors as $author)
        {   
            $id_do_clickup = get_field('id_do_clickup', 'user_'. $author->ID);
        }
        $list_criada = self::$cliente->request('POST','folder/'.$folder_id.'/list',
            array(
                'form_params' => array(
                    'name' => $nome_frente,
                    'description' => $descricao,
                    'start_date' => $data_inicio.'000',
                    'start_date_time' => 'false',
                    'due_date' => $data_fim.'000',
                    'due_date_time' => 'false',
                    'assignee' => $id_do_clickup,
                    'time_estimate' => strval($horas*60*60*1000)

                )
            )
        );
        $list_criada = $list_criada->getBody();
        $list_criada = json_decode($list_criada);
        //retornando o id do folder recém criado
        return $list_criada->id;
        
    }

    public function clickMissoesGestao($id_projeto_wordpress,$list_id, $data_inicio,$data_fim,$guardiao){
        //FAZER UMA FUNÇÃO PARA PUXAR OS GUARDIÕES DE VISÃO E TIME
        $missoes_start_frente = get_field('start_de_frente', 'missoes_de_gestao');
        $missoes_andamento_frente = get_field('andamento_da_frente', 'missoes_de_gestao');
        $missoes_fechamento_frente = get_field('fechamento_de_frente', 'missoes_de_gestao');
        //Pegando o id do clickup do guardião de método pelo nome do usuário
        $user_query = new WP_User_Query( array( 'search' => $guardiao ) );
        $authors = $user_query->get_results();
   
        foreach ($authors as $author)
        {      
            $guardiao_metodo_id_do_clickup = get_field('informacoes_gerais', 'user_'. $author->ID);
            $guardiao_metodo_id_do_clickup = $guardiao_metodo_id_do_clickup['id_do_clickup'];      
        }
        wp_reset_query();
        //Puxando o guardiao de visao
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'papel',
                    'value' => 'guardiao_visao',
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $guardiao_visao =   get_field('oni');
            $guardiao_visao_id_do_clickup = get_field('informacoes_gerais', 'user_'. $guardiao_visao);
            $guardiao_visao_id_do_clickup = $guardiao_visao_id_do_clickup['id_do_clickup'];
        endwhile;endif;
        wp_reset_query();


         //Puxando o guardiao de time
         $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'papel',
                    'value' => 'guardiao_time',
                    'compare' => '='
                ),
        
                array(
                    'key' => 'projeto',
                    'value' => $id_projeto_wordpress,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $guardiao_time =   get_field('oni');
            $guardiao_time_id_do_clickup = get_field('informacoes_gerais', 'user_'. $guardiao_time);
            $guardiao_time_id_do_clickup = $guardiao_time_id_do_clickup['id_do_clickup'];
        endwhile;endif;
        wp_reset_query();

        //Fazendo as missões de abertura de frente
        foreach($missoes_start_frente as $key => $missao_start_frente){
            $assignee = 00000;
            if($missao_start_frente['responsavel'] == "guardiao_metodo"){
                $assignee = $guardiao_metodo_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_visao"){
                $assignee = $guardiao_visao_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_time"){
                $assignee = $guardiao_time_id_do_clickup;
            }
            $dias_antes = '- '.$missao_start_frente['dias_antes_do_start_da_frente'].' day';
            $data_da_missao = $data_inicio->modify($dias_antes);
            $data_da_missao = $data_inicio->getTimestamp();

            $task_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $missao_start_frente['missao'],
                        'description' => $missao_start_frente['descricao'],
                        'assignees' => [$assignee],
                        'tags' => ['1.planejamento de frente'],
                        'due_date' => $data_da_missao.'000',
                        'due_date_time' => 'false',
                        'time_estimate' => strval($missao_start_frente['tempo']*60*60*1000),
                        'start_date' => $data_da_missao.'000',
                        'start_date_time' => 'false',
                    )
                )
            );
            $task_criada = $task_criada->getBody();
            $task_criada = json_decode($task_criada);
            foreach($missao_start_frente['subtasks'] as $subtask){
                $subtask_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $subtask['subtask'],
                        'parent' => $task_criada->id,
                        
                    )
                )
            );
                
            }
        }

       //Fazendo as missões de acompanhamento de frente
       foreach($missoes_andamento_frente as $key => $missao_andamento_frente){
            $assignee = 00000;
            if($missao_start_frente['responsavel'] == "guardiao_metodo"){
                $assignee = $guardiao_metodo_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_visao"){
                $assignee = $guardiao_visao_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_time"){
                $assignee = $guardiao_time_id_do_clickup;
            }
            $interval = $data_inicio->diff($data_fim);
            $semanas = ceil($interval->days/7);
            $data_inicio_ts = $data_inicio->getTimestamp();
            $data_fim_ts = $data_fim->getTimestamp();
            $task_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $missao_andamento_frente['missao'],
                        'description' => $missao_start_frente['descricao'],
                        'assignees' => [$assignee],
                        'tags' => ['2. acompanhamento de frente'],
                        'due_date' => $data_fim_ts.'000',
                        'due_date_time' => 'false',
                        'time_estimate' => strval($semanas*$missao_andamento_frente['tempo']*60*60*1000),
                        'start_date' => $data_inicio_ts.'000',
                        'start_date_time' => 'false',
                    )
                )
            );
            $task_criada = $task_criada->getBody();
            $task_criada = json_decode($task_criada);

            foreach($missao_andamento_frente['subtasks'] as $subtask){
                $subtask_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $subtask['subtask'],
                        'parent' => $task_criada->id,
                        
                    )
                )
            );
                
            }
        }



        //Fazendo as missões de fechamento de frente
        foreach($missoes_fechamento_frente as $key => $missao_fechamento_frente){
            $assignee = 00000;
            if($missao_start_frente['responsavel'] == "guardiao_metodo"){
                $assignee = $guardiao_metodo_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_visao"){
                $assignee = $guardiao_visao_id_do_clickup;
            }
            if($missao_start_frente['responsavel'] == "guardiao_time"){
                $assignee = $guardiao_time_id_do_clickup;
            }
            $dias_depois = '+ '.$missao_fechamento_frente['dias_depois_do_termino_da_frente'].' day';
            $data_da_missao = $data_fim->modify($dias_depois);
            $data_da_missao = $data_fim->getTimestamp();
            $task_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $missao_fechamento_frente['missao'],
                        'description' => $missao_start_frente['descricao'],
                        'assignees' => [$assignee],
                        'tags' => ['3. fechamento de frente'],
                        'due_date' => $data_da_missao.'000',
                        'due_date_time' => 'false',
                        'time_estimate' => strval($missao_fechamento_frente['tempo']*60*60*1000),
                        'start_date' => $data_da_missao.'000',
                        'start_date_time' => 'false',
                    )
                )
            );
            $task_criada = $task_criada->getBody();
            $task_criada = json_decode($task_criada);
            foreach($missao_fechamento_frente['subtasks'] as $subtask){
                $subtask_criada = self::$cliente->request('POST','list/'.$list_id.'/task',
                array(
                    'json' => array(
                        'name' => $subtask['subtask'],
                        'parent' => $task_criada->id,
                        
                    )
                )
            );
                
            }
        }

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