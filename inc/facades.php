<?php

use Bojaghi\Continy\Continy;
use Bojaghi\Continy\ContinyFactory;
use Bojaghi\Helper\Facades;

/**
 * Wrapper function
 *
 * @return Continy
 */
function bookself(): Continy
{
    return Facades::container(dirname(__DIR__) . '/conf/continy.php', ContinyFactory::class);
}

/**
 * @template T
 * @param class-string<T> $id
 * @param bool            $constructorCall
 *
 * @return T|object|null
 */
function bookselfGet(string $id, bool $constructorCall = false)
{
    return Facades::get($id, $constructorCall);
}

/**
 * @template T
 * @param class-string<T> $id
 * @param string          $method
 * @param array|false     $args
 *
 * @return mixed
 */
function bookselfCall(string $id, string $method, array|false $args = false): mixed
{
    return Facades::call($id, $method, $args);
}
