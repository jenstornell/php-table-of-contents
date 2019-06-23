<?php
class PHPTableOfContents {
  private $headings;
  private $html;

  public function __construct($html) {
    $this->html = $html;
    $this->setHeadings();
  }

  // Html
  public function html() {
    $html = $this->html;
    $matches = $this->headings;

    foreach($matches[1] as $index => $item) {
      $html = str_replace(
        '>' . $item . '</h',
        ' id="' . $matches[2][$index] . '">' . $item . '</h',
        $html
      );
    }
    return $html;
  }

  // Generate table of content nested list
  public function list() {
    $out = '';
    $old_depth = 0;
    $matches = $this->headings;

    foreach($matches[1] as $key => $item) {
      $depth = substr($matches[0][$key], 2, 1) - 2;
      
      if($old_depth > $depth) {
        $out .= "</ol>\n";
      } elseif($old_depth < $depth) {
        $out .=  "<li>\n";
        $out .= "<ol>\n";
      }
      $out .= sprintf("
        <li>
          <span></span>
          <a href='#%s'>%s</a>
        </li>
      ", $matches[2][$key], $item);
      $old_depth = $depth;
    }

    return "<ol>\n" . $out . "\n</ol>\n\n";
  }

  // Set headings
  private function setHeadings() {
    preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $this->html, $matches);

    $slugs = [];
    foreach($matches[1] as $item) {
      $slugs[] = $this->slugify($item);
    }

    $this->headings = $matches;
    $this->headings[2] = $slugs;
  }

  // https://gist.github.com/james2doyle/9158349
  function slugify($string, $replace = array(), $delimiter = '-') {
    if (!extension_loaded('iconv')) {
      throw new Exception('iconv module not loaded');
    }
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    if (!empty($replace)) {
      $clean = str_replace((array) $replace, ' ', $clean);
    }
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    
    setlocale(LC_ALL, $oldLocale);
    return $clean;
  }
}