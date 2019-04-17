<?php
include __DIR__ . '/toc.php';

?>
<style>
<?php include __DIR__ . '/style.css'; ?>
</style>
<?php

$text = '
<h2 id="asd">My first h2</h2>
<p>Some content</p>
<h2>My second h2 åäö</h2>
<p>Content</p>
<h3>My h3</h3>
<p>Content</p>
<h4>My h3</h4>
<p>Content</p>
<h2>Another h2</h2>
<p>Content</p>
';

$toc = new TOC();
$text = $toc->anchorHeadings($text);
?>
<div class="toc">
  <?= $toc->list($text); ?>
</div>

<?= $text; ?>