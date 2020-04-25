<?xml version = "1.0" encoding = "UTF-8"?>
<urlset xmlns = "https://www.sitemaps.org/schemas/sitemap/0.9">
<url>
<loc>https://simetricks.com</loc>
<changefreq>daily</changefreq>
<priority>1</priority>
</url>
<?php
while($item = $items->fetch()){
?>
<url>
<loc><?= DOMAIN_NAME . 'extendedcard/' . $item['id']. '/1/' .$item['slug'] ?></loc>
<lastmod><?= $item['date_update'] ;?></lastmod>
<changefreq>daily</changefreq>
<priority>0.85</priority>
</url>
<?php } ?>
<?php
while($card = $cards->fetch()){
?>
<url>
<loc><?= DOMAIN_NAME . 'card/' . $card['id']. '/1/' .$card['slug'] ?></loc>
<lastmod><?= $card['date_update'] ;?></lastmod>
<changefreq>daily</changefreq>
<priority>0.85</priority>
</url>
<?php } ?>
</urlset>
