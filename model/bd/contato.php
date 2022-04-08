<?php

/**********************************************************************************
 * Objetivo: Arquivo resposavel por manipular os dados dentro do bd
 * Autor: Marcel
 * Data: 11/03/2022
 * Versão: 1.0
 ***********************************************************************************/

include('conexaoMysql.php');

// funcoes para realizar  no banco de dados



    function insertContato($dadocontatos){
         

      $statusResposta = (boolean) false;

        // conexao esta recebendo o retorn na fuction conexaoMysql(); // abrindo conexao com o bds
       $conexao = conexaoMysql();

      $sql = "insert into tblcontatos 
         (nome,
         telefone, 
         celular , 
         email , 
         obs)

      value 

         ('".$dadocontatos{'nome'}."', 
         '".$dadocontatos{'telefone'}."', 
         '".$dadocontatos{'celular'}."', 
         '".$dadocontatos['email']."',
         '".$dadocontatos{'obs'}."');";

      //se deu certo ou se deu erro no script
      if(mysqli_query($conexao,$sql)){// executa o escrip no bds , mysqli_query(QUALBANCODEDADOS,QUAISDADOS);  
              
      if(mysqli_affected_rows($conexao))         //se teve uma linha afetada ou nao no bds = linha afeteda = se o banco recusou ou add a linha 'script';
      $statusResposta = true;
      }
      fecharConexaoMysql($conexao);
       return $statusResposta;


}


                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                          

    function updateContato($dadocontatos){

      $statusResposta = (boolean) false;

       // conexao esta recebendo o retorn na fuction conexaoMysql(); // abrindo conexao com o bds
       $conexao = conexaoMysql();

      $sql = "update tblcontatos set
         nome = '".$dadocontatos{'nome'}."',
         telefone = '".$dadocontatos{'telefone'}."', 
         celular = '".$dadocontatos{'celular'}."', 
         email = '".$dadocontatos['email']."', 
         obs = '".$dadocontatos{'obs'}."'
         where idcontato =" . $dadocontatos['id'];
         

    

      //se deu certo ou se deu erro no script
      if(mysqli_query($conexao,$sql)){// executa o escrip no bds , mysqli_query(QUALBANCODEDADOS,QUAISDADOS);  
              
      if(mysqli_affected_rows($conexao))         //se teve uma linha afetada ou nao no bds = linha afeteda = se o banco recusou ou add a linha 'script';
      $statusResposta = true;
      }
      fecharConexaoMysql($conexao);
       return $statusResposta;
        
    }


    function deleteContato($id){

      //declaração da variavel para return desta função 
      $statusresposta = (boolean) false;

      //Abre a conexao com o BD 
      $conexao = conexaoMysql();
        //script para deletar um registro no BD
        $sql = "delete from tblcontatos where idcontato = ".$id;
      //Valida se o script esta correto, sem erro de sintaxe e executa no BD
        if (mysqli_query($conexao, $sql)){

         //Valida se o BD teve sucesso na execução do script
         if(mysqli_affected_rows($conexao))
            $statusresposta = true;
        }

        //fecha a conexão com o BD mysql
        fecharConexaoMysql($conexao);
        return $statusresposta;
    }


    function selectAllContatos(){
       $conetion = conexaoMysql();            //abrindo conexao com bds

       // script paralistar todos os dados do BD, tbm serve para fazer em ordem decrecente (order by idcontato desc)
       $slq = "select * from tblcontatos order by idcontato desc" ;

       $result = mysqli_query($conetion,$slq);
        if($result){
           $cont = 0;
              while($rsdados = mysqli_fetch_assoc($result)){
                      
               $arreydados[$cont] = array(
                  "id" =>  $rsdados['idcontato'],
                  "Nome"  =>$rsdados['nome'],
                  "Telefone"  =>$rsdados['telefone'],
                  "Celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['email'],
                  "Obs"  =>$rsdados['obs']
               );
               $cont++;
            } 

            //solicita o fechamento da conexao com o BD, importante  e obrigatorio por questoes de segurança !
            fecharConexaoMysql($conetion);
            return $arreydados;
        }

    
    }


    //função para buscar um contato no banco de dados atraves de um id do registro
    function selectByIdContatos($id){

      $conetion = conexaoMysql();            //abrindo conexao com bds

       // script paralistar todos os dados do BD, tbm serve para fazer em ordem decrecente (order by idcontato desc)
       $slq = "select * from tblcontatos where idcontato = ".$id ;

       $result = mysqli_query($conetion,$slq);
        if($result){
           
              if($rsdados = mysqli_fetch_assoc($result)){
                      
               $arreydados = array(
                  "id" =>  $rsdados['idcontato'],
                  "Nome"  =>$rsdados['nome'],
                  "Telefone"  =>$rsdados['telefone'],
                  "Celular"  =>$rsdados['celular'],
                  "Email"  =>$rsdados['email'],
                  "Obs"  =>$rsdados['obs']
               );
               
             } 

            //solicita o fechamento da conexao com o BD, importante  e obrigatorio por questoes de segurança !
            fecharConexaoMysql($conetion);
            return $arreydados;
        }


    }



?>