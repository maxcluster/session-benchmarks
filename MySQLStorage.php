<?php
//Backend to store Session in MySQL.
include_once "SessionInterface.php";    //Interface for the Backend Operation

class MySQLStorage implements SessionInterface
{
    private $mysqlHost;
    private $mysqlUser;
    private $mysqlPassword;
    private $mysqlDatabase;

    public function __construct()
    {
        $this->mysqlHost = "localhost";                     // MySQL host
        $this->mysqlUser = "db-user-1";                     // MySQL user
        $this->mysqlPassword = "e3Rm0Ba6vQuCfknq9wsN";      // MySQL password
        $this->mysqlDatabase = "db-1";                      //MySQL database
    }

    public function storeSession($name, $content)
    {
        $mysqli = new mysqli($this->mysqlHost, $this->mysqlUser, $this->mysqlPassword, $this->mysqlDatabase);
        $mysqli->query("insert into sessions values ('{$name}', '{$content}', null)");
        $mysqli->close();
    }

    public function updateSession($name, $content)
    {
        $mysqli = new mysqli($this->mysqlHost, $this->mysqlUser, $this->mysqlPassword, $this->mysqlDatabase);
        $mysqli->query("update sessions set value='{$content}' where name='{$name}' ");
        $mysqli->close();
    }

    public function readSession($name)
    {
        $mysqli = new mysqli($this->mysqlHost, $this->mysqlUser, $this->mysqlPassword, $this->mysqlDatabase);
        $res = $mysqli->query("select * from sessions where name='{$name}' ");
        if($res->num_rows > 0)
        {
            $row = $res->fetch_assoc();
            return $row;
        }
        $mysqli->close();
    }
}
