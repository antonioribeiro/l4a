<?
  require_once "conf.php";        /// configura parâmetros e variáveis globais

  $debug = FALSE;

  function ApplicationConfigure() {
    $_REQUEST['cliente'] = SafeLinkToStr($_REQUEST['cliente']);

    if ($_REQUEST['setsys']) {
      $_SESSION['system'] = $_REQUEST['setsys']; // setsys vem do browser
    }

    if ($_REQUEST['setsys']=="mudarsistema") {
      $_SESSION['system']="";
    }

    if (!ExisteSistema($_SESSION['system'])) {
      $_SESSION['system'] = "";
    }
  }
  
  function ApplicationRun() {
  global $debug;

    if ($_REQUEST['cliente']) {
      MostraCliente();
    } else if (!$_SESSION['system']) {
      ListaSistemasForm();
    } else if ($_SESSION['system']) {
      ListaClientesForm();
    }
  }

  function ApplicationOpenHTML() {
  global $debug, $url, $nome_sistema;

  if ($_SESSION['logged_user'] != '') {
    $logged_user_password = " (".Hash4PHP(myGetDate().$_SESSION['logged_user']).")";
    if ($debug) {
      $logged_user_password = $logged_user_password ." = ". $_REQUEST['cliente'].myGetDate().$_SESSION['logged_user'];
    }  
  } else {
    $logged_user_password = "";
  }
  
  if ($debug) echo "003 - logged_user=".$_SESSION['logged_user'];

  ?>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1">
    <td>
      <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><img border="0" src="inseto.gif" width="70" height="49"></td>
        <td width="100%">
        <font face="Verdana" size="7">&nbsp;<? print $nome_sistema; ?></font></td>
      </tr>
      </table>
    </td>
    
    <td width="100%" align="right">
      <table>
       <tr>
         <td>
          <font face="Arial" size="2" color="#0000FF"><b><? print $_SESSION['logged_user'].$logged_user_password ; ?></b></font><br>
           <?if ($_SESSION['logged_user']) {
            ?> <font face="Arial" size="1" color="#0000FF"><a href="<? print $url; ?>?logoff=sim">logoff</a></font><?
           }?>
         </td>
         
       <tr>
         <td align="right">
           <b><font size="6" color="#FF0000" face="Arial"><? print $_SESSION['system']; ?></font></b><br>
           <?if ($_SESSION['system']) {
             ?> <b><font face="Arial" size="1" color="#0000FF"><a href="<? print $url; ?>?setsys=mudarsistema">Mudar sistema</a></font></b> <?
           }?>
         </td>
       </tr>
      </table> 
    </td>
   
    </tr>
    </table>
    <br>
    <font face="arial">
  <?
  }



// --------------------------------------------------------

  function ApplicationCloseHTML() {
  global $debug;

    /// por enquanto é só definição
  }

