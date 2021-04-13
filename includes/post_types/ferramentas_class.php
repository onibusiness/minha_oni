<?php
/*
* Ferramentas e equipamentos
* Cria um post type chamado ferramentas e todas as suas configurações no ACF

*/

class ferramentas{

    //variaveis
    private $nome_singular = 'Ferramenta';
    private $nome_plural = 'Ferramentas';
    private $post_slug = 'ferramentas';


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
                'key' => 'group_5f6b5bc98d087',
                'title' => 'Ferramentas',
                'fields' => array(
                    array(
                        'key' => 'field_5f6b5bce78f0f',
                        'label' => 'Link para a ferramenta',
                        'name' => 'link_para_a_ferramenta',
                        'type' => 'url',
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
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5c1a533d1',
                        'label' => 'Data de contratação',
                        'name' => 'data_de_contratacao',
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
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5c5d533d2',
                        'label' => 'Data de expiração',
                        'name' => 'data_de_expiracao',
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
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5c7c533d3',
                        'label' => 'Login',
                        'name' => 'login',
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
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5c86533d4',
                        'label' => 'Senha',
                        'name' => 'senha',
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
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5d2a2d6d9',
                        'label' => 'Usuários',
                        'name' => 'usuarios',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'acfe_repeater_stylised_button' => 0,
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'table',
                        'button_label' => 'Adicionar usuário',
                        'acfe_settings' => '',
                        'acfe_form' => true,
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5f6b5d3a2d6da',
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
                                'acfe_form' => true,
                            ),
                        ),
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
                'acfe_form' => 1,
                'acfe_meta' => '',
                'acfe_note' => '',
            ));
            
            endif;
    }


}

//Criando o objeto
$ferramentas = new ferramentas;


?>