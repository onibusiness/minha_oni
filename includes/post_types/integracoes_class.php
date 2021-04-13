<?php
/*
* Integrações e relacionamento
* Cria um post type chamado integrações que cria as relações entre as ferramentas
* 
*/

class integracoes{

    //variaveis
    private $nome_singular = 'Integração';
    private $nome_plural = 'Integrações';
    private $post_slug = 'integracoes';



    //disparando a classe
    public function __construct(){
        add_action('init', array($this,'initCPT'));
        add_action('init', array($this,'adicionarCamposACF')); 
    }
    public function initCPT(){
        cpt::adicionarCustomPostType($this->nome_singular,$this->nome_plural, $this->post_slug);
    }

    //Adicionando os campos do ACF
    public function adicionarCamposACF(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_605df428b71b6',
                'title' => 'Integrações',
                'fields' => array(
                    array(
                        'key' => 'field_605df43b2c34a',
                        'label' => 'Projeto_id_wordpress',
                        'name' => 'projeto_id_wordpress',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'post_type' => array(
                            0 => 'projetos',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                        'save_custom' => 0,
                        'save_post_status' => 'publish',
                        'acfe_bidirectional' => array(
                            'acfe_bidirectional_enabled' => '0',
                        ),
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_605df51b2c34b',
                        'label' => 'Projeto_id_clickup',
                        'name' => 'projeto_id_clickup',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_605df54433732',
                        'label' => 'Projeto_id_pipefy',
                        'name' => 'projeto_id_pipefy',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_605df577cd02b',
                        'label' => 'Projeto_id_discord',
                        'name' => 'projeto_id_discord',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => $this->post_slug,
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'left',
                'instruction_placement' => 'label',
                'hide_on_screen' => array(
                    0 => 'permalink',
                    1 => 'block_editor',
                    2 => 'the_content',
                    3 => 'excerpt',
                    4 => 'discussion',
                    5 => 'comments',
                    6 => 'revisions',
                    7 => 'slug',
                    8 => 'author',
                    9 => 'format',
                    10 => 'page_attributes',
                    11 => 'featured_image',
                    12 => 'categories',
                    13 => 'tags',
                    14 => 'send-trackbacks',
                ),
                'active' => true,
                'description' => '',
                'acfe_display_title' => '',
                'acfe_autosync' => '',
                'acfe_permissions' => '',
                'acfe_form' => 0,
                'acfe_meta' => '',
                'acfe_note' => '',
            ));
            
            endif;
    }


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
$integracoes = new integracoes;


?>