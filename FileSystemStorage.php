<?php
//Backend to store Session in File. Each Session gets is own File.
include_once "SessionInterface.php";    //Interface for the Backend Operation

class FileSystemStorage implements SessionInterface
{
    private $sessionPath;

    public function __construct()
    {
        $this->sessionPath = "/tmp/tmp.e6TAKlmFVl";  // Store the sessions in case of FileSystemStorage
    }

    public function storeSession($name, $content)
    {
        file_put_contents("$this->sessionPath/$name", $content);
    }

    public function updateSession($name, $content)
    {
        file_put_contents("$this->sessionPath/$name", $content);
    }

    public function readSession($name)
    {
        return file_get_contents("$this->sessionPath/$name");
    }
}
