<?php
/*
* Fechamento mensal e pagamento
* Cria um post type chamado evidencias e todas as suas configurações no ACF
*/

class evidencias{

    //variaveis
    private $nome_singular = 'Evidencia';
    private $nome_plural = 'Evidências';
    private $post_slug = 'evidencias';

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
                'key' => 'group_5f40103504a5e',
                'title' => 'Evidências',
                'fields' => array(
                    array(
                        'key' => 'field_5f68c03c23222',
                        'label' => 'Data',
                        'name' => 'data',
                        'type' => 'date_picker',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_5f68c025cefa0',
                        'label' => 'Evidência',
                        'name' => 'evidencia',
                        'type' => 'wysiwyg',
                        'instructions' => 'Preencha a evidência respondendo:</br>
                                                                    <span class="escala-1">- O que eu fiz no processo?</span></br>
                                                                    <span class="escala-1">- Por quê foi bom tecnicamente?</span></br>
                                                                    <span class="escala-1">- Qual o impacto/influência da minha atuação na entrega?</span>',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'delay' => 0,

                    ),
                    array(
                        'key' => 'field_603eb54ee2a71',
                        'label' => 'Você quer cadastrar',
                        'name' => 'lente_ou_competencia',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'choices' => array(
                            'Competência' => 'Competência',
                            'Lente' => 'Lente',
                        ),
                        'default_value' => 'Competência',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5fa2b4ad170ee',
                        'label' => 'Projeto',
                        'name' => 'projeto',
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
                        'key' => 'field_5f40103e2126b',
                        'label' => 'Competência',
                        'name' => 'competencia',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_603eb54ee2a71',
                                    'operator' => '==',
                                    'value' => 'Competência',
                                ),
                            ),
                        ),
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
                        'key' => 'field_603eb47fc5c0a',
                        'label' => 'Lente',
                        'name' => 'Lente',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_603eb54ee2a71',
                                    'operator' => '==',
                                    'value' => 'Lente',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'acfe_permissions' => '',
                        'post_type' => array(
                            0 => 'lente',
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
                        'key' => 'field_5f68c04f23223',
                        'label' => 'Link da evidência',
                        'name' => 'link_da_evidencia',
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
                        'key' => 'field_5f8ef21e5fed6',
                        'label' => 'Parecer',
                        'name' => 'parecer',
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
                            1 => 'um_socio',
                        ),
                        'choices' => array(
                            'sem_parecer' => '-',
                            'sim' => 'Sim',
                            'nao' => 'Não',
                            'onion_up' => 'Onion up',
                        ),
                        'default_value' => false,
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5faa986c42eca',
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
                        'key' => 'field_5fb56429e862e',
                        'label' => 'Feedback do guardião de método',
                        'name' => 'feedback_guardiao_metodo',
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
                        'key' => 'field_5fce285c8903f',
                        'label' => 'Feedback do guardião da visao',
                        'name' => 'feedback_guardiao_visao',
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
                        'key' => 'field_5fce286689040',
                        'label' => 'Feedback do guardião do time',
                        'name' => 'feedback_guardiao_time',
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
                        'key' => 'field_5fb56437e862f',
                        'label' => 'Feedback dos sócios',
                        'name' => 'feedback_dos_socios',
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
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => '',
                        'acfe_textarea_code' => 0,
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
            'oni' => __ ( 'Oni' ),
            'lente_ou_competencia' => __ ( '' ),
            'competencia' => __ ( 'Competência' ),
            'parecer' => __ ( 'Parecer' )

            ) );
    }
    public function exibirColunasAdmin( $column, $post_id ) {
        switch ( $column ) {
            case 'oni':
            $oni = get_field('oni',$post_id);
            echo $oni->data->display_name;
    
            break;
            case 'lente_ou_competencia':
                $lente_ou_competencia = get_field('lente_ou_competencia',$post_id);
                echo $lente_ou_competencia;
        
            break;
            case 'competencia':
                $competencia = get_field('competencia',$post_id);
                echo $competencia->post_title;
        
            break;
            case 'parecer':
                $parecer = get_field('parecer',$post_id);
                echo $parecer;
        
            break;
        }
    }

 
 


}

//Criando o objeto
$evidencias = new evidencias;


?>