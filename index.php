<?php
require_once("FileSystem.php");

//FileSystem::createFile("notas2.txt");
//FileSystem::writeFile("notas2.txt", "", "teste de anotação 2");

FileSystem::createFile("app.log", "logs");
FileSystem::writeFile("app.log", "logs", "Log gerado com sucesso");