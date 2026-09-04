<?php

namespace SoftTechMX;

use mysqli;
use mysqli_sql_exception;
use mysqli_stmt;

class MySQLConnection
{
    private ?string $host = null;
    private ?string $password = null;
    private ?string $username = null;
    private ?string $database = null;
    
    private int $port = 3306;

    public ?mysqli $connection = null;

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setDatabase(string $database): void
    {
        $this->database = $database;
    }

    public function getDatabase(): ?string
    {
        return $this->database;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @throws mysqli_sql_exception si la conexión falla (comportamiento nativo desde PHP 8.1)
     */
    public function connect(): bool
    {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );

        return true;
    }

    /**
     * @param string $sql Query con placeholders (?)
     * @param array $params Valores a bindear, en orden
     * @throws mysqli_sql_exception si prepare() o execute() fallan
     */
    public function execute(string $sql, array $params = []): \mysqli_result|bool
    {
        $stmt = $this->connection->prepare($sql);

        $stmt->execute($params);

        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function __destruct()
    {
        $this->connection?->close();
    }
}