// ----------------------------------------------------------

  function MostraCliente() {
  global $debug;

  ?>
    <div><center><table>
  <?

    echo  "<tr><td> </td></tr>";
    echo  "<tr><td> </td></tr>";
    echo  "<tr><td> </td></tr>";

    echo "<tr><td><font face=tahoma size=6> Cliente: ".$_REQUEST['cliente']." </font></td></tr>";
    echo  "<tr><td><font face=tahoma size=6> Sistema: ".$_SESSION['system']." </font></td></tr>";
    echo  "<tr><td><font face=tahoma size=6> Data: ".myGetDate()." </font></td></tr>";
    echo  "<tr><td><font face=tahoma size=6> Código de acesso: <font color=red>".BuildAccessCode($_REQUEST['cliente'],$_SESSION['system'])." </font></font></td></tr>";

  ?>
    </table></center></div>
  <?

  }

  function BuildAccessCode($cliente,$system) 
  {
    global $debug;

    $cliente = ClearString($cliente); /// retira acentos e caracteres de controle
    $sString = $cliente.myGetDate().$system;

    return Hash4PHP($sString);
  }

  function ClearString($input)
  {
     $interim = $input;

     for ($i=0; $i<strlen($interim); $i++)
     {
         $char = $interim{$i};
         $asciivalue = ord($char);
         if ( ($asciivalue >= 32) and ($asciivalue <= 127) ) {
           $result .= $char;
         }
     }

     return $result;
  }

  function Hash4PHP($sString) {
  global $debug;

    $sString = strtoupper($sString.$sString.$sString.$sString.$sString.$sString.$sString);
    
    if ($debug) echo "\$string = $sString<br>";
    
    $s32 = md5($sString);
    if ($debug) echo "1 - s32=$s32<br>";

    $s32 = substr($s32,0,8);
    if ($debug) echo "2 - s32=$s32<br>";

    $s32 = hexdec($s32);
    if ($debug) echo "3 - s32=$s32<br>";

    $s32 = DecToBase60($s32);
    if ($debug) echo "4 - s32=$s32<br>";

    Return $s32;
  }

  function DecToBase60($N) {
  global $debug;

    $pBASE60 = array("0","1","2","3","4","5","6","7","8",
                     "a","b","c","d","e","f","g","i","h","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
                     "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X","Y","Z","$");

    $A = 20; // Numero maximo de caracteres em uma string;
    $sResult = '';

    $I = $A;
    while ($N >= 60) {
      $C = (int) fmod($N, 60); // mod

      if ($debug) echo "C=$C<br>";
      if ($debug) echo "N=$N<br>";
      if ($debug) echo "<br>";

      $sResult = $pBASE60[$C].$sResult;
      $N = $N / 60;
      $I--;
    }

    Return strtoupper(Trim($sResult));
  }

  function ListaSistemasForm() {
  global $debug, $url;

    $SQL = "select  s.codigo
                  , s.descricao
                  , (select count(*) from CLIENTE_SISTEMA c where c.CODIGO_SISTEMA = s.codigo) total
            from  SISTEMA s
	    where codigo <> 'Base'
            order by s.codigo";

    $sth = ExecSQL($SQL);

    ?><div><center>
    <table>
    <?php
    while ($row = ibase_fetch_object ($sth)) {
      if ($row->TOTAL > 0) {
        if ($row->TOTAL > 1) {
          $plural = 's';
        } else {
          $plural = '';
        }
        $clientes = ' ('.$row->TOTAL.' cliente'.$plural.')';
      } else {
        $clientes = '';
      }
      if ($row->TOTAL > 0) {
        $link = '<a href="'.$url.'?setsys='.$row->CODIGO.'"><font face=tahoma size=5>'.$row->CODIGO.'</fONT></a><font face=tahoma size=2>'.$clientes.'</font>';
      } else {
        $link = '<font face=tahoma size=5>'.$row->CODIGO.'</font><font face=tahoma size=2>'.$clientes.'</font>';
      }
      print "<tr><td> $link </td></tr>";
    }

    print "</table></center></div>";
  }

  function ListaClientesForm() {
  global $debug, $url;

    $SQL = "select  s.codigo_sistema, s.nome_cliente
            from CLIENTE_SISTEMA s
            where s.codigo_sistema = '".$_SESSION['system']."'
            order by s.nome_cliente";

    $sth = ExecSQL($SQL);

    ?><div><center><!-- Legenda de prioridade
    <table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td bgcolor="#00CC00">&nbsp;<b>0&nbsp;</td>
    <td bgcolor="#80E600">&nbsp;<b>1&nbsp;</td>
    <td bgcolor="#FFFF00">&nbsp;<b>2&nbsp;</td>
    <td bgcolor="#FFBF00">&nbsp;<b>3&nbsp;</td>
    <td bgcolor="#FF8000">&nbsp;<b>4&nbsp;</td>
    <td bgcolor="#FF4000">&nbsp;<b>5&nbsp;</td>
    <td bgcolor="#FF0000">&nbsp;<b>6&nbsp;</td>
    <td bgcolor="#CC0000">&nbsp;<b>7&nbsp;</td>
    </tr>
    </table -->
    <table>
    <?php
    while ($row = ibase_fetch_object ($sth)) {
      $link = '<a href="'.$url.'?setsys='.$row->CODIGO_SISTEMA.'&cliente='.ConvertToSafeLink($row->NOME_CLIENTE).'"><font face=tahoma size=5>'.$row->NOME_CLIENTE.'</font></a>';
      print "<tr><td> $link </td></tr>";
    }

    print "</table></center></div>";
  }

  function CloseHTML() {
  global $debug;

  ?>
    </body>
    </html>
  <?
  }

  function ExisteSistema($sistema) {
    $SQL = "select count(*) TOTAL from SISTEMA where codigo='$sistema'";
    $sth = ExecSQL($SQL);

    $row = ibase_fetch_object ($sth);

    if ($row->TOTAL > 0) {
      Return TRUE;
    } else {
      Return FALSE;
    }
  }
  
?>