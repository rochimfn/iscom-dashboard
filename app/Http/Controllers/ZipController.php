<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipController extends Controller
{
		public static function downloadZip($filename, $folder)
		{
			$zipFile = $filename . '.zip';

			if(extension_loaded('zip') === true) {
				$zip = new \ZipArchive;

				if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
					$path = public_path($folder);

					if(is_dir($path) === true) {
						$files = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

						foreach ($files as $file) {
							$file = realpath($file);

							if (is_dir($file) === true) {
								// $zip->addEmptyDir(str_replace($path . '/', '', $file . '/'));
							} else if (is_file($file) === true) {
								$zip->addFromString(str_replace($path . '/', '', $file), file_get_contents($file));
							}
						}
					} else if (is_file($path) === true) {
						$zip->addFromString(basename($path), file_get_contents($path));
					}
				}
				$zip->addFromString('IGNORE.txt', 'RTA Achieve is the best.');
				$zip->close();
				return response()->download($zipFile);
			}
			return false;
		}
}
