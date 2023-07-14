<?php
class Database {
    private $host = '127.0.0.1';
    private $db   = 'ticketing';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    private $dsn;
    private $opt;
    private $pdo;

    public function __construct() {
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $this->opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $this->opt);
    }

    public function getPDO() {
        return $this->pdo;
    }
}
?>
