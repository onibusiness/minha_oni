<?php
/*
* Advertências
* Cria um post type chamado Advertências e todas as suas configurações no ACF
*/

class advertencias{

    //variaveis
    private $nome_singular = 'Advertência';
    private $nome_plural = 'Advertências';
    private $post_slug = 'advertencias';

    //disparando a classe
    public function __construct(){
        add_action('init', array($this,'initCPT'));
        add_action('init', array($this,'adicionarCamposACF')); 
        add_filter('manage_'.$this->post_slug.'_posts_columns', array($this,'criarColunasAdmin')); 
        add_filter('manage_edit-'.$this->post_slug.'_sortable_columns', array($this,'criarColunasAdmin')); 
        add_action('manage_'.$this->post_slug.'_posts_custom_column', array($this,'exibirColunasAdmin'),10,2); 
    }
    public function initCPT(){
        cpt::adicionarCustomPostType($this->nome_singular,$this->nome_plural, $this->post_slug);
    }

    //Adicionando os campos do ACF
    public function adicionarCamposACF(){
        if( function_exists('acf_add_local_field_group') ):
            acf_add_local_field_group(array(
                'key' => 'group_5fb3cc63a755f',
                'title' => 'Advertências',
                'fields' => array(
                    array(
                        'key' => 'field_5fb3cc7608aad',
                        'label' => 'Data',
                        'name' => 'data',
                        'type' => 'date_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_5fb3cc8b08aae',
                        'label' => 'Oni',
                        'name' => 'oni',
                        'type' => 'user',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'role' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                        'acfe_bidirectional' => array(
                            'acfe_bidirectional_enabled' => '0',
                        ),
                    ),
                    array(
                        'key' => 'field_5fb3cc9a08aaf',
                        'label' => 'Explicação',
                        'name' => 'explicacao',
                        'type' => 'textarea',
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
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => '',
                        'acfe_textarea_code' => 0,
                    ),
                    array(
                        'key' => 'field_60afd4e32fbee',
                        'label' => 'Desconta onion',
                        'name' => 'desconta_onion',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'sim' => 'sim',
                            'nao' => 'nao',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'vertical',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
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

    //Mostrando os campos como colunas na lista do admin
    public function criarColunasAdmin($columns){
        return array_merge ( $columns, array ( 
            'oni' => __ ( 'Oni' )
          ) );
    }
    public function exibirColunasAdmin( $column, $post_id ) {
        switch ( $column ) {
          case 'oni':
            $oni = get_field('oni',$post_id);
            echo $oni->data->display_name;
   
            break;
        }
      }
} 

//Criando o objeto
$advertencias = new advertencias;
?>