# PHP Table of Contents

*Version 1.1* - [Changelog](changelog.md)

## In short

- Convert html to a clickable table of contents
- Convert headings to support ID links
- Really small file

## Usage

```php
// Create a class instance
$toc = new JensTornell\Toc();

// Add IDs to headings to allow anchors
$html = $toc->headings($html);

// Output a table of content list
echo $toc->list($html);

// Output the content
echo $html;
```

## Donate

Donate to [DevoneraAB](https://www.paypal.me/DevoneraAB) if you want.

## License

MIT