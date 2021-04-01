<?php
/*
* Papeis
* Cria um post type chamado papeis e todas as suas configurações no ACF
* Cria um post type chamado métodos e todas as suas configurações no ACF
* Função de papéis filtrados por oni
*/

class papeis{

    //variaveis
    private $nome_singular = 'Papel';
    private $nome_plural = 'Papéis';
    private $post_slug = 'papeis';


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
            'show_in_rest' => true,
            'menu_icon'         => 'dashicons-format-status'
        );
        
        register_post_type($this->post_slug, $args);
        
    }

    //Adicionando os campos do ACF
    public function adicionar_campos_ACF(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5fa2b389640cf',
                'title' => 'Papéis',
                'fields' => array(
                    array(
                        'key' => 'field_5fa2b397170ec',
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
                        'return_format' => 'array',
                  
                    ),
                    array(
                        'key' => 'field_5fa2b439170ed',
                        'label' => 'Papel',
                        'name' => 'papel',
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
                            'guardiao_visao' => 'Guardião da visão',
                            'guardiao_time' => 'Guardião do time',
                            'guardiao_metodo' => 'Guardião de método',
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
                        'key' => 'field_5fa2bc5a48922',
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
                        'key' => 'field_5fa2b9bd6bcd7',
                        'label' => 'Competência',
                        'name' => 'competencia',
                        'type' => 'relationship',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5fa2b439170ed',
                                    'operator' => '==',
                                    'value' => 'guardiao_metodo',
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
                        'filters' => array(
                            0 => 'search',
                            1 => 'post_type',
                            2 => 'taxonomy',
                        ),
                        'elements' => '',
                        'min' => '',
                        'max' => '',
                        'return_format' => 'object',
                        'acfe_bidirectional' => array(
                            'acfe_bidirectional_enabled' => '0',
                        ),
                    ),
                    array(
                        'key' => 'field_5fa2b4b2170ef',
                        'label' => 'Frente',
                        'name' => 'frente',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5fa2b439170ed',
                                    'operator' => '==',
                                    'value' => 'guardiao_metodo',
                                ),
                            ),
                        ),
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
                        'key' => 'field_5fa2b4c6170f0',
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
                    array(
                        'key' => 'field_5fa2b4e5170f1',
                        'label' => 'Data de términio',
                        'name' => 'data_de_terminio',
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

    //Função pronta que dá um refresh nos permalinks
    public function check_flush_rewrite_rules(){
        $has_been_flushed = get_option($this->post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($this->post_slug . '_flush_rewrite_rules', true);
        }
    }

    /**
    * Busca os posts de acordo com o usuário
    *
    * @return Query com os posts  
    */
    public function filtraPapeis($current_user){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $current_user,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'papeis' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query,
            'meta_key' => 'data_de_inicio',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );
        $papeis_filtrados = new WP_Query( $args ); 

        
        return $papeis_filtrados;
    }

     /**
    * Busca os posts de acordo com o projeto
    *
    * @return Query com os posts  
    */
    public function pegaPapeisProjeto($projeto){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'projeto',
            'value' => $projeto->ID,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'papeis' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $papeis_filtrados = new WP_Query( $args ); 

        
        return $papeis_filtrados;
    }
    
    /**
    * Cadastra o método vindo o pipefy
    *
    * @param Array com as frentes
    *     
    */
    public function cadastraPapelMetodo($frentes){

   
        foreach($frentes as $frente){
            $nome_da_frente = $frente['data']['table_record']['record_fields'][4]['value'];
            $data_de_inicio = $frente['data']['table_record']['record_fields'][1]['value'];
            $data_de_fim = $frente['data']['table_record']['record_fields'][0]['value'];
            $guardiao_metodo = $frente['data']['table_record']['record_fields'][2]['value'];
            if($guardiao_metodo){
                $user_query = new WP_User_Query( array( 'search' => $guardiao_metodo ) );
                $authors = $user_query->get_results();
                foreach ($authors as $author)
                {   
                    $obj_guardiao_metodo = $author;
                }
                
            }
 
            $nome_projeto = $frente['data']['table_record']['record_fields'][5]['value'];
            $id_projeto = $frente['data']['table_record']['record_fields'][5]['array_value'][0];
             // Puxando o id projeto no wordpress 
             $args = array(
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'post_type'		=> 'integracoes',
                'post_status'   => 'publish',
                'meta_key'		=> 'projeto_id_pipefy',
                'meta_value'	=> $id_projeto
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $id_projeto_wordpress = get_field('projeto_id_wordpress');
           endwhile;endif; 
           set_transient("id_projeto",$id_projeto_wordpress);
           wp_reset_query();

            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'papeis',
                'post_status'   => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'oni',
                        'value' => $obj_guardiao_metodo->ID,
                        'compare' => '='
                    ),
            
                    array(
                        'key' => 'projeto',
                        'value' => $id_projeto_wordpress->ID,
                        'compare' => '='
                    )
                )
            );
            $the_query = new WP_Query( $args );
            
   
            if ($the_query->have_posts() ) :
            else:
                $my_post = array(
                    'post_title' => substr($nome_projeto,2,-2).' - Método '.$nome_da_frente.' - '.$obj_guardiao_metodo->user_nicename,
                    'post_status' => 'publish',
                    'post_type' => 'papeis',
                );
                
                $post_id = wp_insert_post($my_post);
                //BUG - PQ ESSE CAMPO NÃO SALVA O ONI AO RECEBER O ID? o.O
              
                update_post_meta( $post_id, 'oni', $obj_guardiao_metodo->ID );
                update_field('frente', $nome_da_frente, $post_id);
                update_field('data_de_inicio', $data_de_inicio, $post_id);
                update_field('data_de_terminio', $data_de_fim, $post_id);        
                update_field('papel', 'guardiao_metodo', $post_id);
                update_field('projeto', $id_projeto_wordpress, $post_id);
                wp_reset_postdata();
            endif;
        }
           
    }
}

//Criando o objeto
$papeis = new papeis;


class metodos{

    //variaveis
    private $nome_singular = 'Método';
    private $nome_plural = 'Métodos';
    private $post_slug = 'metodo';


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

    //Função pronta que dá um refresh nos permalinks
    public function check_flush_rewrite_rules(){
        $has_been_flushed = get_option($this->post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($this->post_slug . '_flush_rewrite_rules', true);
        }
    }

       /**
    * Busca todos os gestores de metodos
    *
    * @return Query com os posts  
    */
    public function pegaMetodos(){       


        $args = array(  
            'post_type' => 'metodo' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1,
        );
        $metodos = new WP_Query( $args ); 

        
        return $metodos;
    }

}

//Criando o objeto
$metodos = new metodos;

?>