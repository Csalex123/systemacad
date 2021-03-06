<?php 
include_once "../../control/MatriculaControl.class.php";
include_once "../../control/LoginSecretariaControl.class.php";
 
  
$objLogin = new LoginSecretariaControl();
  
$objLogin->verificarLogado();

$objControl = new MatriculaControl();


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/style.css" type="text/css">

        <style type="text/css">


        /*menu*/
        #menu-secretaria .sidebar-nav .navbar li a:hover {
          background-color: white;
          color: black;
         }
       
       table , th{
          text-align: center;
        }
        thead{
          text-align: center;
          background-color: #f8f8ff;
        }

        .table-responsive{
          margin-bottom: 10px;
        }
         
       
        .input-group , #txtPesquisa{

          width: 100%;
        }

        </style>

      
      

    </head>
    <body onload="atualizarTabela();">
    

    <div class="row affix-row" id="menu-secretaria">
       <div class="col-sm-3 col-md-2 affix-sidebar">
		      <div class="sidebar-nav" >
            <div class="navbar navbar-default" role="navigation">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                     <span class="sr-only">Toggle navigation</span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                  </button>
                  <span class="visible-xs navbar-brand">SystemAcad&nbsp;&nbsp;<span class="glyphicon glyphicon-education"></span></span>
               </div>
               <div class="navbar-collapse collapse sidebar-navbar-collapse">
                  <ul class="nav navbar-nav" id="sidenav01">
                    <li >
                       <?php include '../../paginas/secretaria/user.php';?>
                    </li>
                    <?php include '../../paginas/secretaria/menu.php';?>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
         </div>
	  </div>
	  <div class="col-sm-9 col-md-10 affix-content">
	    	<div class="container">
			
			  	  <div class="page-header">
	              <h3><span class="glyphicon glyphicon-user"></span> &nbsp;Aluno</h3>
            </div>
            <div class="row">
               <form>
             
                    <div class="form-group col-md-12 col-lg-12 col-sm-12" >
                      <label>Pesquisa</label>
                       <div class="input-group">
                        <input id="txtPesquisa" type="text" name="pesquisa" class="form-control">
                       </div>
                   
                    </div>
                 
               </form>
            </div>  	
            <div class="table-responsive" style="overflow-y:auto;height:250px; width:100%;">
              <table id="tabela-aluno" class="table table-hover table-condensed ">
                <thead>
                   <tr>
                     <th>Matrícula</th>
                     <th>Nome</th>
                     <th>CPF</th>
                     <th>RG</th>
                     <th>Curso</th>
                     
                     
                   </tr>
                   
                </thead>
                <tbody id="tbBodyAluno">
                                      
                 
                </tbody>
              </table>
            </div>
            <form action="../../paginas/secretaria/aluno-form.php" method="post" name="enviar_parametros" >
               <input type="hidden" id="cod" name="cod" value="" />
               <input type="hidden" id="metodo" name="metodo" value="" />
               
            </form>
            <div id="group-button">
              <button id="btnIncluir" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span>&nbsp; Incluir</button>
              <button id="btnConsultar" class="btn btn-default""><span class="glyphicon glyphicon-open"></span> &nbsp;Consultar</button>
              
             
              <button id="btnExcluir" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> &nbsp;Excluir</button>
            </div> 
           

          
				    
			
		    </div>
	  </div>
   </div>


  
   

   
     <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

     <script type='text/javascript'>


        var cod;
        var resposta;
        //funcao para atualizar tabela quando 
        function atualizarTabela(){

         
          document.getElementById('tbBodyAluno').innerHTML = "<?php $objControl->listaAlunos(); ?>";
          
          
        }

       
        $(window).load(function(){
          
          // funcao para selecionar linha da tabela
          $("#tabela-aluno > tbody > tr").on("click", function (e) {
            $(this).siblings().removeClass("table-active");
            $(this).toggleClass("table-active");
            cod = $(this).attr( 'id' );
          });
          
          //funcao para encaminha o aluno selecionado para a consulta
          
          $("#btnConsultar").on("click", function (e) {
            
            if(cod==null){

              alert("Selecione um aluno para a consulta.");
                              
            }else{

              document.getElementById('cod').value = cod;
              document.getElementById('metodo').value = 'consultar';
             
              document.enviar_parametros.submit();

            }
             
          });
          
           //funcao encaminhamento para inclusao de um novo aluno
          $("#btnIncluir").on("click", function (e) {


              document.getElementById('cod').value = 0;
              document.getElementById('metodo').value = 'incluir';
              document.enviar_parametros.submit();

             
          });

          //funcao encaminhamento para exclusao do aluno selecionado
          $("#btnExcluir").on("click", function (e) {
            
            if(cod==null){

              alert("Selecione um aluno para a excluir.");
                              
            }else{


               if(!confirm("Tem certeza que deseja apagar este aluno?")){
                  return false;
               }else{
                
                 $.post('../../paginas/secretaria/processar.php', {
                  cod:cod,
                  metodo:'excluir',
                  entidade:'aluno'
                 }, function(resposta){

                   if(resposta == 1){
                      
                      
                     alert('Aluno excluido com sucesso.');
                     document.getElementById('tbBodyAluno').removeChild(document.getElementById(cod));
                      
                      
                    
                   }else {
                     alert('Erro ao excluir o aluno.');
                   }

                 });
       
               }

               
                 
              
           
              return false;

            }

          });


            
          
        }); 


     </script>
     <script>
     
     $(document).ready(function(){
      
        $("#txtPesquisa").on("keyup", function() {
          var letra = $(this).val().toLowerCase();
          
            $("#tbBodyAluno tr").filter(function() {
              
               $(this).toggle($(this).text().toLowerCase().indexOf(letra) > -1);
                
               
               
  
                
            });

             
         });

       

      });

     
    
    </script>


      
    

    

    </body>
</html>
