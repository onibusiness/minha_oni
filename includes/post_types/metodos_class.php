<?php
/*
* Metodos
* Cria um post type chamado métodos e todas as suas configurações no ACF
*/

class metodos{

    //variaveis
    private $nome_singular = 'Método';
    private $nome_plural = 'Métodos';
    private $post_slug = 'metodo';

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
                'key' => 'group_60070f67d25bb',
                'title' => 'Método',
                'fields' => array(
                    array(
                        'key' => 'field_60070f7639aa2',
                        'label' => 'Método',
                        'name' => 'metodo',
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
                        'key' => 'field_600711aab5a3c',
                        'label' => 'Descrição',
                        'name' => 'descricao',
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
                        'key' => 'field_60070f8139aa3',
                        'label' => 'Requisitos',
                        'name' => 'requisitos',
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
                        'button_label' => '+Requisito',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_60070f8e39aa4',
                                'label' => 'Competência',
                                'name' => 'competencia',
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
                                    0 => 'competencias',
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
                                'key' => 'field_60070fa639aa5',
                                'label' => 'Nível',
                                'name' => 'nivel',
                                'type' => 'number',
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
                                'min' => '',
                                'max' => '',
                                'step' => '',
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_60070fb139aa6',
                        'label' => 'Guardiões',
                        'name' => 'guardioes',
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
                        'button_label' => '+ Guardião',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_60070fc539aa7',
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
                                'return_format' => 'array',
                                'acfe_bidirectional' => array(
                                    'acfe_bidirectional_enabled' => '0',
                                ),
                            ),
                            array(
                                'key' => 'field_60070fde39aa8',
                                'label' => 'Com rodinha',
                                'name' => 'com_rodinha',
                                'type' => 'true_false',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'acfe_permissions' => '',
                                'message' => '',
                                'default_value' => 0,
                                'ui' => 0,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                            array(
                                'key' => 'field_60070fee39aa9',
                                'label' => 'Data de início',
                                'name' => 'data_de_inicio',
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
                'acfe_form' => 0,
                'acfe_meta' => '',
                'acfe_note' => '',
            ));
            
            endif;
    }
}

//Criando o objeto
$metodos = new metodos;

?>