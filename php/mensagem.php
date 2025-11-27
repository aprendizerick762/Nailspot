<?php
// mensagem.php - exibe toast com Materialize (assume que Materialize JS já foi carregado na página)

// garante que a sessão esteja iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['mensagem']) && $_SESSION['mensagem'] !== ''): 
    $msg = addslashes($_SESSION['mensagem']); // escapa apóstrofos
    ?>
    <script>
      // chama toast – assume Materialize já carregado
      document.addEventListener('DOMContentLoaded', function() {
        if (typeof M !== 'undefined' && M && M.toast) {
          M.toast({ html: '<?= $msg ?>' });
        } else {
          // fallback simples se Materialize não existe
          alert('<?= $msg ?>');
        }
      });
    </script>
<?php
    // limpa apenas a mensagem (mantém a sessão)
    unset($_SESSION['mensagem']);
endif;
?>

<!--// 
//Iniciar  Sessão
session_start();

//se existe a sessão mensagem criada
if(isset($_SESSION['mensagem'])): 
?>
	
 <script>
   //Mensagem de alerta javascript do materialize
	window.onload = function(){
		  M.toast({html: '<php echo $_SESSION['mensagem']; ?>'});
		
		
	};
</script>

<php 	
endif;
session_unset(); //limpar a sessão  -->

