<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books to scrape</title>
</head>

<body>
    <?php
    
    require 'vendor/autoload.php';
    //guzzle kütüphanesinden http istemcisi oluşturur
    $httpClient = new \GuzzleHttp\Client();
    //Belirlenen adrese get isteği yapar
    $response = $httpClient->get('https://books.toscrape.com/');
    //aldığımız yanıtın içeriğini alır ve diziye dönüştürürüz
    $htmlString = (string) $response->getBody();
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($htmlString);
    $xpath = new DOMXPath($doc);

    $titles = $xpath->evaluate('//ol[@class="row"]//li//article//h3/a');
    $extractedTitles = [];
    foreach ($titles as $title) {
        $extractedTitles[] = $title->textContent . PHP_EOL;
        echo $title->textContent . PHP_EOL;
    }
    //fiyat
    $titles = $xpath->evaluate('//ol[@class="row"]//li//article//h3/a');
    $prices = $xpath->evaluate('//ol[@class="row"]//li//article//div[@class="product_price"]//p[@class="price_color"]');
    $data = [];
    foreach ($titles as $key => $title) {
        $data[] = [
            'title' => $title->textContent,
            'price' => $prices[$key]->textContent
        ];
    }

    // Verileri JSON dosyasına yaz
    file_put_contents('veriler.json', json_encode($data));
    ?>
</body>

</html>