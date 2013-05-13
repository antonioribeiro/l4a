<?php

/*
 * etc.passwd.inc v1.0
 *
 * Syntax:
 *    verifypasswd(string USERNAME, string PASSWORD)
 *
 * The function will return one of three values:
 *    -2 if there was a file reading error
 *    -1 if the password is incorrect
 *     0 if the username doesn't exist
 *     1 if the password is correct
 *
 * Written by WarMage (michael@irc.net)
 *
 */
 
function verifypasswd ($USERNAME, $PASSWORD, $DONTSHOWMESSAGE=FALSE) {
  if (trim($USERNAME)=="" || trim($PASSWORD)=="") {
    return 0;
  } else {
    $success = @imap_open("{localhost:143}INBOX", $USERNAME, $PASSWORD);
    if (!$success) {
      if (imap_last_error()=="Too many login failures") {
        if (!$DONTSHOWMESSAGE) {
          PrintError("Login ou senha inválidos.");
        }
      } else {
        if (!$DONTSHOWMESSAGE) {
          PrintError("Erro IMAP:".imap_last_error());
	}  
      }
      return 0;
    } else {
      return 1;
    }
  }
}

function PrintError($message) {
  print "<br><b><font size=2 color=red><center>$message</center></font></b>";
}
                      
/*
function verifypasswd ($USERNAME, $PASSWORD) {
        $filename = "/etc/mail/mailadmin.lst";
        $fd = fopen($filename, "r");
        $contents = fread($fd, filesize($filename));
        fclose($fd);
        if (!$contents) return -2;

        $lines = split("\n", $contents);
        $passwd = array();

        for($count=0;$count<count($lines);$count++) {
                list ($user,$pass) = split(":",$lines[$count]);
                if ($user == $USERNAME) {
                        break;
                }
	}

        if (!$user) return 0;

        $cryptedpass = $pass;
        $salt = substr($cryptedpass,0,12);
        $Pass = crypt($PASSWORD,$salt);

        if ($Pass == $cryptedpass) {
                return 1;
        } else {
                return -1;
        }
}
*/

function replicate($sString, $iLength) {

  for ($i=1; $i <= $iLength; $i++) {
    $result .= $sString;
	}
	
  return $result;
	
}

