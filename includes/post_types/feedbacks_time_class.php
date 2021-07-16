<?php


class feedback_time{

    //variaveis
    private $nome_singular = 'Feedback time';
    private $nome_plural = 'Feedbacks time';
    private $post_slug = 'feedback_time';



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
                'key' => 'group_604a1d1a0d764',
                'title' => 'Feedback gestores',
                'fields' => array(
                    array(
                        'key' => 'field_604a1d819945e',
                        'label' => 'Frente',
                        'name' => 'frente',
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
                    array(
                        'key' => 'field_604a1da47a05f',
                        'label' => 'Projeto',
                        'name' => 'Projeto',
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
                        'key' => 'field_604a246ac97ab',
                        'label' => 'De 1 a 5, quanto a inteligência de projeto e informações passadas foram suficientes para sua atuação?',
                        'name' => 'de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao',
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
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_604a24fd6ac1c',
                        'label' => 'De 1 a 5, quanto você se sentiu amparada e acompanhada no processo de desenvolvimento?',
                        'name' => 'de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento',
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
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_604a25046ac1d',
                        'label' => 'De 1 a 5, quanto o tempo disponível para o desenvolvimento foi adequado?',
                        'name' => 'de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado',
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
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_604a25166ac1e',
                        'label' => 'Qual foi o destaque positivo deste processo?',
                        'name' => 'qual_foi_o_destaque_positivo_deste_processo',
                        'type' => 'textarea',
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
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => '',
                        'acfe_textarea_code' => 0,
                    ),
                    array(
                        'key' => 'field_604a251f6ac1f',
                        'label' => 'O que poderia mudar nos próximos ciclos?',
                        'name' => 'o_que_poderia_mudar_nos_proximos_ciclos',
                        'type' => 'textarea',
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
                'acfe_form' => 0,
                'acfe_meta' => '',
                'acfe_note' => '',
            ));
            
            endif;
    }
    //Mostrando os campos como colunas na lista do admin
    public function criarColunasAdmin($columns){
        return array_merge ( $columns, array ( 
            'Projeto' => __ ( 'Projeto' ),
            'frente' => __ ( 'Frente' ),
            'de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao' => __ ( 'Inteligência ajudou?' ),
            'de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento' => __ ( 'Se sentiu amparada?' ),
            'de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado' => __ ( 'Tempo adequado?' )

            ) );
    }
    public function exibirColunasAdmin( $column, $post_id ) {
        switch ( $column ) {
            case 'Projeto':
            $projeto = get_field('Projeto',$post_id);
            echo $projeto->post_title;
    
            break;
            case 'frente':
                $frente = get_field('frente',$post_id);
                echo $frente;
        
            break;
            case 'de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao':
                $de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao = get_field('de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao',$post_id);
                echo $de_1_a_5_quanto_a_inteligencia_de_projeto_e_informacoes_passadas_foram_suficientes_para_sua_atuacao;
        
            break;
            case 'de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento':
                $de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento = get_field('de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento',$post_id);
                echo $de_1_a_5_quanto_voce_se_sentiu_amparada_e_acompanhada_no_processo_de_desenvolvimento;
        
            break;
            case 'de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado':
                $de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado = get_field('de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado',$post_id);
                echo $de_1_a_5_quanto_o_tempo_disponivel_para_o_desenvolvimento_foi_adequado;
        
            break;
        }
    }
    
}

//Criando o objeto
$feedback_time = new feedback_time;
?>