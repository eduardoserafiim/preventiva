<?php 

function voltar($caminho)
{ ?>
    <a href="<?= htmlspecialchars($caminho) ?>">
        <i class="fa-solid fas fa-arrow-left fa-2xl"></i>
    </a>
<?php }