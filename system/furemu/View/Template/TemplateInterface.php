<?php

namespace Yume\Fure\View\Template;

use Yume\Fure\AoE;

/*
 * TemplateInterface
 *
 * @package Yume\Fure\View\Template
 */
interface TemplateInterface
{
    public function assign( Array | AoE\Data $data ): Static;
    public function getVars(): Array;
    public function getView(): String;
    public function getViewFile(): String;
    public function getViewParsed(): String;
    public function hasCached(): Bool;
    public function hasParsed(): Bool;
    public function render(): Void;
}

?>