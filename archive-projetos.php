<?php get_header(); 
$processa_projetos = new processa_projetos;
?>
<div class="row">
    <?php
    while ( $processa_projetos->projetos->have_posts() ) : $processa_projetos->projetos->the_post(); 
        $fields = '';
        $fields_frentes = '';
        $fields_integracoes = '';
        $fields_visao = '';
        $fields_time = '';
        $fields_metodo = '';

        $id_do_projeto = get_the_ID();
        $fields = get_fields();
        if($fields['status'] == 'ativo'){
        ?>
            <div class="col-12 col-md-3">
                <div class="atomic_card background_white" >
                    <div class='row mb-3'>
                        <div class='col-6'>
                        
                            <p class="escala1 mb-3 onipink bold "><?php echo $fields['projeto']; ?></p>
                            <?php
                            //Colocar aqui os dados de projeto, como os status de integração 
                            $args = array(
                                'posts_per_page' => -1,
                                'no_found_rows' => true,
                                'post_type'		=> 'integracoes',
                                'post_status'   => 'publish',
                                'meta_key'		=> 'projeto_id_wordpress',
                                'meta_value'	=> $id_do_projeto
                            );
                            $the_query_integracoes = new WP_Query( $args );
                            if ( $the_query_integracoes->have_posts() ) : while ( $the_query_integracoes->have_posts() ) : $the_query_integracoes->the_post();
                                $fields_integracoes = get_fields();
                            endwhile;endif;
                            wp_reset_postdata();
                            ?>
                            <div class="">
                                <p class="escala-2 pl-3 mt-1 mb-1 sem-label  <?php echo $fields['status'] ? "sim": "nao"; ?>">
                                    <span > Ativo </span> 
                                </p>
                                <p class="escala-2 pl-3 mt-1 mb-1 sem-label   <?php echo $fields_integracoes['projeto_id_pipefy'] ? "sim": "nao"; ?>">
                                    <span > Pipefy </span> 
                                </p>
                                <p class="escala-2 pl-3 mt-1 mb-1 sem-label   <?php echo $fields_integracoes['projeto_id_clickup'] ? "sim": "nao"; ?>">
                                    <span > Clickup </span> 
                                </p>
                            </div>
                        </div>
                        <?php
                        //Colocar aqui os guardiões de visão e time do projeto
                        $args = array(
                            'numberposts'	=> -1,
                            'post_type'		=> 'papeis',
                            'post_status'   => 'publish',
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'projeto',
                                    'value' => $id_do_projeto,
                                    'compare' => '='
                                ),
                        
                                array(
                                    'relation' => 'OR',
                                    array(
                                        'key' => 'papel',
                                        'value' => 'guardiao_time',
                                        'compare' => '='
                                    ),
                                    array(
                                        'key' => 'papel',
                                        'value' => 'guardiao_visao',
                                        'compare' => '='
                                    )
                                )
                            )
                        );
                        $the_query_papeis = new WP_Query( $args );
                        if ( $the_query_papeis->have_posts() ) : while ( $the_query_papeis->have_posts() ) : $the_query_papeis->the_post();
                            $fields = get_fields(); 
                            if($fields['papel'] == 'guardiao_visao'){
                                $fields_visao = $fields;
                            }
                            if($fields['papel'] == 'guardiao_time'){
                                $fields_time = $fields;
                            }
                        endwhile;endif;
                        wp_reset_postdata();
                        ?>
                        <div class="d-flex justify-content-around">
                            <div class='col-4'>
                                <p class='text-center escala-1 mb-1 bold'>Visão</p>
                                <div class='text-center center-block'>
                                    <img class=" image_profile_small" alt="<?php echo $fields_visao['oni']['display_name']; ?>" src="<?php echo get_avatar_url($fields_visao['oni']['ID']);?>">
                                </div>
                            </div>

                            <div class='col-4'>

                                <p class='text-center escala-1 mb-1 bold'>Time</p>
                                <div class='text-center center-block'>
                                    <img class=" image_profile_small" alt="<?php echo $fields_time['oni']['display_name']; ?>" src="<?php echo get_avatar_url($fields_time['oni']['ID']);?>">
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                   
                    <?php
                    // Fazendo o loop das frentes
                    $args = array(
                        'posts_per_page' => -1,
                        'post_type'		=> 'frentes',
                        'post_status'   => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'projeto',
                                'value' => $id_do_projeto,
                                'compare' => '='
                            )
                        )

                    );
                    $the_query_frentes = new WP_Query( $args );
                    if ( $the_query_frentes->have_posts() ) : while ( $the_query_frentes->have_posts() ) : $the_query_frentes->the_post();
                        $fields_frentes = get_fields();
                        $id_frente = get_the_ID();
                        //fazer o loop dos papeis aqui, por frente
                        ?>
                        <div class="row">
                            <div class="col-8">

                                <p class="escala0 bold petro mb-0"><?php echo $fields_frentes['nome_da_frente'];?> - <?php echo $fields_frentes['horas'];?>h</p>
                                <p class="escala-1 petro "><?php echo $fields_frentes['data_de_inicio'];?> a <?php echo $fields_frentes['data_de_fim'];?></p>
                            </div>
                            <?php
                            //Colocar aqui os guardiões de visão e time do projeto
                            $args = array(
                                'numberposts'	=> -1,
                                'post_type'		=> 'papeis',
                                'post_status'   => 'publish',
                                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'key' => 'frente',
                                        'value' => $id_frente,
                                        'compare' => '='
                                    ),
                                    array(
                                        'key' => 'papel',
                                        'value' => 'guardiao_metodo',
                                        'compare' => '='
                                    )
                                )
                            );
                            $query_papeis = new WP_Query( $args );
                            if ( $query_papeis->have_posts() ) : while ( $query_papeis->have_posts() ) : $query_papeis->the_post();
                                $fields_metodo = get_fields(); 
                            endwhile;endif;
                            wp_reset_postdata();
                            ?>
                            <div class='col-4'>
                                <p class='text-center escala-1 mb-1 bold'>Metodo</p>
                                <div class='text-center center-block'>
                                    <img class=" image_profile_small" alt="<?php echo $fields_metodo['oni']['display_name']; ?>" src="<?php echo get_avatar_url($fields_metodo['oni']['ID']);?>">
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                    <?php
                    endwhile;endif;
                    ?>
                </div>
            </div>


        <?php
        }
        ?>
    <?php
    endwhile;
    ?>
</div>
<?php
    get_footer();
?>