<?php
/*
* cadastra projetos
* Classe que automatiza toda a criação de projetos a partir do webhook
*/

class cadastra_projetos{
    public $nome_projeto_cadastrado; // nome do projeto
    public $table_record_projeto; // record do pipefy de projeto da database projeto
    public $table_records_frentes; // records do pipefy de frentes da databe frentes
    public $id_pipefy_projeto_cadastrado; // id do projeto no pipefy
    public $id_wordpress_projeto_cadastrado; // id do projeto no wordpress
    public $id_clickup_projeto_cadastrado; // id do folder do clickup
    public $obj_guardiao_visao; // obj do guardiao de visão do projeto
    public $obj_guardiao_time; // obj do guardiao de time do projeto
    public $frentes; // array das frentes processadas


    function __construct($projeto_cadastrado){
        $this->pegaDadosProjetoCadastrado($projeto_cadastrado);
        $this->pegaDadosFrentesCadastradas();
        $this->cadastraProjeto();
        $this->criaFolderClickup();
        $this->cadastraIntegracao();
        $this->cadastraPapelVisaoETime();
        $this->cadastraFrentes();
        $this->cadastraPapelMetodo();
        $this->criaListaClickup();
        $this->clickMissoesGestao();
    }

    /**
    * 
    * Função para pegar os dados do projeto vindos do pipefy
    * 
    */
    function pegaDadosProjetoCadastrado($projeto_cadastrado){
        $this->id_pipefy_projeto_cadastrado = $projeto_cadastrado['projeto_cadastrado'][0];
        //pega os dados do card do projeto alterado
        $this->table_record_projeto = pipefy::puxaDaTabela($projeto_cadastrado['projeto_cadastrado']);
        //Pegando os database records das frentes cadastradas
        $this->table_records_frentes = pipefy::puxaDaTabela($projeto_cadastrado['frentes_cadastradas']);
        //Busca a key dos record fields e retorna o nome do projeto
        $key_nome_projeto = array_search('Nome do projeto', array_column($this->table_record_projeto[0]['data']['table_record']['record_fields'], 'name'));
        $this->nome_projeto_cadastrado = $this->table_record_projeto[0]['data']['table_record']['record_fields'][$key_nome_projeto]['value'];
        //Busca a key dos record fields e retorna o guardião de visão
        $key_guardiao_visao = array_search('Guardião de visão', array_column($this->table_record_projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_visao = $this->table_record_projeto[0]['data']['table_record']['record_fields'][$key_guardiao_visao]['value'];
        //Pegando o usuário do guardiao de visao
        if($guardiao_visao){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_visao,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $this->obj_guardiao_visao = $author;
                //$id_guardiao_visao = $obj_guardiao_visao->ID;
            }
        }
        //Busca a key dos record fields e retorna o guardião de time
        $key_guardiao_time = array_search('Guardião de time', array_column($this->table_record_projeto[0]['data']['table_record']['record_fields'], 'name'));
        $guardiao_time = $this->table_record_projeto[0]['data']['table_record']['record_fields'][$key_guardiao_time]['value'];
        wp_reset_query();
        //Pegando o usuário do guardião de time
        if($guardiao_time){
            $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_time,2,-2) ) );
            $authors = $user_query->get_results();
            foreach ($authors as $author)
            {   
                $this->obj_guardiao_time = $author;
                //$id_guardiao_time = $obj_guardiao_time->ID;
            }
        }
        wp_reset_query();
        //Busca a key dos record fields e retorna a data de início
        $key_data_inicio = array_search('Data de início', array_column($this->table_record_projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_inicio = $this->table_record_projeto[0]['data']['table_record']['record_fields'][$key_data_inicio]['value'];
        $this->data_de_inicio =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
        //Busca a key dos record fields e retorna a data de fim
        $key_data_fim = array_search('Data de término', array_column($this->table_record_projeto[0]['data']['table_record']['record_fields'], 'name'));
        $data_de_fim = $this->table_record_projeto[0]['data']['table_record']['record_fields'][$key_data_fim]['value'];   
        $this->data_de_fim =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");  
    }

    /**
    * 
    * Função para processar as frentes vindas do pipefy
    * 
    */
    function pegaDadosFrentesCadastradas(){
        foreach($this->table_records_frentes as $frente){
            //Busca a key dos record fields e retorna o nome da frente
            $key_nome_frente = array_search('Nome da frente', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $nome_da_frente = $frente['data']['table_record']['record_fields'][$key_nome_frente]['value'];
            //Busca a key dos record fields e retorna a data de inicio
            $key_data_de_inicio = array_search('Data de início', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_inicio = $frente['data']['table_record']['record_fields'][$key_data_de_inicio]['value'];
            $data_de_inicio_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_inicio )->format("Ymd");
            $data_de_inicio_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_inicio);
            $data_de_inicio_ts = $data_de_inicio_obj->getTimestamp();
            //Busca a key dos record fields e retorna a data de término
            $key_data_de_fim = array_search('Data de término', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $data_de_fim = $frente['data']['table_record']['record_fields'][$key_data_de_fim]['value'];
            $data_de_fim_ymd =  DateTime::createFromFormat('d/m/Y',  $data_de_fim )->format("Ymd");
            $data_de_fim_obj = DateTimeImmutable::createFromFormat('d/m/Y', $data_de_fim);
            $data_de_fim_ts = $data_de_fim_obj->getTimestamp();
            //Busca a key dos record fields e retorna as horas
            $key_horas = array_search('Horas', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $horas = $frente['data']['table_record']['record_fields'][$key_horas]['value'];
            //Pega o ID da frente
            $id_da_frente_pipefy =  $frente['data']['table_record']['id'];
            //Busca a key dos record fields e retorna o guardiao de método
            $key_guardiao_metodo = array_search('Guardião de método', array_column($frente['data']['table_record']['record_fields'], 'name'));
            $guardiao_metodo =   $frente['data']['table_record']['record_fields'][$key_guardiao_metodo]['value'];
            if($guardiao_metodo){
                $user_query = new WP_User_Query( array( 'search' =>  substr($guardiao_metodo,2,-2) ) );
                $authors = $user_query->get_results();
                foreach ($authors as $author)
                {   
                    $obj_guardiao_metodo = $author;
                    $id_guardiao_metodo =  $obj_guardiao_metodo->ID;
                }
                
            }
            $dados_guardiao_metodo = get_field('informacoes_gerais', 'user_'.$id_guardiao_metodo);
            $id_clickup_guardiao_metodo = $dados_guardiao_metodo['id_do_clickup'];
            //Empurrando os dados processados para o array
            $this->frentes[$id_da_frente_pipefy] = 
            array(
                'id_da_frente_pipefy' => $id_da_frente_pipefy,
                'id_da_frente_wordpress' => '',
                'id_da_frente_clickup' => '',
                'nome_da_frente' => $nome_da_frente,
                'data_de_inicio' => $data_de_inicio,
                'data_de_inicio_ymd' => $data_de_inicio_ymd,
                'data_de_inicio_obj' => $data_de_inicio_obj,
                'data_de_inicio_ts' => $data_de_inicio_ts,
                'data_de_fim' => $data_de_fim,
                'data_de_fim_ymd' => $data_de_fim_ymd,
                'data_de_fim_obj' => $data_de_fim_obj,
                'data_de_fim_ts' => $data_de_fim_ts,
                'horas' => $horas,
                'guardiao_metodo' => $guardiao_metodo,
                'obj_guardiao_metodo' => $obj_guardiao_metodo,
                'id_guardiao_metodo' => $id_guardiao_metodo,
                'id_clickup_guardiao_metodo' => $id_clickup_guardiao_metodo,
            );
        }
    }

    /**
    * 
    * Função para cadastrar o projeto no minha.oni
    * 
    */
    function cadastraProjeto(){
        //Criando o post projeto
        $my_post_projeto = array(
            'post_title' => $this->nome_projeto_cadastrado,
            'post_status' => 'publish',
            'post_type' => 'projetos',
        );
        $projeto_post_id = wp_insert_post($my_post_projeto);
        $this->id_wordpress_projeto_cadastrado = $projeto_post_id;
        update_field('projeto', $this->nome_projeto_cadastrado, $projeto_post_id);
        update_field('status', 'ativo', $projeto_post_id);
        update_field('score', '1', $projeto_post_id);
        update_post_meta( $projeto_post_id, 'status', 'ativo' );
        wp_reset_postdata();
    }

    /**
    * 
    * Função para cadastrar o folder do projeto no clickup
    * 
    */
    function criaFolderClickup(){
        $folder_criado = clickup::$cliente->request('POST','space/'.clickup::$space_id.'/folder',
            array(
                'form_params' => array(
                    'name' => $this->nome_projeto_cadastrado
                )
            )
        );
        $folder_criado = $folder_criado->getBody();
        $folder_criado = json_decode($folder_criado);
        //retornando o id do folder recém criado
        $this->id_clickup_projeto_cadastrado = $folder_criado->id;
    }

    /**
    * 
    * Função para cadastrar a base de integrações do projeto
    * 
    */
    function cadastraIntegracao(){     
        //Criando o post integração
        $my_post = array(
            'post_title' => $this->nome_projeto_cadastrado,
            'post_status' => 'publish',
            'post_type' => 'integracoes',
        );
        $post_id = wp_insert_post($my_post);
        update_field('projeto_id_wordpress', $this->id_wordpress_projeto_cadastrado, $post_id);
        update_field('projeto_id_pipefy', $this->id_pipefy_projeto_cadastrado, $post_id);
        update_field('projeto_id_clickup', $this->id_clickup_projeto_cadastrado, $post_id);
        wp_reset_postdata();
    }

    /**
    * 
    * Função para cadastrar as os gestores do projeto
    * 
    */
    function cadastraPapelVisaoETime(){
        //Fazendo o loop de cadastro de visão
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $this->obj_guardiao_visao->ID,
                    'compare' => '='
                ),

                array(
                    'key' => 'projeto',
                    'value' => $this->id_wordpress_projeto_cadastrado,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ) :
        else:
            $my_post = array(
                'post_title' => $this->nome_projeto_cadastrado.' - Visão - '.$this->obj_guardiao_visao->display_name,
                'post_status' => 'publish',
                'post_type' => 'papeis',
                'post_author' => 1
            );
            
            $post_id = wp_insert_post($my_post);
            update_field('field_5fa2b397170ec', $this->obj_guardiao_visao->ID , $post_id);
            update_post_meta( $post_id, 'oni', $this->obj_guardiao_visao->ID );
            update_field('oniid', $this->obj_guardiao_visao->ID , $post_id);
            update_field('data_de_inicio', $this->data_de_inicio, $post_id);
            update_field('data_de_terminio', $this->data_de_fim, $post_id);        
            update_field('papel', 'guardiao_visao', $post_id);
            update_field('projeto', $this->id_wordpress_projeto_cadastrado, $post_id);
        endif;
        wp_reset_postdata();

        //Fazendo o loop de cadastro de time
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'oni',
                    'value' => $this->obj_guardiao_time->ID,
                    'compare' => '='
                ),

                array(
                    'key' => 'projeto',
                    'value' => $this->id_wordpress_projeto_cadastrado,
                    'compare' => '='
                )
            )
        );
        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ) :
        else:
            $my_post = array(
                'post_title' => $this->nome_projeto_cadastrado.' - Time - '.$this->obj_guardiao_time->display_name,
                'post_status' => 'publish',
                'post_type' => 'papeis',
                'post_author' => 1
            );
            
            $post_id = wp_insert_post($my_post);
            update_field('field_5fa2b397170ec', $this->obj_guardiao_time->ID , $post_id);
            update_post_meta( $post_id, 'oni', $this->obj_guardiao_time->ID );
            update_field('oniid', $this->obj_guardiao_time->ID , $post_id);
            update_field('data_de_inicio', $this->data_de_inicio, $post_id);
            update_field('data_de_terminio', $this->data_de_fim, $post_id);        
            update_field('papel', 'guardiao_time', $post_id);
            update_field('projeto', $this->id_wordpress_projeto_cadastrado, $post_id);
        endif;
        wp_reset_postdata();
    }

    /**
    * 
    * Função para cadastrar as frentes
    * 
    */
    function cadastraFrentes(){
        foreach($this->frentes as $key => $frente){
            $args = array(
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'post_type'		=> 'frentes',
                'post_status'   => 'publish',
                'meta_key'		=> 'id_da_frente_pipefy',
                'meta_value'	=> $frente['id_da_frente_pipefy']
            );
            $the_query = new WP_Query( $args );
            //Se tiver a frente ele altera em outra função
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            endwhile;
            //Se não tiver frente ele cria uma nova
            else:
                $my_post = array(
                    'post_title' => $this->nome_projeto_cadastrado.' | '.$frente['nome_da_frente'],
                    'post_status' => 'publish',
                    'post_type' => 'frentes',
                    'post_author' => 1
                );
                
                $post_id = wp_insert_post($my_post);              
                update_field('field_6076de315f6c9', $this->id_wordpress_projeto_cadastrado, $post_id);
                update_field('nome_da_frente', $frente['nome_da_frente'], $post_id);
                update_field('id_da_frente_pipefy', $frente['id_da_frente_pipefy'], $post_id);
                update_field('data_de_inicio', $frente['data_de_inicio_ymd'], $post_id);
                update_field('data_de_fim', $frente['data_de_fim_ymd'], $post_id);
                update_field('horas', $frente['horas'], $post_id);
                //Adicionando o id do wordpress na propriedade
                $this->frentes[$key]['id_da_frente_wordpress'] = $post_id;
                //Dar update depois no clickup
                //update_field('id_da_frente_clickup', $frente_id_clickup, $post_id);
            endif; 
            wp_reset_query();
        }
    }

    /**
    * 
    * Função para cadastrar os guardiões de método por frentes
    * 
    */
    function cadastraPapelMetodo(){
        foreach($this->frentes as $key => $frente){

           //Fazendo uma query de papés já existentes
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'papeis',
                'post_status'   => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'oni',
                        'value' => $frente['id_guardiao_metodo'],
                        'compare' => '='
                    ),
                    array(
                        'key' => 'papel',
                        'value' => 'guardiao_metodo',
                        'compare' => '='
                    ),
            
                    array(
                        'key' => 'frente',
                        'value' => $frente['id_da_frente_wordpress'],
                        'compare' => '='
                    )
                )
            );
            $the_query = new WP_Query( $args );
            
   
            if ($the_query->have_posts() ) :
            else:
                $my_post = array(
                    'post_title' => $this->nome_projeto_cadastrado.' - Método '.$frente['nome_da_frente'].' - '.$frente['obj_guardiao_metodo']->display_name,
                    'post_status' => 'publish',
                    'post_type' => 'papeis',
                    'post_author' => 1
                );
                
                $post_id = wp_insert_post($my_post);
                update_field('field_5fa2b397170ec', $frente['obj_guardiao_metodo']->ID, $post_id);
                update_post_meta( $post_id, 'oni', $frente['id_guardiao_metodo']);
                update_field('oniid', $frente['obj_guardiao_metodo']->ID, $post_id);
                //update_post_meta( $post_id, 'frente', $id_frente_wordpress );
                update_field('frente', $frente['id_da_frente_wordpress'], $post_id);
                update_field('data_de_inicio', $frente['data_de_inicio'], $post_id);
                update_field('data_de_terminio', $frente['data_de_fim'], $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $this->id_wordpress_projeto_cadastrado, $post_id);
            endif;
            wp_reset_postdata();
        }
    }

    /**
    * 
    * Função para criar a lista no clickup
    * 
    */
    function criaListaClickup(){
        foreach($this->frentes as $key => $frente){
            $list_criada = clickup::$cliente->request('POST','folder/'.$this->id_clickup_projeto_cadastrado.'/list',
                array(
                    'form_params' => array(
                        'name' => $frente['nome_da_frente'],
                        'description' => $frente['horas']."h",
                        'start_date' => $frente['data_de_inicio_ts'].'000',
                        'start_date_time' => false,
                        'due_date' => $frente['data_de_fim_ts'].'000',
                        'due_date_time' => false,
                        'assignee' => $frente['id_clickup_guardiao_metodo'],
                        'time_estimate' => strval($frente['horas']*60*60*1000)

                    )
                )
            );
            $list_criada = $list_criada->getBody();
            $list_criada = json_decode($list_criada);
            //Setando o id da frente no clickup
            $this->frentes[$key]['id_da_frente_clickup'] = $list_criada->id;
        }
    }


    /**
    * 
    * Função para cadastrar as missões
    * 
    */
    function clickMissoesGestao(){

    }
}