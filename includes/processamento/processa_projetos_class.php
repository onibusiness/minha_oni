<?php
/*
* Processa Projetos
* Função de processamento de dados de projetos
*/

class processa_projetos{
    public $projetos;//Todos os projetos vigentes


    //Iniciando a classe
    public function __construct(){
        $this->pegaProjetos();
    }

    /**
    * Busca todos os projetos do minha.oni
    *
    * @return Query com os posts  
    */
    public function pegaProjetos(){

        $args = array(  
            'post_type' => 'projetos' ,
            'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
            'posts_per_page' => -1,
        );
        $projetos = new WP_Query( $args ); 
        $this->projetos = $projetos;

    }

  
    
    /**
    * Cadastra a projeto vindo o pipefy
    *
    * @param Array com as projeto
    *     
    */
    public function cadastraProjeto($id_projeto_pipefy,$nome_projeto){
        //Puxando o id projeto no wordpress 
        $args = array(
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'post_type'		=> 'integracoes',
            'post_status'   => 'publish',
            'meta_key'		=> 'projeto_id_pipefy',
            'meta_value'	=> $id_projeto_pipefy
        );
        $the_query = new WP_Query( $args );
        if ( !$the_query->have_posts() ){
            $my_post_projeto = array(
                'post_title' => $nome_projeto,
                'post_status' => 'publish',
                'post_type' => 'projetos',
            );
            $projeto_post_id = wp_insert_post($my_post_projeto);
            $id_projeto_wordpress = $projeto_post_id;
            update_field('projeto', $nome_projeto, $projeto_post_id);
            wp_reset_postdata();
            

            $my_post = array(
                'post_title' => $nome_projeto,
                'post_status' => 'publish',
                'post_type' => 'integracoes',
            );
            $post_id = wp_insert_post($my_post);
            update_post_meta( $post_id, 'projeto_id_wordpress', $id_projeto_wordpress );
            update_field('projeto_id_pipefy', $id_projeto_pipefy, $post_id);
            update_field('status', 'Ativo', $post_id);

            //Cria o folder do projeto no clickup 
            $projeto_id_clickup = clickup::clickCriaFolder($nome_projeto);
            update_field('projeto_id_clickup', $projeto_id_clickup, $post_id);

            wp_reset_postdata();


        } 
        wp_reset_query();
    }    
}

//Criando o objeto
$processa_projetos = new processa_projetos;

?>