<?php


class Database
{
    private $db;

    public function __construct($dbhost, $dbname, $dbuser, $dbpass)
    {
        $this->db = new PDO("mysql:host=$dbhost;dbname=$dbname",
                            $dbuser, $dbpass);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    private function execute(array $args)
    {
        $sql = array_shift($args);
        $stmt = $this->db->prepare($sql);
        for ($i = 0; $i < count($args); $i++) {
            $stmt->bindParam($i + 1, $args[$i]);
        }
        $stmt->execute();
        return $stmt;
    }

    public function put()
    {
        $this->execute(func_get_args());
    }

    public function fetch()
    {
        $stmt = $this->execute(func_get_args());
        return $stmt->fetch();
    }

    public function fetchAll()
    {
        $stmt = $this->execute(func_get_args());
        return $stmt->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
