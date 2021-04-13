
<?php
    $meta_query[] =
    array(
        'key' => 'status',
        'value' => 'Ativo',
        'compare' => '=='
    ); 

    $args = array(  
        'post_type' => 'projetos' ,
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),
        'posts_per_page' => -1,
        'meta_key'			=> 'projeto',
        'orderby'			=> 'meta_value',
        'order'				=> 'ASC',
        'meta_query' => $meta_query
    );
    $projetos = new WP_Query( $args ); 

?>
<div class="row ">
    <div class="col-12 ">
        <div class="atomic_card background_white">
        <p class="escala1 font-weight-bold onipink">Gerador de link de feedback</p>
            <div class='row'>
                <div class="col">
                    <select type="text" id="projeto" class="form-control col">   
                        <option value="">Escolha o projeto</option> 
                        <?php while ( $projetos->have_posts() ) : $projetos->the_post(); 
                            $nome = get_field('projeto');
                            $id = get_the_id();
                        ?>
                            <option value="<?php echo $id?>"><?php echo $nome;     ?></option> 
                        <?php endwhile;?>
                    </select>
                </div>
                <div class="col">
                    <input type="text" placeholder="Nome da frente" id="frente" class="form-control col">
                </div>
                <div class="col">    
                    <button type="button" onclick="getInputValue();" class="btn btn-danger">Gerar Link</button>
                </div>
            </div>
            
            <div id="boxlink" style='display: none;' class='row px-4 pt-4'>
                <p id="link" class='mb-0' onclick="copyDivToClipboard()"></p>
                <p id="copy" onclick="copyDivToClipboard()" class="escala-2 onipink">(Clique para copiar)</p>
            </div>
        </div>
    </div>
</div>

<script>
        function getInputValue(){
            // Selecting the input element and get its value 
            var projeto = document.getElementById("projeto").value;
            var frente = document.getElementById("frente").value.replace(/ /g, '%20');
            var inputVal = "https://minha.oni.com.br/feedback/?projeto="+projeto+"&frente="+frente;
            var block = document.getElementById("boxlink");
            
            block.style.display = "block";
            document.getElementById('link').innerHTML = inputVal;
            document.getElementById('link').innerHTML = inputVal;

        }
       
        function copyDivToClipboard() {
            var range = document.createRange();
            range.selectNode(document.getElementById("link"));
            window.getSelection().removeAllRanges(); // clear current selection
            window.getSelection().addRange(range); // to select text
            document.execCommand("copy");
            window.getSelection().removeAllRanges();// to deselect
            document.getElementById('copy').innerHTML = "Copiado!";
        }
    </script>

