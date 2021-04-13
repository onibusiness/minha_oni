<?php
/*
* Férias
* Cria um post type chamado Férias e todas as suas configurações no ACF
*/

class ferias{

    //variaveis
    private $nome_singular = 'Férias';
    private $nome_plural = 'Férias';
    private $post_slug = 'ferias';


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
                'key' => 'group_5f6a03cf131cc',
                'title' => 'Férias',
                'fields' => array(
                    array(
                        'key' => 'field_5f6a03d945875',
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
                        'key' => 'field_5f6a03ec95af5',
                        'label' => 'Primeiro dia fora',
                        'name' => 'primeiro_dia_fora',
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
                        'key' => 'field_5f6a040495af6',
                        'label' => 'Último dia fora',
                        'name' => 'ultimo_dia_fora',
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
                        'key' => 'field_5f6a041eb48d9',
                        'label' => 'Tipo de desconto',
                        'name' => 'tipo_de_desconto',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => array(
                            0 => 'administrator',
                            0 => 'um_socio',
                        ),
                        'choices' => array(
                            'Padrão' => 'Padrão',
                            'Desconto Total' => 'Desconto Total',
                            'Sem desconto' => 'Sem desconto',
                        ),
                        'default_value' => 'Padrão',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
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
$ferias = new ferias;
?>