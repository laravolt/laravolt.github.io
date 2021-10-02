<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use TightenCo\Jigsaw\Collection\CollectionItem;
use TightenCo\Jigsaw\Jigsaw;
use Wa72\HtmlPageDom\HtmlPageCrawler;

class DecorateContent
{
    public function handle(Jigsaw $jigsaw)
    {
        echo PHP_EOL;
        echo "DECORATE CONTENT";
        echo PHP_EOL;

        $jigsaw->getCollections()->each->map(function (CollectionItem $page) use ($jigsaw) {
            $content = $page->getContent();

            $content = HtmlPageCrawler::create($content);
            $counter = ['h2' => 0, 'h3' => 0, 'h4' => 0];
            $content->filter('h2,h3,h4')->each(function ($node) use (&$counter, $page) {
                try {
                    $tag = $node->nodeName();
                    $counter[$tag]++;
                    $title = $slug = Str::slug($node->getInnerHtml());
                    switch ($tag) {
                        case 'h2':
                            $counter['h3'] = $counter['h4'] = 0;
                            $slug = sprintf('%s-%s', $counter['h2'], $title);
                            break;
                        case 'h3':
                            $counter['h4'] = 0;
                            $slug = sprintf('%s-%s-%s', $counter['h2'], $counter['h3'], $title);
                            break;
                        case 'h4':
                            $slug = sprintf('%s-%s-%s-%s', $counter['h2'], $counter['h3'], $counter['h4'], $title);
                            break;
                    }
                    $node->setAttribute('id', $slug)->wrapInner("<a href='#{$slug}'>");
                } catch (\TypeError $e) {
                    dump($page->getUrl());
                }
            });

            $page->content = $content->saveHTML();
        });
    }
}
