<?
  session_start();
  require_once dirname(__FILE__)."/cys.php";

  /*session_register("logged_user");
  session_register("system");*/

  $debug              = FALSE;
  $database_handle    = 0;
  $url                = $_SERVER['PHP_SELF'];
  $nome_sistema       = 'Suporte';

  $interbase_host     = "papagaio.cys.com.br";
  $interbase_database = "/database/insetomania.fdb";
  $interbase_username = "sysdba";
  $interbase_password = "ziz084";
?>
