<?php
include_once 'conf/conf.inc.php';
include_once 'db/db.inc.php';
$db = new RscPDO(DSN, DBUSER, DBPASSWORD);

$query['query'] = 'SELECT * FROM report;';
$result = $db->getArrayFromSelect($query);
$error = $db->errors();

if (!$error)
{
    $xml = new DOMDocument('1.0', 'utf-8');

    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;

    $urlset = $xml->createElement('urlset');
    $xml->appendChild($urlset);
    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $urlset->setAttribute('xsi:schemeLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

    $first_url = $xml->createElement('url');
    $first_loc = $xml->createElement('loc', 'http://intel.rscmme.com');
    $first_date = $xml->createElement('lastmod', '2016-06-20');
    $first_freq = $xml->createElement('changefreq', 'weekly');
    $first_priority = $xml->createElement('priority', '1.0');

    $first_url->appendChild($first_loc);
    $first_url->appendChild($first_date);
    $first_url->appendChild($first_freq);
    $first_url->appendChild($first_priority);

    $urlset->appendChild($first_url);

    foreach ($result as $record)
    {
        $pdf_link = 'http://intel.rscmme.com/report/'.$record['url_name'];
        $url = $xml->createElement('url');

        $loc = $xml->createElement('loc', htmlentities($pdf_link));
        //$date = $xml->createElement('lastmod', $record['date']);
	$date = $xml->createElement('lastmod', date_format(date_create($record['date']), 'Y-m-d'));
        $freq = $xml->createElement('changefreq', 'monthly');
        $priority = $xml->createElement('priority', '0.5');

        $url->appendChild($loc);
        $url->appendChild($date);
        $url->appendChild($freq);
        $url->appendChild($priority);

        $urlset->appendChild($url);

    }
    echo ($xml->save('sitemap.xml'))? 'successfully created file!' : 'error';

    exit;
}
else
{
    print_r($error);
}

