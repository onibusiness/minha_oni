<div class="main">
    <form method="POST" action="<?php echo admin_url( 'admin.php' ); ?>">
        <input type="hidden" name="action" value="criar_missoes_clickup" />
        <p>Esse widget cria missões no board Missões Oni</p>
        <p>
            <label for="missao">Texto da missão</label>
            <input type='text' name='missao' class="regular-text" />
        </p>
        <p>
            <label for="date">Data da tarefa</label>
            <input type='date' name='date'  class="regular-text" />
        </p>
        <p>
            <label for="h_planejada">Horas</label> <br class="clear">
            <input type='number' step=".1" name='h_planejada'  class="regular-text" />
        </p>
        <p>
            <input type="submit" value="Criar missões!" class="button button-primary" />
            <br class="clear">
        </p>
    </form>
</div>