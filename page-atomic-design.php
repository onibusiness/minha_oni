<?php

get_header(); ?>


<section class="container background_white">
    <div class="escala4">Atomic Elements</div>
    <div class="row ">
        <div class="col-md-6 p-5"> 
            <div class="escala4">
                    Título
            </div>
            <div class="escala1">
                <code data-lang="html"> 
                    <pre>&lt;div class="escala4"&gt;Título&lt;/div&gt;</pre>
                </code>
            </div>
            <div class="escala2">
                Subtítulo
            </div>
            <div class="escala1 ">
                <code data-lang="html"> 
                    <pre>&lt;div class="escala2"&gt;Subtítulo&lt;/div&gt;</pre>
                </code>
            </div>

            <div class="escala1">
                Texto
            </div>
            <div class="escala1">
                <code data-lang="html"> 
                    <pre>&lt;div class="escala1"&gt;Texto&lt;/div&gt;</pre>
                </code>
            </div>
        </div>
        <div class="col-md-6 p-5">
            <div class="mb-3" >
                <img class="image_profile" src="https://files.monday.com/photos/15813062/thumb/15813062-Diego_Fernandes_photo_2020_08_31_20_26_10.png?1598905570"/>
                <img class="image_profile" src="https://files.monday.com/photos/4499078/thumb/4499078-Marcus_photo_2018_07_30_21_21_58.png?1532985718"/>
            </div>
            <div class="escala1">
                <code data-lang="html"> 
                    <pre>&lt;img class="image_profile" src="..."&gt;</pre>
                </code>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-outline-dark">Editar Perfil</button>
            </div>
            <div class="escala1">
                <code data-lang="html"> 
                    <pre>&lt;button type="button" class="btn btn-outline-dark"&gt;Editar Perfil&lt;/button&gt;</pre>
                </code>
            </div>
        </div>
        
    </div>
    <div class="row background_white"  >

        <div class="col-md-6 pl-5 pr-5">
            <div class="d-flex ">
                <p class="competency_sphere background_grey mr-2" />
                <p class="competency_sphere background_green" />
            </div>
            <div class="escala1">
                <code data-lang="html"> 
                    <pre>&lt;p class="competency_sphere background_grey" /&gt;</pre>
                </code>
                <code data-lang="html"> 
                    <pre>&lt;p class="competency_sphere background_green" /&gt;</pre>
                </code>
            </div>
            
        </div>
        

    </div>

    
</section>

<section class="container background_white p-5"> 
    <div class="escala4">Molecule Elements</div>

    <!-- Card de perfil -->

    <div class="row align-items-center">
        <div class="col-md-5 ">
            <div class="d-flex flex-row atomic_card background_white ">

                <div class="col-3 col-md-3 align-self-center p-0">
                    <img class="image_profile" src="https://files.monday.com/photos/15813062/thumb/15813062-Diego_Fernandes_photo_2020_08_31_20_26_10.png?1598905570">
                </div>
                <div class="col-9 col-md-9 p-0" >
                    <div class="escala3">Fulano Ciclano</div>
                    <div class="d-flex flex-row justify-content-between flex-wrap">
                        <div class="escala1">Estagiário</div>
                        <div>
                            <button type="button" class="btn btn-outline-dark">Editar Perfil</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-7">
            <code>
                <pre class="p-3">
&lt;div class="col-md-5 "&gt;
    &lt;div class="d-flex flex-row card_profile background_white" &gt;
        &lt;div class="col-3 col-md-3 align-self-center p-0"&gt;
            &lt;img class="image_profile" src="..."&gt;
        &lt;/div&gt;
        &lt;div class="col-9 col-md-9 p-0" &gt;
            &lt;div class="escala3"&gt;Fulano Ciclano&lt;/div&gt;
            &lt;div class="d-flex flex-row justify-content-between"&gt;
                &lt;div class="escala1"&gt;Estagiário&lt;/div&gt;
                &lt;div&gt;
                    &lt;button type="button" class="btn btn-outline-dark"&gt;Editar Perfil&lt;/button&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
            </code>
    
        </div>
    </div>


    <!-- Card de Busca -->

    <div class="row align-items-center">    
        
        <div class="col-12 col-md-5">
            <code>
                <pre class="p-3">
