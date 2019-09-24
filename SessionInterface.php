<?php

interface SessionInterface
{
    public function storeSession($name, $content);
    public function updateSession($name, $content);
    public function readSession($name);
}
