<?php

use Bojaghi\Continy\Continy;
use Bojaghi\Continy\ContinyException;
use Bojaghi\Continy\ContinyFactory;

/**
 * Wrapper function
 *
 * @return Continy
 * @throws ContinyException
 */
function bookself(): Continy
{
    static $continy = null;

    if (is_null($continy)) {
        $continy = ContinyFactory::create(dirname(__DIR__) . '/conf/continy.php');
    }

    return $continy;
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
    try {
        $instance = bookself()->get($id, $constructorCall);
    } catch (ContinyException $e) {
        $instance = null;
    }

    return $instance;
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
    try {
        $container = bookself();
        $instance  = $container->get($id);
        return $container->call([$instance, $method], $args);
    } catch (ContinyException $e) {
        wp_die($e->getMessage());
    }
}
