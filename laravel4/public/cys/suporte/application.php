<?
  require_once dirname(__FILE__)."/conf.php";        /// configura parâmetros e variáveis globais
  require_once dirname(__FILE__)."/interbase.php";
  require_once dirname(__FILE__)."/login.php";       /// rotinas de login e form de login

  require_once strtolower($nome_sistema).".php";


  // ----------------------------------------------------------------------------

  function ApplicationInitialize() {
  global $debug, $database_handle, $logoff;

    $database_handle = ConectaFB(); /// precisa conectar antes de qualquer coisa

    CheckLogin(); /// verifica se o usuário está logado e se não é para deslogar

    $pede_login = (!$_SESSION['logged_user'] && !UserLogin($_REQUEST['login'],$_REQUEST['password']));
    
    OpenHTML(); /// começa o HTML geral e da aplicação

    //if (!$_SESSION['logged_user'] && !UserLogin($_REQUEST['login'],$_REQUEST['password'])) {
    if ( $pede_login ) {
      if ($debug) echo "entrei 001<br>";
      LoginForm();
    } else {
      if ($debug) echo "entrei 002<br>";
      //ApplicationRun(); /// executa a aplicação
    }

    CloseHTML();    /// finaliza o HTML

  }

  function OpenHTML() {
  global $debug, $system, $url, $nome_sistema;

   ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/REC-html40/strict.dtd">
    <html>
      <head>
        <meta http-equiv="Content-Language" content="pt-br">
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>
           CyS - <? echo $nome_sistema; ?>
        </title>
      </head>

      <body bgcolor="#ddddFF">
    <?

      ApplicationConfigure();
      ApplicationOpenHTML();

    ?>
      <script language="JavaScript">
        function Voltar() { window.location.href=<? print "'$url'"; ?>; }
      </script>
   <?
  }

?>