function iso8859toHTML($string, $verificaiso) {
  $isoQ = "ISO-8859-1?Q?";
  $isoB = "ISO-8859-1?B?";
  
  if ($verificaiso) {  
    $continua = FALSE;
    if (strpos(strtoupper($string), $isoQ) <> 0) {
      $continua = TRUE;
      $IsIsoQ = TRUE;
    } else if (strpos(strtoupper($string), $isoB) <> 0) {
      $continua = TRUE;
      $IsIsoB = TRUE;
    }
    if (!$continua) return $string;
  }
  
  if ($verificaiso) {  
    $string = str_replace("ISO-8859-1?Q?", "", $string);
    $string = str_replace("iso-8859-1?Q?", "", $string);
    $string = str_replace("ISO-8859-1?B?", "", $string);
    $string = str_replace("iso-8859-1?B?", "", $string);
    $string = str_replace("?=", "", $string);
    $string = str_replace("=?", "", $string);
  }
  
  if ($IsIsoB) $string = Base64_Decode($string);
  
  $string = str_replace("_"," ",$string);
  $string = str_replace("=C1","&Aacute;",$string);
  $string = str_replace("=C2","&Acirc;",$string);
  $string = str_replace("=C3","&Atilde;",$string);
  $string = str_replace("=C4","&Auml;",$string);
  $string = str_replace("=C5","&Aring;",$string);
  $string = str_replace("=C6","&AElig;",$string);
  $string = str_replace("=C7","&Ccedil;",$string);
  $string = str_replace("=C8","&Egrave;",$string);
  $string = str_replace("=C9","&Eacute;",$string);
  $string = str_replace("=CA","&Ecirc;",$string);
  $string = str_replace("=CB","&Euml;",$string);
  $string = str_replace("=CC","&Igrave;",$string);
  $string = str_replace("=CD","&Iacute;",$string);
  $string = str_replace("=CE","&Icirc;",$string);
  $string = str_replace("=CF","&Iuml;",$string);
  $string = str_replace("=D0","&ETH;",$string);
  $string = str_replace("=D1","&Ntilde;",$string);
  $string = str_replace("=D2","&Ograve;",$string);
  $string = str_replace("=D3","&Oacute;",$string);
  $string = str_replace("=D4","&Ocirc;",$string);
  $string = str_replace("=D5","&Otilde;",$string);
  $string = str_replace("=D6","&Ouml;",$string);
  $string = str_replace("=D7","&times;",$string);
  $string = str_replace("=D8","&Oslash;",$string);
  $string = str_replace("=D9","&Ugrave;",$string);
  $string = str_replace("=DA","&Uacute;",$string);
  $string = str_replace("=DB","&Ucirc;",$string);
  $string = str_replace("=DC","&Uuml;",$string);
  $string = str_replace("=DD","&Yacute;",$string);
  $string = str_replace("=DE","&THORN;",$string);
  $string = str_replace("=DF","&szlig;",$string);
  $string = str_replace("=E1","&aacute;",$string);
  $string = str_replace("=E2","&acirc;",$string);
  $string = str_replace("=E3","&atilde;",$string);
  $string = str_replace("=E4","&auml;",$string);
  $string = str_replace("=E5","&aring;",$string);
  $string = str_replace("=E6","&aelig;",$string);
  $string = str_replace("=E7","&ccedil;",$string);
  $string = str_replace("=E8","&egrave;",$string);
  $string = str_replace("=E9","&eacute;",$string);
  $string = str_replace("=EA","&ecirc;",$string);
  $string = str_replace("=EB","&euml;",$string);
  $string = str_replace("=EC","&igrave;",$string);
  $string = str_replace("=ED","&iacute;",$string);
  $string = str_replace("=EE","&icirc;",$string);
  $string = str_replace("=EF","&iuml;",$string);
  $string = str_replace("=F0","&eth;",$string);
  $string = str_replace("=F1","&ntilde;",$string);
  $string = str_replace("=F2","&ograve;",$string);
  $string = str_replace("=F3","&oacute;",$string);
  $string = str_replace("=F4","&ocirc;",$string);
  $string = str_replace("=F5","&otilde;",$string);
  $string = str_replace("=F6","&ouml;",$string);
  $string = str_replace("=F7","&divide;",$string);
  $string = str_replace("=F8","&oslash;",$string);
  $string = str_replace("=F9","&ugrave;",$string);
  $string = str_replace("=FA","&uacute;",$string);
  $string = str_replace("=FB","&ucirc;",$string);
  $string = str_replace("=FC","&uuml;",$string);
  $string = str_replace("=FD","&yacute;",$string);
  $string = str_replace("=FE","&thorn;",$string);
  $string = str_replace("=FF","&yuml;",$string);  
  $string = str_replace("=F0","&eth;",$string);
  $string = str_replace("=20"," ",$string);
  $string = str_replace("=21","!",$string);
  $string = str_replace("=22","&quot;",$string);
  $string = str_replace("=23","#",$string);
  $string = str_replace("=24","$",$string);
  $string = str_replace("=25","%",$string);
  $string = str_replace("=26","&amp;",$string);
  $string = str_replace("=27","'",$string);
  $string = str_replace("=28","(",$string);
  $string = str_replace("=29",")",$string);
  $string = str_replace("=2A","*",$string);
  $string = str_replace("=2B","+",$string);
  $string = str_replace("=2C",",",$string);
  $string = str_replace("=2D","-",$string);
  $string = str_replace("=2E",".",$string);
  $string = str_replace("=2F","/",$string);
  $string = str_replace("=30","0",$string);
  $string = str_replace("=31","1",$string);
  $string = str_replace("=32","2",$string);
  $string = str_replace("=33","3",$string);
  $string = str_replace("=34","4",$string);
  $string = str_replace("=35","5",$string);
  $string = str_replace("=36","6",$string);
  $string = str_replace("=37","7",$string);
  $string = str_replace("=38","8",$string);
  $string = str_replace("=39","9",$string);
  $string = str_replace("=3A",":",$string);
  $string = str_replace("=3B",";",$string);
  $string = str_replace("=3C","&lt;",$string);
  $string = str_replace("=3D","=",$string);
  $string = str_replace("=3E","&gt;",$string);
  $string = str_replace("=3F","?",$string);
  $string = str_replace("=40","@",$string);
  $string = str_replace("=41","A",$string);
  $string = str_replace("=42","B",$string);
  $string = str_replace("=43","C",$string);
  $string = str_replace("=44","D",$string);
  $string = str_replace("=45","E",$string);
  $string = str_replace("=46","F",$string);
  $string = str_replace("=47","G",$string);
  $string = str_replace("=48","H",$string);
  $string = str_replace("=49","I",$string);
  $string = str_replace("=4A","J",$string);
  $string = str_replace("=4B","K",$string);
  $string = str_replace("=4C","L",$string);
  $string = str_replace("=4D","M",$string);
  $string = str_replace("=4E","N",$string);
  $string = str_replace("=4F","O",$string);
  $string = str_replace("=50","P",$string);
  $string = str_replace("=51","Q",$string);
  $string = str_replace("=52","R",$string);
  $string = str_replace("=53","S",$string);
  $string = str_replace("=54","T",$string);
  $string = str_replace("=55","U",$string);
  $string = str_replace("=56","V",$string);
  $string = str_replace("=57","W",$string);
  $string = str_replace("=58","X",$string);
  $string = str_replace("=59","Y",$string);
  $string = str_replace("=5A","Z",$string);
  $string = str_replace("=5B","[",$string);
  $string = str_replace("=5C","\\",$string);
  $string = str_replace("=5D","]",$string);
  $string = str_replace("=5E","&circ;",$string);
  $string = str_replace("=5F","_",$string);
  $string = str_replace("=61","a",$string);
  $string = str_replace("=62","b",$string);
  $string = str_replace("=63","c",$string);
  $string = str_replace("=64","d",$string);
  $string = str_replace("=65","e",$string);
  $string = str_replace("=66","f",$string);
  $string = str_replace("=67","g",$string);
  $string = str_replace("=68","h",$string);
  $string = str_replace("=69","i",$string);
  $string = str_replace("=6A","j",$string);
  $string = str_replace("=6B","k",$string);
  $string = str_replace("=6C","l",$string);
  $string = str_replace("=6D","m",$string);
  $string = str_replace("=6E","n",$string);
  $string = str_replace("=6F","o",$string);
  $string = str_replace("=70","p",$string);
  $string = str_replace("=71","q",$string);
  $string = str_replace("=72","r",$string);
  $string = str_replace("=73","s",$string);
  $string = str_replace("=74","t",$string);
  $string = str_replace("=75","u",$string);
  $string = str_replace("=76","v",$string);
  $string = str_replace("=77","w",$string);
  $string = str_replace("=78","x",$string);
  $string = str_replace("=79","y",$string);
  $string = str_replace("=7A","z",$string);
  $string = str_replace("=7B","{",$string);
  $string = str_replace("=7C","|",$string);
  $string = str_replace("=7D","}",$string);
  $string = str_replace("=7E","&tilde;",$string);
  $string = str_replace("=A0","&nbsp;",$string);
  $string = str_replace("=A1","&iexcl;",$string);
  $string = str_replace("=A2","&cent;",$string);
  $string = str_replace("=A3","&pound;",$string);
  $string = str_replace("=A4","&curren;",$string);
  $string = str_replace("=A5","&yen;",$string);
  $string = str_replace("=A6","&brvbar;",$string);
  $string = str_replace("=A7","&sect;",$string);
  $string = str_replace("=A8","&uml;",$string);
  $string = str_replace("=A9","&copy;",$string);
  $string = str_replace("=AA","&ordf;",$string);
  $string = str_replace("=AB","&laquo;",$string);
  $string = str_replace("=AC","&not;",$string);
  $string = str_replace("=AD","&shy;",$string);
  $string = str_replace("=AE","&reg;",$string);
  $string = str_replace("=AF","&macr;",$string);
  $string = str_replace("=B0","&deg;",$string);
  $string = str_replace("=B1","&plusmn;",$string);
  $string = str_replace("=B2","&sup2;",$string);
  $string = str_replace("=B3","&sup3;",$string);
  $string = str_replace("=B4","&acute;",$string);
  $string = str_replace("=B5","&micro;",$string);
  $string = str_replace("=B6","&para;",$string);
  $string = str_replace("=B7","&middot;",$string);
  $string = str_replace("=B8","&cedil;",$string);
  $string = str_replace("=B9","&sup1;",$string);
  $string = str_replace("=BA","&ordm;",$string);
  $string = str_replace("=BB","&raquo;",$string);
  $string = str_replace("=BC","&frac14;",$string);
  $string = str_replace("=BD","&frac12;",$string);
  $string = str_replace("=BE","&frac34;",$string);
  $string = str_replace("=BF","&iquest;",$string);

  return $string;
}


   // These functions are used to encrypt the passowrd before it is
   // stored in a cookie.
   function OneTimePadEncrypt ($string, $pad) {
      for ($i = 0; $i < strlen ($string); $i++) {
	 $encrypted .= chr (ord($string[$i]) ^ ord($pad[$i]));
      }

      return base64_encode($encrypted);
   }

   function OneTimePadDecrypt ($string, $pad) {
      $encrypted = base64_decode ($string);
      
      for ($i = 0; $i < strlen ($encrypted); $i++) {
	 $decrypted .= chr (ord($encrypted[$i]) ^ ord($pad[$i]));
      }

      return $decrypted;
   }

   function OneTimePadCreate ($length=100) {
      srand ((double) microtime() * 1000000);

      for ($i = 0; $i < $length; $i++) {
	 $pad .= chr(rand(0,255));
      }

      return $pad;
   }

   function ConvertToSafeLink ($link) {
     return str_replace('&', '|26|', $link);
   }

   function SafeLinkToStr ($link) {
     return str_replace('|26|', '&', $link);
   }

function PADL($string,$size,$char = " ") {
  while (strlen($string) < $size) {
    $string .= $char;
  }
  return $string;
}

function PADR($string,$size,$char = " ") {
  while (strlen($string) < $size) {
    $string = $char.$string;
  }
  return $string;
}

function AddToEndOfFile($filename, $string) {
  $handle = fopen($filename, "a+");
  $numbytes = fwrite($handle, $string);
  fclose($handle);
}
         
?>