<?php
class TOC {
  // Set ID to headings. Now the headings will be linkable with anchor hash
  public function anchorHeadings($html) {
    $matches = $this->getHeadings($html);

    foreach($matches[1] as $item) {
      if(strpos($item, ' id=') !== false) continue;

      $html = str_replace(
        '>' . $item . '</h',
        ' id="' . $this->slugify($item) . '">' . $item . '</h',
        $html
      );
    }
    return $html;
  }

  // Slugify
  function slugify($text) {
    $text=strip_tags($text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    setlocale(LC_ALL, 'en_US.utf8');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) { return 'n-a'; }
    return $text;
}

  // Generate table of content nested list
  public function list($html) {
    $matches = $this->getHeadings($html);
    $markdown = '';
    $out = '';
    $old_depth = 0;

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
}