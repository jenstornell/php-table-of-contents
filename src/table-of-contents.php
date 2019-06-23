<?php
namespace JensTornell;

class Toc {
  private $headings;

  // Set ID to headings. Now the headings will be linkable with anchor hash
  public function headings($html) {
    $this->headings = $this->getHeadings($html);

    foreach($this->headings[1] as $item) {
      if(strpos($item, ' id=') !== false) continue;

      $html = str_replace(
        '>' . $item . '</h',
        ' id="' . $this->slugify($item) . '">' . $item . '</h',
        $html
      );
    }
    return $html;
  }

  // Generate table of content nested list
  public function list($html) {
    $markdown = '';
    $out = '';
    $old_depth = 0;

    if(isset($this->headings)) {
      $matches = $this->headings;
    } else {
      $matches = $this->getHeadings($html);
    }

    foreach($matches[1] as $key => $item) {
      $depth = substr($matches[0][$key], 2, 1) - 2;
      
      if($old_depth > $depth) {
        $out .= "</ol>\n";
      } elseif($old_depth < $depth) {
        $out .=  "<li>\n";
        $out .= "<ol>\n";
      }
      $out .= '<li><span></span><a href="#' . $this->slugify($item) . '">' . $item . '</a></li>' . "\n";
      $old_depth = $depth;
    }

    return "<ol>\n" . $out . "</ol>\n\n";
  }

  // Get headings from html with regex
  private function getHeadings($html) {
    preg_match_all('|<h[^>]+>(.*)</h[^>]+>|iU', $html, $matches);
    return $matches;
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