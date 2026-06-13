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

    public static function clean(?string $html): ?string
    {
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
