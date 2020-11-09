<?php
/*
* Ferramentas e equipamentos
* Cria um post type chamado ferramentas e todas as suas configurações no ACF
* Cria um post type chamado equipamentos e todas as suas configurações no ACF
*/

class ferramentas{

    //variaveis
    private $nome_singular = 'Ferramenta';
    private $nome_plural = 'Ferramentas';
    private $post_slug = 'ferramentas';


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

class equipamentos{

    //variaveis
    private $nome_singular = 'Equipamento';
    private $nome_plural = 'Equipamentos';
    private $post_slug = 'equipamentos';


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
                'key' => 'group_5f6b5fa0d6cae',
                'title' => 'Equipamentos',
                'fields' => array(
                    array(
                        'key' => 'field_5f6b5fc1ec8cd',
                        'label' => 'Especificações',
                        'name' => 'especificacoes',
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
                        'acfe_settings' => '',
                        'acfe_validate' => '',
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5fd1ec8ce',
                        'label' => 'Data de aquisição',
                        'name' => 'data_de_aquisicao',
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
                        'key' => 'field_5f6b5fdfec8cf',
                        'label' => 'Valor da aquisição',
                        'name' => 'valor_da_aquisicao',
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
                        'prepend' => 'R$',
                        'append' => '',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b5ffeec8d0',
                        'label' => 'Taxa de depreciação (por ano)',
                        'name' => 'taxa_de_depreciacao',
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
                        'append' => '%',
                        'min' => '',
                        'max' => '',
                        'step' => '',
                        'acfe_form' => true,
                    ),
                    array(
                        'key' => 'field_5f6b604bec8d1',
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
                                'key' => 'field_5f6b6074ec8d2',
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
$tutoriais = new tutoriais;
//Criando o objeto
$ferramentas = new ferramentas;


?>