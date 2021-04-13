<?php
/*
* Competencias
* Cria um post type chamado competencias e todas as suas configurações no ACF
* Configura a taxonomia Esferas para organizar tudo
*/

class competencias{

    //variaveis
    private $nome_singular = 'Competência';
    private $nome_plural = 'Competências';
    private $post_slug = 'competencias';

    //disparando a classe
    public function __construct(){
        add_action('init', array($this,'initCPT'));
        add_action('init', array($this,'adicionarCamposACF')); 
        add_action('init', array($this,'criaEsferas')); 
    }
    public function initCPT(){
        cpt::adicionarCustomPostType($this->nome_singular,$this->nome_plural, $this->post_slug);
    }

    //Adicionando os campos do ACF
    public function adicionarCamposACF(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5f400ef211b48',
                'title' => 'Competências do sistema',
                'fields' => array(
                    array(
                        'key' => 'field_5f400f4bd2fd3',
                        'label' => 'Explicação',
                        'name' => 'explicacao',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
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
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => array(
                    0 => 'permalink',
                    1 => 'the_content',
                    2 => 'excerpt',
                    3 => 'discussion',
                    4 => 'comments',
                    5 => 'revisions',
                    6 => 'slug',
                    7 => 'author',
                    8 => 'format',
                    9 => 'page_attributes',
                    10 => 'featured_image',
                    11 => 'categories',
                    12 => 'tags',
                    13 => 'send-trackbacks',
                ),
                'active' => true,
                'description' => '',
            ));
            
        endif;
    }

    //Função para criar a taxonomia Esferas
    public function criaEsferas(){
 
        $labels = array(
            'name' => _x( 'Esferas', 'taxonomy general name' ),
            'singular_name' => _x( 'Esfera', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Esferas' ),
            'all_items' => __( 'All Esferas' ),
            'parent_item' => __( 'Parent Esfera' ),
            'parent_item_colon' => __( 'Parent Esfera:' ),
            'edit_item' => __( 'Edit Esfera' ), 
            'update_item' => __( 'Update Esfera' ),
            'add_new_item' => __( 'Add New Esfera' ),
            'new_item_name' => __( 'New Esfera Name' ),
            'menu_name' => __( 'Esferas' ),
        );    
        
        
        register_taxonomy('esfera',array($this->post_slug), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'esfera' ),
        ));
        
    }

}

//Criando o objeto
$competencias = new competencias;
?>