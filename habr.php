<?php

function getHabrPost() {
    $doc = new DOMDocument();
    $doc->loadHTMLFile("https://habr.com/ru/top/");

    $xpath = new DOMXpath($doc);

    $elements = $xpath->query("/html/body/div[1]/div[3]/div/section/div[1]/div[4]/ul/li[1]/article/h2/a");


    $url = "";
    $title = "";
    if (!is_null($elements)) {
        foreach ($elements as $element) {

            $url = $element->getAttribute('href');
            $title = $element->nodeValue;
        }
    }
    
    return [$title, $url];
}