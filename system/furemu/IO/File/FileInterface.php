<?php

namespace Yume\Kama\Obi\IO\File;

/*
 * FileInterface
 *
 * @package Yume\Kama\Obi\IO\File
 */
interface FileInterface
{
	public function read(): String;
	public function size(): Int;
	public function time(): DateTime;
	public function remove(): Bool;
	public function write(): Void;
}

?>