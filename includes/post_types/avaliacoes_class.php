<?php
/*
* Avaliações
* Cria um post type chamado avaliações para feedbacks internos da equipe

*/

class avaliacoes{

    //variaveis
    private $nome_singular = 'Avaliação';
    private $nome_plural = 'Avaliações';
    private $post_slug = 'avaliacoes';

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
                'key' => 'group_60636c952302a',
                'title' => 'Avaliações',
                'fields' => array(
                    array(
                        'key' => 'field_60636ca0e8e97',
                        'label' => 'Oni avaliado',
                        'name' => 'oni_avaliado',
                        'type' => 'user',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'role' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'array',
                        'acfe_bidirectional' => array(
                            'acfe_bidirectional_enabled' => '0',
                        ),
                    ),
                    array(
                        'key' => 'field_60636ca7e8e98',
                        'label' => 'Oni avaliador',
                        'name' => 'oni_avaliador',
                        'type' => 'user',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'role' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'array',
                        'acfe_bidirectional' => array(
                            'acfe_bidirectional_enabled' => '0',
                        ),
                    ),
                    array(
                        'key' => 'field_60647194e01c7',
                        'label' => 'O quanto você confia que o oni vai conseguir “se virar” para entregar uma missão?',
                        'name' => 'o_quanto_voce_confia_que_o_oni_vai_conseguir_“se_virar”_para_entregar_uma_missao',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c88440afd',
                        'label' => 'Quão bem o oni conhece suas limitações e sabe o que consegue e não consegue fazer?',
                        'name' => '',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c88d4f2fe',
                        'label' => 'Quão disposto o Oni é para aprender?',
                        'name' => 'quao_disposto_o_oni_e_para_aprender',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c89c4f2ff',
                        'label' => 'Quão cortês o Oni é no relacionamento com você?',
                        'name' => 'quao_cortes_o_oni_e_no_relacionamento_com_voce',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8a74f300',
                        'label' => 'Quão fácil é trabalhar em missões de em conjunto com esse Oni?',
                        'name' => 'quao_facil_e_trabalhar_em_missoes_de_em_conjunto_com_esse_oni',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8b24f301',
                        'label' => 'O quão clara é a comunicação desse oni?',
                        'name' => 'o_quao_clara_e_a_comunicacao_desse_oni',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8bc4f302',
                        'label' => 'Quão responsável é o oni com suas tarefas?',
                        'name' => 'quao_responsavel_e_o_oni_com_suas_tarefas',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8c94f303',
                        'label' => 'Quanto esmero esse oni tem com o que entrega?',
                        'name' => 'quanto_esmero_esse_oni_tem_com_o_que_entrega',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8d04f304',
                        'label' => 'O quanto esse oni põe em prática os feedbacks que recebe?',
                        'name' => 'o_quanto_esse_oni_poe_em_pratica_os_feedbacks_que_recebe',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c8da4f305',
                        'label' => 'O quanto esse oni participa verdadeiramente dos momentos de colaboração, buscando absorver ou colaborar?',
                        'name' => 'o_quanto_esse_oni_participa_verdadeiramente_dos_momentos_de_colaboracao_buscando_absorver_ou_colaborar_',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxiradio',
                            'id' => '',
                        ),
                        'choices' => array(
                            
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',
                            0 => 'Não tive contato'
                          
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => '',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_6064c90e9cb66',
                        'label' => 'Selecione todos os atributos que esse oni representa:',
                        'name' => 'quais_desses_atributos_esse_oni_representa:',
                        'type' => 'checkbox',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => 'maxicheck',
                            'id' => '',
                        ),
                        'choices' => array(
                            'Protagonista' => 'Protagonista',
                            'Holístico' => 'Holístico',
                            'Evolutivo' => 'Evolutivo',
                            'Envolvente' => 'Envolvente',
                        ),
                        'allow_custom' => 0,
                        'default_value' => array(
                        ),
                        'layout' => 'horizontal',
                        'toggle' => 0,
                        'return_format' => 'value',
                        'save_custom' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'avaliacoes',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'left',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
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
}

//Criando o objeto
$avaliacoes = new avaliacoes;


?>