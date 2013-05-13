<?php namespace AntonioRibeiro\FirebirdDriver;

use Illuminate\Database;

/**
*
*/
class FirebirdDriverConnector extends Database\Connectors\Connector implements Database\Connectors\ConnectorInterface
{
	public function connect(array $config)
	{
        extract($config);

        $dsn = "firebird:dbname=$host:$database;charset=utf8";

        // The developer has the freedom of specifying a port for the Firebird database
        // or the default port (3306) will be used to make the connection by PDO.
        // The Unix socket may also be specified if necessary.
        if (isset($config['port']))
        {
            $dsn .= ";port={$config['port']}";
        }

        // The UNIX socket option allows the developer to indicate that the Firebird
        // instance must be connected to via a given socket. We'll just append
        // it to the DSN connection string if it is present.
        if (isset($config['unix_socket']))
        {
            $dsn .= ";unix_socket={$config['unix_socket']}";
        }

        $connection = new \PDO($dsn, $username, $password, $config);

        return $connection;
	}

	protected function getDsn(array $config) {
        extract($config);

        $dsn = "odbc:{$dsn}; {$username}; {$password};";

        return $dsn;
    }
}