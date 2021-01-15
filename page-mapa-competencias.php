<?php get_header();?>
<?php 
    $competencias = new processa_competencias;
?> 
<div class="row">
    <div class="atomic_card background_white col-12 col-md-8 offset-md-2 p-md-5">
        <div class='row'>
            <p class=' col-12 escala2 onipink'>Lentes</p>
            <div class='col-12 col-md-8'>            
                <p class="escala-1 grey">
                Mindsets consolidados do Oni. Se manifestam em comportamentos, falas e abordagens de missões e projetos.
                Pontos independentes, não precisa de um para ganhar o outro.
                </p>
                <p class="bold escala-1 grey">
                Processo de avaliação 
                </p>
                <p class="escala-1 grey">
                Evidências + feedback de fechamento de frente
                + debrief no café + análise de abordagem pelos sócio.
                </p>
                <p class="bold escala-1 grey">
                Duração
                </p>
                <p class="escala-1 grey">
                São perenes, porém difíceis de ser conquistados, pois são interpretados como um modo de operação padrão do Oni.
                </p>
            </div>
            <div class='col-12 col-md-4'>
                <p class="bold escala-1 grey">
                Pontuação
                </p>
                <p class="escala1 onipink">
                <span class="bold">2 Ønions</span> por ponto
                </p>

            </div>
        </div>
        <div class='row'>
            <?php 
            foreach($competencias->lentes as $prisma => $lente){
                ?>
                <div class="col-12 col-md-6 px-0"  >
                    <div class="col-12" >
                        <p class="escala0 bold petro under_lightgrey mt-3"><?php echo $prisma; ?></p>
                    </div>
                    <?php
                    
                    while ( $lente->have_posts() ) : $lente->the_post(); 
                    ?>
                        <p class=" col-12 escala-1 petro"><?php echo get_the_title(); ?></p>
                    <?php
                    endwhile;
                    ?>
                </div>
            <?php 
            }
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="atomic_card background_white col-12 col-md-8 offset-md-2 p-md-5">
        <div class='row'>
            <p class=' col-12 escala2 onipink'>Competências</p>
            <div class='col-12 col-md-8'>            
                <p class="escala-1 grey">
                Capacidades técnicas de execução.
                Se manifestam no resultado da sua atuação e entregas relacionadas às competências de execução.
                </p>
                <p class="bold escala-1 grey">
                Processo de avaliação 
                </p>
                <p class="escala-1 grey">
                Evidencial, com base no que foi feito. Avaliação contextual dos gestores com colaboração dos sócios no fechamento mensal.
                </p>
                <p class="bold escala-1 grey">
                Duração
                </p>
                <p class="escala-1 grey">
                Enquanto a Oni puder contar com aquela competência daquele oni. Em caso de desistência ou indisponibilidade para a execução daquela competência o ponto é retirado.

                </p>
            </div>
            <div class='col-12 col-md-4'>
                <p class="bold escala-1 grey">
                Pontuação
                </p>
                <p class="escala1 petro">
                1 = <span class="bold onipink">1 Ønion</span>
                </p>
                <p class="escala1 petro">
                2 = <span class="bold onipink">2 Ønions</span>
                </p>
                <p class="escala1 petro">
                3 = <span class="bold onipink">4 Ønions</span>
                </p>
                <p class="escala1 petro">
                4 = <span class="bold onipink">6 Ønions</span>
                </p>
                <p class="escala1 petro">
                5 = <span class="bold onipink">8 Ønions</span>
                </p>
            </div>
        </div>
        <div class='row'>
            <div class='col-12 col-md-4'>
                <p class="bold escala-1 grey">
                Framework de progressão
                </p>    
            </div>
            <table class='col-11 table'>
                <thead class='petro escala-1'>
                    <tr><th></th><th>Competências</th><th>Nível de conhecimento</th><th>Nível de experiência</th><th>O que o Oni tem que fazer</th></tr></thead>
                <tbody class='grey escala-2'>
                    <tr><td>#1</td><td>Capaz de contribuir de forma produtiva no processo</td><td>Entende os conceitos principais da competência, sabe de forma macro quais são os principais passos de abordagem daquela competência.</td><td>Experiência teórica, de referências.</td><td>contribuir de forma ativa e construtiva em processos de abertura.</td></tr>
                    <tr><td>#2</td><td>Capaz de tocar processos, mas depende de alguém para finalizar</td><td>Entende a estrutura metodológica da competência. Conhece um processo de implementação da competência, conhecendo a cadeia do que vem depois do que, das macro às micro etapas.</td><td>Experiência prática com a competência enquanto participante. É familiarizado com cases externos e impactos</td><td>desenvolvimento de processos de fechamento em colaboração ou não, dependendo apenas de refinamento e revisão mais competente.</td></tr>
                    <tr><td>#3</td><td>Capaz de dar saída na entrega, ou seja, atuar com a abordagem finalizadora</td><td>Domina a metodologia (e abordagem técnica de ponta a ponta) daquela competência, conhece mais de uma abordagem metodológica para implementar a competência. Consegue ver os pontos falhos ao seguir o processo</td><td>Já atuou em mais de um contexto, com abordagens diferentes. Consegue entender as consequencias práticas das abordagens.</td><td>Segurança de que a entrega vai sair de acordo com os requisitos do cliente dentro daquela competência.</td></tr>
                    <tr><td>#4</td><td>Capaz de construir novas estruturas de abordagem ou novos modelos mentais que gerem resultados de qualidade mais alta ou com menos recurso.</td><td>Tem domínio total de diversas abordagens metodológicas, consegue aplicar técnicas que o permite gerar mais qualidade técnica no tempo definido.</td><td>Já estressou a atuação dentro da competência, tanto em termos referenciais, conceituais e/ou prático. Já fez aquilo vezes o suficiente para saber os atalhos.</td><td>Entregas "acima da média" dentro do mesmo tempo. Sua atuação "faz case"</td></tr>
                    <tr><td>#5</td><td>Capaz de atuar no mesmo nível de empresas especialistas no segmento.</td><td>Conhecimento de especialista, conhece as abordagens consolidadas, está a par das novas abordagem e tem um aproach próprio com resultados diferenciados.</td><td>É um cientista naquilo, já conhece as teorias, fez vários experimentos e formula seus próprios teoremas.</td><td>Entregas com qualidade técnica proprietária, que "chamam a atenção" para a Oni. Geram demanda de mercado pra gente diretamente.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="atomic_card background_white col-12 col-md-8 offset-md-2 p-md-5">
        <div class='row'>
            <p class=' col-12 escala2 onipink'>Lista de competências</p>
        </div>
        <div class='row'>
            <div class="duas-colunas">
                <?php 
                $competencias_do_oni = $historico_pagamentos[$mes['classe']]['competencias'];

                foreach($competencias->competencias as $esfera => $competencias){
                    ?>
                    <!-- Escrevendo a esfera  -->
                    <div class="col-12 px-0" style="break-inside: avoid;" >
                        <p class="col-12  escala0 bold onipink under_lightgrey mt-3"><?php echo $esfera; ?></p>
                
                
                            <?php
                            $competencias = $competencias->posts;
                            
                            foreach($competencias as $competencia){
                                ?>

                            <p class=" col-12 escala-1 petro mb-2"><?php echo get_the_title($competencia->ID);  ?></p>
                            <p class=" col-12 escala-1 grey pl-4"><?php echo the_field('explicacao',$competencia->ID ); ?></p>
                            <?php
                            }
                            ?>

                        
                    </div>
                    <?php
                }

                ?>
            </div>
        </div>

    </div>
</div>

<?php get_footer();?>