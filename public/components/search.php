<?php

function search($name, $nome)
{
    return 
    '
    <input type="text" name="'. $name .'" id="search-input" placeholder="Digite o '. $nome .' aqui...">
    ';
}

?>