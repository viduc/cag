<?php
/**
 * This file is part of the Api package.
 *
 * (c) GammaSoftware <http://www.winlassie.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cag\Exceptions;

/**
 * 100 -> 'Folder '.$folder->name.' already exist in folder list'.
 * 101 -> 'Folder '.$folder->name.' not exist in folder list'.
 * 102 -> 'File '.$file->name.' already exist in file list'.
 * 103 -> 'File '.$file->name.' not exist in file list'.
 */
class StructureModelException extends ExceptionAbstract
{

}
