<?php
/*
* Fechamento mensal e pagamento
* Cria um post type chamado fechamento_mensal e todas as suas configurações no ACF
* Cria um post type chamado pagamento e todas as suas configurações no ACF
*/

class fechamentos_mensais{

    //variaveis
    private $nome_singular = 'Fechamento Mensal';
    private $nome_plural = 'Fechamentos Mensais';
    private $post_slug = 'fechamentos_mensais';


    //disparando a classe
    public function __construct(){

        add_action('init', array($this,'adicionar_custom_post_type')); 
        add_action('init', array($this,'adicionar_campos_ACF')); 
        add_action('init', array($this,'check_flush_rewrite_rules')); 

    }

    //Adicionando o custom post type
    public function adicionar_custom_post_type(){
        
            $labels = array(
            'name'               => ucwords($this->nome_singular),
            'nome_singular'      => ucwords($this->nome_singular),
            'menu_name'          => ucwords($this->nome_plural),
            'name_admin_bar'     => ucwords($this->nome_singular),
            'add_new'            => ucwords($this->nome_singular),
            'add_new_item'       => 'Add New ' . ucwords($this->nome_singular),
            'new_item'           => 'New ' . ucwords($this->nome_singular),
            'edit_item'          => 'Edit ' . ucwords($this->nome_singular),
            'view_item'          => 'View ' . ucwords($this->nome_plural),
            'all_items'          => 'All ' . ucwords($this->nome_plural),
            'search_items'       => 'Search ' . ucwords($this->nome_plural),
            'parent_item_colon'  => 'Parent ' . ucwords($this->nome_plural) . ':', 
            'not_found'          => 'No ' . ucwords($this->nome_plural) . ' found.', 
            'not_found_in_trash' => 'No ' . ucwords($this->nome_plural) . ' found in Trash.',
        );
        
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','editor','thumbnail'), 
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-format-status'
        );
        
