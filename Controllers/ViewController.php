<?php
class View
{
  private $title;
  private $content;
  private $style;
  private $directory = "Elements/";
  private $templateExtension = ".html";
  private $styleExtension = ".css";
  private $templateBase = "Templates/template.php";

  public function loadHtml($fileName)
  {
    $html = "";
    $html .= "<div class='alternate-color' id='" . str_replace($this->templateExtension, "", $fileName) . "'>";
    $html .= file_get_contents($this->directory . $fileName);
    $html .= "</div>";

    return $html;
  }
  public function loadCss($filename) {
    //<link rel="stylesheet" href="/css/master.css">
    $css = "<link rel='stylesheet' href='" . $this->directory . $filename ."'>";
    return $css;
  }
  public function renderPage($title)
  {
    $template = file_get_contents($this->directory . $this->templateBase);
    $css = "";
    $html = "";
    $directoryList = scandir($this->directory);
    foreach ($directoryList as $key => $value) {
      if(strpos($value, $this->templateExtension) !== False) {
        $html .= $this->loadHtml($value);
      }
      if(strpos($value, $this->styleExtension) !== False) {
        $css .= $this->loadCss($value);
      }
    }
    $template = str_replace('%%TITLE%%', $title, $template);
    $template = str_replace('%%CONTENT%%', $html, $template);
    $template = str_replace('%%STYLE%%', $css, $template);
    $template = str_replace('%%MENU%%', file_get_contents($this->directory . "Templates/menu.php"), $template);

    echo $template;
  }
}
