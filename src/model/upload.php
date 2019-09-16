<?php


class Upload
{
  private $caminho;
  private $caminhoRelativo;
  private $file;
  function __construct($file)
  {
    // $baseDir = dirname(__FILE__) . '/../images/';
    // $baseDir = dirname(__FILE__) . '/../images/';
    $baseDir = '/var/www/site/images/';
    if (!is_dir($baseDir)) {
      mkdir($baseDir);
    }
    // $this->caminho = $baseDir . time() . "_" . $file["name"];
    $this->caminhoRelativo = time() . '_' . basename($file["name"]);
    $this->caminho = $baseDir . $this->caminhoRelativo;
    // if (!getimagesize($file["tmp_name"])) {
    //   throw new Exception("Arquivo não suportado");
    // }
    if ($file["size"] > 8000 * 1024) {
      throw new Exception("Arquivo muito grande");
    }
    if (!is_writable($baseDir)) {
      throw new Exception("Permissão negada em " . dirname($this->caminho));
    }
    $this->file = $file;
  }
  public function getCaminho()
  {
    if (!move_uploaded_file($this->file["tmp_name"], $this->caminho)) {
      throw new Exception($this->caminho);
    }
    return $this->caminhoRelativo;
  }
  public static function getCaminhoExterno($related)
  {
    return !empty($related) ? "images/$related"  : null;
  }
}