        register_post_type($this->post_slug, $args);
        
    }

    //Adicionando os campos do ACF
    public function adicionar_campos_ACF(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5fa3f52b67aea',
                'title' => 'Fechamento financeiro',
                'fields' => array(
                    array(
                        'key' => 'field_5fa3f70d9482a',
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
                        'display_format' => 'm/Y',
                        'return_format' => 'm/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_5fa3f75a9482d',
                        'label' => 'Receitas',
                        'name' => 'receitas',
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
                        'min' => '',
                        'max' => '',
                        'step' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array(
                        'key' => 'field_5fa3f7679482e',
                        'label' => 'Despesas',
                        'name' => 'despesas',
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
                    array(
                        'key' => 'field_5fb52a6ad3361',
                        'label' => 'Onions de competência no sistema',
                        'name' => 'onions_competencia',
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
                    array(
                        'key' => 'field_5fb52a7dd0899',
                        'label' => 'Onions de papéis no sistema',
                        'name' => 'onions_papeis',
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
                    array(
                        'key' => 'field_5fb52a88d089a',
                        'label' => 'Onions de Férias no sistema',
                        'name' => 'onions_ferias',
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
                    array(
                        'key' => 'field_5fa3f7339482c',
                        'label' => 'Onions no sistema',
                        'name' => 'onions_no_sistema',
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
                    array(
                        'key' => 'field_5fa3f7739482f',
                        'label' => 'Folha',
                        'name' => 'budget_folha',
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
                    array(
                        'key' => 'field_5fb52aa2d089b',
                        'label' => 'Valor do Onion',
                        'name' => 'valor_do_onion',
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
                'hide_on_screen' => '',
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

    //Função pronta que dá um refresh nos permalinks
    public function check_flush_rewrite_rules(){
        $has_been_flushed = get_option($this->post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($this->post_slug . '_flush_rewrite_rules', true);
        }
    }

}

class pagamentos{

    //variaveis
    private $nome_singular = 'Pagamento';
    private $nome_plural = 'Pagamentos';
    private $post_slug = 'pagamentos';


    //disparando a classe
    public function __construct(){

        add_action('init', array($this,'adicionar_custom_post_type')); 
        add_action('init', array($this,'adicionar_campos_ACF')); 
        add_action('init', array($this,'check_flush_rewrite_rules')); 

    }

    //Adicionando o custom post type
    public function adicionar_custom_post_type(){
            $labels = array(
            'name'               => ucwords($this->nome_singular),
            'nome_singular'      => ucwords($this->nome_singular),
            'menu_name'          => ucwords($this->nome_plural),
            'name_admin_bar'     => ucwords($this->nome_singular),
            'add_new'            => ucwords($this->nome_singular),
            'add_new_item'       => 'Add New ' . ucwords($this->nome_singular),
            'new_item'           => 'New ' . ucwords($this->nome_singular),
            'edit_item'          => 'Edit ' . ucwords($this->nome_singular),
            'view_item'          => 'View ' . ucwords($this->nome_plural),
            'all_items'          => 'All ' . ucwords($this->nome_plural),
            'search_items'       => 'Search ' . ucwords($this->nome_plural),
            'parent_item_colon'  => 'Parent ' . ucwords($this->nome_plural) . ':', 
            'not_found'          => 'No ' . ucwords($this->nome_plural) . ' found.', 
            'not_found_in_trash' => 'No ' . ucwords($this->nome_plural) . ' found in Trash.',
        );
        
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','editor','thumbnail'), 
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-format-status'
        );
        
        register_post_type($this->post_slug, $args);
        
    }

    //Adicionando os campos do ACF
    public function adicionar_campos_ACF(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5dd567c6adaf9',
                'title' => 'Pagamento',
                'fields' => array(
                    array(
                        'key' => 'field_5dd568cf30a29',
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
                        'display_format' => 'm/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_5fb51c6287366',
                        'label' => 'Cargo',
                        'name' => 'cargo',
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
                        'key' => 'field_5dd56f51bcb7d',
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
                        'role' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                    ),
                    array(
                        'key' => 'field_5fb51449009fe',
                        'label' => 'Competências',
                        'name' => 'competencias',
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
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5fb51d3215644',
                                'label' => 'Competência',
                                'name' => 'competencia',
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
                                'key' => 'field_5fb5145fe7eea',
                                'label' => 'pontos',
                                'name' => 'pontos',
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
                            array(
                                'key' => 'field_5fb5146ce7eeb',
                                'label' => 'Onion up',
                                'name' => 'onion_up',
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
                        ),
                    ),
                    array(
                        'key' => 'field_5dd56804968bc',
                        'label' => 'Guardas',
                        'name' => 'guardas',
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
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5fb5148be7eec',
                                'label' => 'Papel',
                                'name' => 'papel',
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
                                'key' => 'field_5fb51495e7eed',
                                'label' => 'Projeto',
                                'name' => 'projeto',
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
                                'key' => 'field_5fb5149ae7eee',
                                'label' => 'Com rodinhas',
                                'name' => 'com_rodinhas',
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
                                'key' => 'field_5fb514a4e7eef',
                                'label' => 'Percentual',
                                'name' => 'percentual',
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
                        'key' => 'field_5dd56841968c1',
                        'label' => 'Férias com desconto padrão',
                        'name' => 'ferias_desconto_padrao',
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
                    array(
                        'key' => 'field_5fb514e8e7ef0',
                        'label' => 'Férias com desconto total',
                        'name' => 'ferias_desconto_total',
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
                    array(
                        'key' => 'field_5dd5684a968c2',
                        'label' => 'Férias nos 3 meses anteriores',
                        'name' => 'ferias_tres_meses',
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
                    array(
                        'key' => 'field_5fb51505e7ef1',
                        'label' => 'Advertências',
                        'name' => 'advertencias',
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
                    array(
                        'key' => 'field_5deabdd459b29',
                        'label' => 'Advertências',
                        'name' => 'explicacoes_advertencias',
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
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5deabe94dabf8',
                                'label' => 'Explicação advertencia',
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
                                'acfe_permissions' => '',
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                            array(
                                'key' => 'field_5fb5152de7ef2',
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
                        ),
                    ),
                    array(
                        'key' => 'field_5dd56827968bf',
                        'label' => 'Onions de competências',
                        'name' => 'onions_competencia',
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
                    array(
                        'key' => 'field_5dd56815968be',
                        'label' => 'Onions de papéis',
                        'name' => 'onions_papeis',
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
                    array(
                        'key' => 'field_5fb51568e7ef3',
                        'label' => 'Onions de Férias',
                        'name' => 'onions_ferias',
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
                    array(
                        'key' => 'field_5fc107ce7770e',
                        'label' => 'Onions de lentes',
                        'name' => 'onions_lentes',
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
                    array(
                        'key' => 'field_5dd56832968c0',
                        'label' => 'Total de Onions',
                        'name' => 'onions',
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
                    array(
                        'key' => 'field_5dd56883968c6',
                        'label' => 'Valor reembolsos',
                        'name' => 'reembolsos',
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
                    array(
                        'key' => 'field_5dd56890968c7',
                        'label' => 'Reembolsos',
                        'name' => 'descricao_reembolsos',
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
                        'key' => 'field_5dd5689a968c8',
                        'label' => 'Remuneração',
                        'name' => 'remuneracao',
                        'type' => 'number',
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
                        'min' => '',
                        'max' => '',
                        'step' => '',
                    ),
                    array(
                        'key' => 'field_5fc107e87770f',
                        'label' => 'Lentes',
                        'name' => 'lentes',
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
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5fc107f177710',
                                'label' => 'Lente',
                                'name' => 'lente',
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

    //Função pronta que dá um refresh nos permalinks
    public function check_flush_rewrite_rules(){
        $has_been_flushed = get_option($this->post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($this->post_slug . '_flush_rewrite_rules', true);
        }
    }

}

//Criando o objeto
$fechamentos_mensais = new fechamentos_mensais;
//Criando o objeto
$pagamentos = new pagamentos;


?>