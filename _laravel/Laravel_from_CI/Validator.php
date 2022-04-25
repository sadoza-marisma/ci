<?php

/**
 * Clase que nos permitirá realizar validaciones al estilo de Laravel
 */

namespace Laravel_from_CI;

use Illuminate\Validation\Validator as LaraValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;

/**
 * Clase validator que nos permitirá crear validadores en el mismo formato que Laravel
 */
class Validator
{
	public static function make($data, $rules, $messages = [])
	{
		return new LaraValidator(self::loadTranslator(), $data, $rules, $messages);
	}


	protected static function  loadTranslator()
	{
		$filesystem = new Filesystem();
		$loader = new FileLoader(
			$filesystem,
			$path = __DIR__ . '/../resources/lang'
		);
		$loader->load('es', 'validation', 'lang');

		return new Translator($loader, 'es');
	}
}