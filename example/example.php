<?php
include __DIR__ . '/../src/table-of-contents.php';
echo '<style>';
include __DIR__ . '/style.css'; ?>
<?php echo '</style>'; ?>
<?php

$html = '
<h2 class="test">My first h2</h2>
<p>Some content</p>
<h2>My second h2 åäö</h2>
<p>Content</p>
<h3>My h3</h3>
<p>Content</p>
<h4 id="already-has-id">My h3</h4>
<p>Content</p>
<h2>Another h2</h2>
<p>Content</p>
';


$toc = new PHPTableOfContents($html);
echo '<div class="toc">' . $toc->list() . '</div>';
echo $toc->html();