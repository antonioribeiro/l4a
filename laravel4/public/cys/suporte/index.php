<?
  require_once dirname(__FILE__)."/conf.php";
  require_once dirname(__FILE__)."/UsersController.php";
  require_once dirname(__FILE__)."/application.php"; /// rotinas gerais de aplica��es
  require_once dirname(__FILE__)."/".strtolower($nome_sistema).".php"; /// esta aqui � a APLICA��O em si
                                                 /// e tem que ter a fun��o ApplicationRun() definida!

  // error_reporting(E_ALL);
  // ini_set('display_errors','On'); 
  
  ApplicationInitialize();    /// inicializa vari�veis, cria HTML de abertura e loga o usu�rio

  if ($_SESSION['logged_user']) {
    ApplicationRun(); /// esta fun��o TEM que existir em  [strtolower($nome_sistema).".php"]!
  }
?>