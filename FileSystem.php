<?php

class FileSystem
{
	public static function createDir($dirname)
	{
		try {
			if (!is_dir($dirname)) {
			mkdir($dirname);
			echo "Diretório $dirname criado.";
			self::log("Diretório $dirname criado");
		}	
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());	
		}		
	}

	public static function removeDir($dirname)
	{
		try {
			rmdir($dirname);
			self::log("Diretório $dirname removido");	
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());
		}

		
	}

	public static function createFile($filename, $dirname = "")
	{
		try {
			if($dirname != "")
			{
				self::createDir($dirname);
				$filepath = $dirname.DIRECTORY_SEPARATOR.$filename;
				$file = fopen($filepath, "w+");
				fclose($file);
				self::log("Arquivo $filepath criado");
			} else {
				$file = fopen($filename, "w+");
				fclose($file);
				self::log("Arquivo $filename criado");
			}
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());
		}

		
	}

	public static function removeFile($filename, $dirname = "")
	{
		try {
			if($dirname!= "")
			{
				$filepath = $dirname.DIRECTORY_SEPARATOR.$filename;
				unlink($filepath);
				self::log("Arquivo $filepath excluido");
			} else {
				unlink($filename);
				self::log("Arquivo $filename excluido");
			}					
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());		
		}		
	}

	public static function writeFile($filename, $dirname = "", $content = "")
	{
		try {
			if($dirname != "")
			{
				self::createDir($dirname);
				$path = $dirname.DIRECTORY_SEPARATOR.$filename;
				$file = fopen($path, "a+");
				fwrite($file, $content."\n");
				fclose($file);
				self::log("Arquivo $path editado com sucesso");
			} else {
				$file = fopen($filename, "a+");
				fwrite($file, $content."\n");
				fclose($file);
				self::log("Arquivo $filename editado com sucesso");
			}
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());
		}
	}

	public static function importFromCSV($csvfile)
	{
		try {
			$file = fopen($csvfile, "r");

			$headers = explode(",", fgets($file));

			$data = [];

			while ($row = fgets($file)) {
				$rowdata = explode(",", $row);

				$linha = [];

				for ($i = 0; $i < count($headers); $i++) { 
					$linha[$headers[$i]] = $rowdata[$i];
						
				}
			
				array_push($data, $linha);
		}			
			self::log("Arquivo $csvfile importado com sucesso");
			echo json_encode($data);
		} catch (Exception $e) {
			self::log("Erro: ".$e->getMessage() . " - " . $e->getFile());
		}
	}

	public static function log($logmessage)
	{
		$log = fopen("log.txt", "a+");
		if($logmessage != "")
		{
			fwrite($log, date("d/m/Y h:i:s"). "- $logmessage\r\n");
			fclose($log);
		}
	}
}