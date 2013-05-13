<?
  require_once dirname(__FILE__)."/conf.php";
  require_once dirname(__FILE__)."/UsersController.php";
  require_once dirname(__FILE__)."/application.php"; /// rotinas gerais de aplicações
  require_once dirname(__FILE__)."/".strtolower($nome_sistema).".php"; /// esta aqui é a APLICAÇÃO em si
                                                 /// e tem que ter a função ApplicationRun() definida!

  // error_reporting(E_ALL);
  // ini_set('display_errors','On'); 
  
  ApplicationInitialize();    /// inicializa variáveis, cria HTML de abertura e loga o usuário

  if ($_SESSION['logged_user']) {
    ApplicationRun(); /// esta função TEM que existir em  [strtolower($nome_sistema).".php"]!
  }
?>