<?php

/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcel
 * Data: 10/05/2022
 * Versão: 1.0
 ***********************************************************************************/

require_once('modulo/config.php');


function listarrEstado(){
     
    require_once('./model/bd/estado.php');
    
    $dados = selectAllEstados();
 
    if(!empty($dados)){
           
        return $dados;
    }else{

        return false;
    }
}




?>