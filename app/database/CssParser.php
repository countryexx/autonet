<?php namespace Maatwebsite\Excel\Parsers;

use DOMDocument;
use Illuminate\Support\Facades\URL;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 *
 * LaravelExcel CSS Parser
 *
 * @category   Laravel Excel
 * @version    1.0.0
 * @package    maatwebsite/excel
 * @copyright  Copyright (c) 2013 - 2014 Maatwebsite (http://www.maatwebsite.nl)
 * @author     Maatwebsite <info@maatwebsite.nl>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class CssParser {

    /**
     * @var CssToInlineStyles
     */
    protected $cssInliner;

    /**
     * DOM xml
     * @var \SimpleXMLElement
     */
    protected $xml;

    /**
     * Style sheet links
     * @var array
     */
    protected $links = array();

    /**
     * Construct the css parser
     * @param CssToInlineStyles $cssInliner
     */
    public function __construct(CssToInlineStyles $cssInliner)
    {
        $this->cssInliner = $cssInliner;
    }

    /**
     * Transform the found css to inline styles
     */
    public function transformCssToInlineStyles($html)
    {
        // Clean-up html
        $this->cssInliner->setCleanup(true);

        // Set html
        $this->cssInliner->setHtml($html);

        // Use inline style blocks
        $this->cssInliner->setUseInlineStylesBlock(true);

        // Loop through all stylesheets
        foreach($this->links as $link)
        {
            $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
            );
            
            $css = file_get_contents($link, false, stream_context_create($arrContextOptions));
            $this->cssInliner->setCSS($css);
        }

        return $this->cssInliner->convert();
    }

    /**
     * Find the stylesheets inside the view
     * @param DOMDocument $dom
     * @return CssParser
     */
    public function findStyleSheets(DOMDocument $dom)
    {
        // Import the dom
        $this->importDom($dom);

        // Get all stylesheet tags
        $tags = $this->getStyleSheetTags();

        foreach ($tags as $node)
        {
            $this->links[] = $this->getCleanStyleSheetLink($node);
        }

        // We don't need duplicate css files
        $this->links = array_unique($this->links);

        return $this;
    }

    /**
     * Import the dom
     * @return SimpleXMLElement
     */
    protected function importDom(DOMDocument $dom)
    {
        return $this->xml = simplexml_import_dom($dom);
    }

    /**
     * Get all stylesheet tags
     * @return array
     */
    protected function getStyleSheetTags()
    {
        return $this->xml->xpath('//link[@rel="stylesheet"]');
    }

    /**
     * Get the clean link to the stylesheet
     * @param  string $node
     * @return string
     */
    protected function getCleanStyleSheetLink($node)
    {
        // Get the link
        $link = $node->attributes()->href;

        return url($link);
    }

    /**
     * Get css from link
     * @param  string $link
     * @return string|boolean
     */
    protected function getCssFromLink($link)
    {
        return file_get_contents($link);
    }
}