&lt;div class="col-12 col-md-7 "&gt;
    &lt;div class="atomic_card p-4"&gt;
        &lt;div class="row"&gt;
            &lt;div class="col-1 col-md-2"&gt;&lt;/div&gt;
            &lt;div class="col-10 col-md-8"&gt;
                &lt;p class="escala3 text-center"&gt; O que você quer saber? &lt;/p&gt;
                &lt;input class="form-control" placeholder="Procurar por ..." type="text"&gt;
            &lt;/div&gt;
            &lt;div class="col-1 col-md-2"&gt;&lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
            </code>
        </div>

        <div class="col-12 col-md-7">
            <div class="atomic_card p-4">

                <div class="row">
                    <div></div>
                    <div class="col-1 col-md-2"></div>
                    <div class="col-10 col-md-8">
                        <p class="escala3 text-center"> O que você quer saber? </p>
                        <input class="form-control" placeholder="Procurar por ..." type="text">
                    </div>
                    <div class="col-1 col-md-2"></div>
                </div>
            </div>
                
        </div> 

    </div>


    <!-- Card Forms -->


    <div class="row">

        <div class="col-12 col-md-5">
            <code>
                <pre class='p-3'>
&lt;div class="col-12 col-md-7"&gt;
    &lt;div&gt;
        &lt;div class="d-flex justify-content-between"&gt;
            &lt;div class='d-flex'&gt;
                &lt;a class="mr-2 align-self-center"&gt;&lt;i class="material-icons"&gt;stars&lt;/i&gt;&lt;/a&gt;    
                &lt;a data-toggle="collapse" id="evidencia" href="#CadastrarEvidencia" role="button"
                    aria-expanded="false" aria-controls="multiCollapseExample1"&gt;Cadastrar Evidência&lt;/a&gt;
            &lt;/div&gt;
            &lt;div class='d-flex ' id="ferias"&gt;
                &lt;a class="mr-2 align-self-center"&gt;&lt;i class="material-icons"&gt;beach_access&lt;/i&gt;&lt;/a&gt;    
                &lt;a data-toggle="collapse"  href="#MarcarFerias" role="button" aria-expanded="true" 
                    aria-controls="multiCollapseExample1"&gt;Marcar férias&lt;/a&gt;
            &lt;/div&gt;
            &lt;div class='d-flex'&gt;
                &lt;a class="mr-2 align-self-center"&gt;&lt;i class="material-icons"&gt;feedback&lt;/i&gt;&lt;/a&gt;    
                &lt;a data-toggle="collapse" id="feedback" href="#DarFeedback" role="button" 
                    aria-expanded="true" aria-controls="multiCollapseExample1"&gt;Dar feedback&lt;/a&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        
        &lt;div class="collapse multi-collapse" id="CadastrarEvidencia"&gt;
            &lt;div class="atomic_card"&gt;
                Estou Cadastrando uma evidência
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="collapse multi-collapse" id="MarcarFerias"&gt;
            &lt;div class="atomic_card"&gt;
                Estou marcando férias
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;div class="collapse multi-collapse" id="DarFeedback"&gt;
            &lt;div class="atomic_card"&gt;
                Estou Dando feedbacks
            &lt;/div&gt;
        &lt;/div&gt;   
    &lt;/div&gt;
&lt;/div&gt;</pre>
            </code>
        </div>

        <div class="col-12 col-md-7">
            <div>
                <div class="d-flex justify-content-between">
                    <div class='d-flex'>
                        <a class="mr-2 align-self-center"><i class="material-icons">stars</i></a>    
                        <a data-toggle="collapse" id="evidencia" href="#CadastrarEvidencia" role="button"
                            aria-expanded="false" aria-controls="multiCollapseExample1">Cadastrar Evidência</a>
                    </div>
                    <div class='d-flex ' id="ferias">
                        <a class="mr-2 align-self-center"><i class="material-icons">beach_access</i></a>    
                        <a data-toggle="collapse"  href="#MarcarFerias" role="button" aria-expanded="true" 
                            aria-controls="multiCollapseExample1">Marcar férias</a>
                    </div>
                    <div class='d-flex'>
                        <a class="mr-2 align-self-center"><i class="material-icons">feedback</i></a>    
                        <a data-toggle="collapse" id="feedback" href="#DarFeedback" role="button" 
                            aria-expanded="true" aria-controls="multiCollapseExample1">Dar feedback</a>
                    </div>
                </div>
                
                <div class="collapse multi-collapse" id="CadastrarEvidencia">
                    <div class="atomic_card">
                        Estou Cadastrando uma evidência
                    </div>
                </div>
                <div class="collapse multi-collapse" id="MarcarFerias">
                    <div class="atomic_card">
                        Estou marcando férias
                    </div>
                </div>
                <div class="collapse multi-collapse" id="DarFeedback">
                    <div class="atomic_card">
                        Estou Dando feedbacks
                    </div>
                </div>   
            </div>
        </div>

    </div>
    



</section>







<?php
              
get_footer();

?>

