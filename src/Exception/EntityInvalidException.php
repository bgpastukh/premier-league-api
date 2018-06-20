<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 02:00
 */

namespace App\Exception;

use Throwable;

/**
 * Class EntityInvalidException
 * @package App\Exception
 */
class EntityInvalidException extends \Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}