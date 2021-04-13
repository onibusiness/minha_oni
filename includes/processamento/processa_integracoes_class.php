<?php
/*
* Integrações e relacionamento
* 
*/

class processa_integracoes{



    /**
    * Criando o id do pipefy na tabela de integrações
    *
    * @param String $id com o id do projeto no pipefy
    * @param String $nome com o nome do projeto no pipefy
    * @return New_Posts 
    *      Post integração
    *      Post projeto
    *     
    */
    public static function cadastraIdPipefy($id, $nome){
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'integracoes',
            'post_status'   => 'publish',
            'meta_key'		=> 'projeto_id_pipefy',
            'meta_value'	=> $id
        );
        $the_query = new WP_Query( $args );
        if ( !$the_query->have_posts() ) :
            $my_post = array(
                'post_title' => $nome,
                'post_status' => 'publish',
                'post_type' => 'integracoes',
            );
            
            $post_id = wp_insert_post($my_post);
            update_field('projeto_id_pipefy', $id, $post_id);
        
            wp_reset_postdata();
            $this->cadastraProjetoMinhaOni($nome);
        endif;
    }

    /**
    * Criando o projeto no minha.oni
    *
    * @param String $nome com o nome do projeto no pipefy
    * @return New_Posts 
    *      Post projeto
    *     
    */
    public function cadastraProjetoMinhaOni($nome){
        $args = array(
            'numberposts'	=> -1,
            'post_type'		=> 'projetos',
            'post_status'   => 'publish',
            'title' => $nome
        );
        $the_query = new WP_Query( $args );
        if ( !$the_query->have_posts() ) :
            $my_post = array(
                'post_title' => $nome,
                'post_status' => 'publish',
                'post_type' => 'projetos',
            );
            
            $post_id = wp_insert_post($my_post);
            update_field('projeto', $nome, $post_id);
            update_field('status', 'Ativo', $post_id);
        
        wp_reset_postdata();
        endif;
    }

}

//Criando o objeto
$processa_integracoes = new processa_integracoes;


?>