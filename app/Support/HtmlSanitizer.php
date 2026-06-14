<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\File;

class HtmlSanitizer
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
        'section',
        'article',
        'header',
        'footer',
        'main',
        'aside',
        'nav',
        'details',
        'summary',
        'table',
        'thead',
        'tbody',
        'tfoot',
        'tr',
        'th[colspan|rowspan|scope]',
        'td[colspan|rowspan]',
        'time[datetime]',
    ];

    protected const DISALLOWED_PREPARE_TAGS = [
        'script',
        'style',
        'iframe',
        'object',
        'embed',
        'form',
        'input',
        'button',
        'textarea',
        'select',
        'option',
        'meta',
        'link',
        'base',
    ];

    public static function prepare(?string $html): ?string
    {
        if ($html === null) {
            return null;
        }

        $prepared = trim(str_replace("\xc2\xa0", ' ', $html));

        if ($prepared === '' || in_array($prepared, ['<p><br></p>', '<div><br></div>'], true)) {
            return '';
        }

        if (! class_exists(\DOMDocument::class)) {
            return $prepared;
        }

        $internalErrors = libxml_use_internal_errors(true);

        try {
            $document = new \DOMDocument('1.0', 'UTF-8');
            $wrappedHtml = '<div>'.$prepared.'</div>';
            $loaded = $document->loadHTML(
                mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            if (! $loaded) {
                return $prepared;
            }

            $xpath = new \DOMXPath($document);

            foreach ($xpath->query('//comment()') ?: [] as $commentNode) {
                $commentNode->parentNode?->removeChild($commentNode);
            }

            foreach (self::DISALLOWED_PREPARE_TAGS as $tagName) {
                foreach ($document->getElementsByTagName($tagName) as $node) {
                    $node->parentNode?->removeChild($node);
                }
            }

            foreach ($document->getElementsByTagName('h1') as $heading) {
                $replacement = $document->createElement('h2');

                while ($heading->firstChild) {
                    $replacement->appendChild($heading->firstChild);
                }

                $heading->parentNode?->replaceChild($replacement, $heading);
            }

            foreach ($xpath->query('//p[not(normalize-space()) and not(*)] | //div[not(normalize-space()) and not(*)]') ?: [] as $emptyNode) {
                $emptyNode->parentNode?->removeChild($emptyNode);
            }

            $root = $document->documentElement;

            if (! $root) {
                return $prepared;
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

    public static function clean(?string $html): ?string
    {
        $html = self::prepare($html);

        if ($html === null) {
            return null;
        }

        $trimmed = trim($html);

        if ($trimmed === '') {
            return '';
        }

        File::ensureDirectoryExists(storage_path('app/purifier'));

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', storage_path('app/purifier'));
        $config->set('HTML.DefinitionID', 'satu-desa-html-sanitizer');
        $config->set('HTML.DefinitionRev', 1);
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

        $definition = $config->maybeGetRawHTMLDefinition();

        if ($definition) {
            if (! isset($definition->infoElement['figure'])) {
                $definition->addElement('figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common');
            }

            if (! isset($definition->infoElement['figcaption'])) {
                $definition->addElement('figcaption', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['section'])) {
                $definition->addElement('section', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['article'])) {
                $definition->addElement('article', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['header'])) {
                $definition->addElement('header', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['footer'])) {
                $definition->addElement('footer', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['main'])) {
                $definition->addElement('main', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['aside'])) {
                $definition->addElement('aside', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['nav'])) {
                $definition->addElement('nav', 'Block', 'Flow', 'Common');
            }

            if (! isset($definition->infoElement['details'])) {
                $definition->addElement('details', 'Block', 'Optional: summary, Flow', 'Common');
            }

            if (! isset($definition->infoElement['summary'])) {
                $definition->addElement('summary', 'Block', 'Inline', 'Common');
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
}
