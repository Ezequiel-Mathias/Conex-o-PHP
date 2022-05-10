<?php
/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcel
 * Data: 10/05/2022
 * Versão: 1.0
 ***********************************************************************************/

require_once('conexaoMysql.php');


function selectAllEstados(){


    $conetion = conexaoMysql();            //abrindo conexao com bds

    // script paralistar todos os dados do BD, tbm serve para fazer em ordem decrecente (order by idcontato desc)
    $slq = "select * from tblestados order by nome asc" ;

    $result = mysqli_query($conetion,$slq);
     if($result){
        $cont = 0;
           while($rsdados = mysqli_fetch_assoc($result)){
                   
            $arreydados[$cont] = array(
               "idestado" =>  $rsdados['idestado'],
               "Nome"  =>$rsdados['nome'],
               "sigla" => $rsdados['sigla']
            );
            $cont++;
         } 

         //solicita o fechamento da conexao com o BD, importante  e obrigatorio por questoes de segurança !
         fecharConexaoMysql($conetion);
         return $arreydados;
     }

 
 }

 ?>