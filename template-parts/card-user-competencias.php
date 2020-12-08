<div class="atomic_card background_white py-4"> 
    <div class="d-flex flex-wrap ">
        <?php 
        $competencias = new processa_competencias;
        foreach($competencias->competencias_no_sistema as $esfera => $competencias_no_sistema){
            ?>
            <!-- Escrevendo a esfera  -->
            <div class="col-12">
                <p class="escala0 bold onipink under_lightgrey mt-3"><?php echo $esfera; ?></p>
                <div class="d-flex">
                    <?php
    
                    //Fazendo o loop nas competencias do sistema e apontando para a competencia do oni para pegar o nível
                    if(!empty($competencias_no_sistema)){
                        foreach($competencias_no_sistema as $competencia => $niveis){
                            ?>
                            <!-- Escrevendo a competencia  -->
                            <div class="col-6 col-md-8 pl-0">
                                <p class="escala-1"><?php echo $competencia; ?></p>
                            </div>
                            <div class="col-md-5 d-flex justify-content-around align-self-center">
                                <?php
                                $nivel_do_oni = 0;
                                foreach($niveis as $nivel => $onis_no_nivel){
                                    
                                    if(array_search($oni_nicename, $onis_no_nivel) !== false){
                                        $nivel_do_oni = $nivel;
                                    }
                                }
                                for ($i=0; $i < 5; $i++) { 
                                    if($nivel_do_oni > $i){
                                        ?>
                                        <p class="competency_sphere background_green"></p>
                                        <?php
                                    }else{
                                        ?>
                                        <p class="competency_sphere background_grey"></p>
                                        <?php
                                    }
                                }  
                                ?>
                                <!-- Escrevendo o nível  -->
                            </div>
                            <?php     
                        }   
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    
        ?>
    </div>
</div>