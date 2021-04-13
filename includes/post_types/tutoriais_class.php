<?php
/*
* Tutoriais
* Cria um post type chamado tutoriais e todas as suas configurações no ACF
*/

class tutoriais{

    //variaveis
    private $nome_singular = 'Tutorial';
    private $nome_plural = 'Tutoriais';
    private $post_slug = 'tutoriais';


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
                'key' => 'group_5f4656ee7cb42',
                'title' => 'Tutoriais',
                'fields' => array(
                    array(
                        'key' => 'field_5f465763e3d6e',
                        'label' => 'Conteúdo',
                        'name' => 'conteudo',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5f465774e3d6f',
                                'label' => 'Explicação',
                                'name' => 'explicacao',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'full',
                                'media_upload' => 1,
                                'delay' => 0,
                            ),
                            array(
                                'key' => 'field_5f46578ae3d70',
                                'label' => 'Artigo',
                                'name' => 'artigo',
                                'type' => 'post_object',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'post_type' => array(
                                    0 => 'post',
                                ),
                                'taxonomy' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'return_format' => 'object',
                                'ui' => 1,
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
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => array(
                    0 => 'the_content',
                ),
                'active' => true,
                'description' => '',
            ));
            
        endif;
    }

}

//Criando o objeto
$tutoriais = new tutoriais;
?>