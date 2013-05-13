<?

  function ConectaFB() {

    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    if ( isset( $GLOBALS['database_handle'] ) ):

      $GLOBALS['database_handle'] =
        ibase_connect( $GLOBALS['interbase_host'].":".$GLOBALS['interbase_database']
                     , $GLOBALS['interbase_username']
		     , $GLOBALS['interbase_password']
		     , $GLOBALS['interbase_charset']
		     );

      return $GLOBALS['database_handle'];

    else:

      global $database_handle,
             $interbase_host,
             $interbase_database,
             $interbase_username,
             $interbase_password;

      $database_handle = ibase_connect($interbase_host.":".$interbase_database, $interbase_username, $interbase_password);

      return $database_handle;

    endif;

  }

  function ExecSQL($SQL_Query) {
    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    if ( isset( $GLOBALS['database_handle'] ) ):
      $database_handle = $GLOBALS['database_handle'];
    else:
      global $database_handle;
    endif;

    if ($debug) {echo "SQL == ".$SQL_Query."<BR><BR>";}

    $sth = ibase_query ($database_handle, $SQL_Query);

    return $sth;
  }

  function myGetDate() {
    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    $my_t=getdate(date("U"));

    $dia = PADR($my_t[mday],2,"0");
    $mes = PADR($my_t[mon],2,"0");
    $ano = $my_t[year];

    $data = "$dia/$mes/$ano";

    Return $data;
  }

  function myGetDateTime() {
    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    Return myGetDate().' '.myGetTime();
  }

  function myGetTime() {
    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    $my_t=getdate(date("U"));

    $horas    = PADR($my_t[hours],2,"0");
    $minutos  = PADR($my_t[minutes],2,"0");
    $segundos = PADR($my_t[seconds],2,"0");

    $data = "$horas:$minutos:$segundos";

    Return $data;
  }

  function TrataTextoSQL($texto) {
    if ( isset( $GLOBALS['debug'] ) ):
      $debug = $GLOBALS['debug'];
    else:
      global $debug;
    endif;

    if (!$texto) {
      Return "";
    } else {
      Return preg_replace("/'/", '|', $texto);
    }
  }

?>