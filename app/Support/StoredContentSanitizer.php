<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\File;

class StoredContentSanitizer
{
    protected const ALLOWED_HTML = [
        'p',
        'br',
        'hr',
        'div',
        'span',
        'b',
        'strong',
        'i',
        'em',
        'u',
        's',
        'small',
        'mark',
        'sub',
        'sup',
        'blockquote',
        'pre',
        'code',
        'ul',
        'ol',
        'li',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'a[href|title|target|rel]',
        'img[src|alt|title|width|height]',
        'figure',
        'figcaption',
        'table',
        'thead',
        'tbody',
        'tfoot',
        'tr',
        'th[colspan|rowspan|scope]',
        'td[colspan|rowspan]',
        'time[datetime]',
    ];

    protected const NORMALIZED_BLOCK_TAGS = [
        'section',
        'article',
        'header',
        'footer',
        'main',
        'aside',
        'nav',
    ];

    public static function clean(?string $html): ?string
    {
        $prepared = HtmlSanitizer::prepare($html);

        if ($prepared === null) {
            return null;
        }

        $normalized = self::normalizeStructuralTags($prepared);
        $trimmed = trim($normalized);

        if ($trimmed === '') {
            return '';
        }

        File::ensureDirectoryExists(storage_path('app/purifier'));

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', storage_path('app/purifier'));
        $config->set('HTML.Allowed', implode(',', self::ALLOWED_HTML));
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('Attr.EnableID', false);
        $config->set('CSS.AllowTricky', false);
        $config->set('CSS.Trusted', false);
        $config->set('HTML.SafeIframe', false);
        $config->set('HTML.SafeObject', false);
        $config->set('HTML.SafeEmbed', false);
        $config->set('HTML.Nofollow', true);
        $config->set('URI.DisableExternalResources', false);
        $config->set('URI.DisableResources', false);
        $config->set('AutoFormat.AutoParagraph', false);
        $config->set('AutoFormat.Linkify', false);

        $definition = $config->getHTMLDefinition(true);

        if ($definition) {
            if (! isset($definition->infoElement['figure'])) {
                $definition->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
            }

            if (! isset($definition->infoElement['figcaption'])) {
                $definition->addElement('figcaption', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['mark'])) {
                $definition->addElement('mark', 'Inline', 'Inline', 'Common');
            }

            if (! isset($definition->infoElement['time'])) {
                $definition->addElement('time', 'Inline', 'Inline', 'Common', ['datetime' => 'Text']);
            }
        }

        return (new HTMLPurifier($config))->purify($trimmed);
    }

    protected static function normalizeStructuralTags(string $html): string
    {
        if (! class_exists(\DOMDocument::class)) {
            return $html;
        }

        $internalErrors = libxml_use_internal_errors(true);

        try {
            $document = new \DOMDocument('1.0', 'UTF-8');
            $wrappedHtml = '<div>'.$html.'</div>';
            $loaded = $document->loadHTML(
                mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            if (! $loaded) {
                return $html;
            }

            foreach (self::NORMALIZED_BLOCK_TAGS as $tagName) {
                while (true) {
                    $nodes = $document->getElementsByTagName($tagName);

                    if ($nodes->length === 0) {
                        break;
                    }

                    $node = $nodes->item(0);

                    if (! $node || ! $node->parentNode) {
                        break;
                    }

                    $replacement = $document->createElement('div');

                    if ($node->hasAttributes()) {
                        foreach ($node->attributes as $attribute) {
                            $replacement->setAttribute($attribute->nodeName, $attribute->nodeValue ?? '');
                        }
                    }

                    while ($node->firstChild) {
                        $replacement->appendChild($node->firstChild);
                    }

                    $node->parentNode->replaceChild($replacement, $node);
                }
            }

            $root = $document->documentElement;

            if (! $root) {
                return $html;
            }

            $normalized = '';

            foreach ($root->childNodes as $childNode) {
                $normalized .= $document->saveHTML($childNode);
            }

            return trim($normalized);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($internalErrors);
        }
    }
}
