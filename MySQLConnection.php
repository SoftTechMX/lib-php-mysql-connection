<?php

class MySQLConnection
{
    private $IP;
    private $PASSWORD;
    private $USERNAME;
    private $DATABASE;
    private $PORT;
    public $Connection;

    public function __construct()
    {
        $this->IP       = null;
        $this->PASSWORD = null;
        $this->USERNAME = null;
        $this->DATABASE = null;
        $this->PORT     = 3306;
    }

    public function setIP( $IP )
    {
        $this->IP = $IP;
    }

    public function getIP()
    {
        return $this->IP;
    }

    public function setPassword( $PASSWORD )
    {
        $this->PASSWORD = $PASSWORD;
    }

    public function getPassword()
    {
        return $this->PASSWORD;
    }

    public function setUsername( $USERNAME )
    {
        $this->USERNAME = $USERNAME;
    }

    public function getUsername()
    {
        return $this->USERNAME;
    }

    public function setDatabase( $DATABASE )
    {
        $this->DATABASE = $DATABASE;
    }

    public function getDatabase()
    {
        return $this->DATABASE;
    }

    public function setPort( $PORT )
    {
        $this->PORT = $PORT;
    }

    public function getPort()
    {
        return $this->PORT;
    }

    public function connect()
    {

        $this->Connection = new mysqli
        (
            $this->IP,
            $this->USERNAME,
            $this->PASSWORD,
            $this->DATABASE,
            $this->PORT
        );

        // WE CHEACK THE CONNECTION STATUS
        if ($this->Connection->connect_error)
        {
            echo  $this->Connection->connect_error;
            return false;
        }
        else
        {
            return true;
        }
    }

    public function execute($SQL, $BIND_PARAMS )
    {
        if( $STMT = $this->Connection->prepare( $SQL ) )
        {

            $tmp = array();
            if( is_array($BIND_PARAMS) && $BIND_PARAMS != null )
            {
                
                foreach($BIND_PARAMS as $key => $value)
                    $tmp[$key] = &$BIND_PARAMS[$key];
                call_user_func_array(array($STMT, 'bind_param'), $tmp);
            }

            
            if( $STMT->execute() )
            {
                $ResultSet = $STMT->get_result();
                return $ResultSet;
            }
            else
            {
                echo "Erro en execute()";
            }
            $STMT->close();
        }
        else
        {
            echo "Fallo al prepara";
        }
    }

    public function __destruct()
    {
        if($this->Connection != null )
        {
            $this->Connection->close();
        }
    }
}