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
    public function filtraFerias($current_user){       
        $meta_query[] = 
        array(
        ); 
 
        $meta_query[] =
        array(
            'key' => 'oni',
            'value' => $current_user->ID,
            'compare' => '=='
        );
     

        $args = array(  
            'post_type' => 'ferias' ,
            'post_status' => array('publish','draft','pending'),
            'posts_per_page' => -1,
            'meta_query' => $meta_query
        );
        $ferias_filtradas = new WP_Query( $args ); 
        return $ferias_filtradas;
    }

    /**
    * Busca e organiza as férias
    *
    * @return Array $ferias_da_oni com os posts  
    * ['atuais']   
    *   ['ID_oni']
    *   ['nome_oni']
    *   ['data_de_inicio_ferias']
    *   ['data_de_termino_ferias']
    *   ['dias_de_ferias]
    * ['proximas']   
    *   ['ID_oni']
    *   ['nome_oni']
    *   ['data_de_inicio_ferias']
    *   ['data_de_termino_ferias']
    *   ['dias_de_ferias]
    */
    public function feriasDaOni($hoje){       
        $args = array(  
            'post_type' => 'ferias' ,
            'post_status' => array('publish'),
            'posts_per_page' => -1
        );
        $ferias = new WP_Query( $args ); 
        while ( $ferias->have_posts() ) : $ferias->the_post(); 
            $campos = get_fields();
            $data_de_inicio_ferias = str_replace('/', '-', $campos['primeiro_dia_fora']);
            $data_de_termino_ferias = str_replace('/', '-', $campos['ultimo_dia_fora']);
            $dias_de_ferias = minha_oni::contaDiasUteis(strtotime($data_de_inicio_ferias), strtotime($data_de_termino_ferias));
            if(strtotime($data_de_inicio_ferias) <= $hoje && strtotime($data_de_termino_ferias) >= $hoje  ){
                $ferias_da_oni['atuais'][] = array(
                    'ID_oni' => $campos['oni']->ID,
                    'nome_oni' => $campos['oni']->user_nicename,
                    'data_de_inicio_ferias' => $data_de_inicio_ferias,
                    'data_de_termino_ferias' => $data_de_termino_ferias,
                    'dias_de_ferias' => $dias_de_ferias
                );

            }
            if(strtotime($data_de_inicio_ferias) > $hoje ){
                $ferias_da_oni['proximas'][] = array(
                    'ID_oni' => $campos['oni']->ID,
                    'nome_oni' => $campos['oni']->user_nicename,
                    'data_de_inicio_ferias' => $data_de_inicio_ferias,
                    'data_de_termino_ferias' => $data_de_termino_ferias,
                    'dias_de_ferias' => $dias_de_ferias
                );
            }
        endwhile;
        return $ferias_da_oni;
    }

}

//Criando o objeto
$ferias = new ferias;
?>