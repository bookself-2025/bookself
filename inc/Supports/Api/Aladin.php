<?php

namespace Bookself\Bookself\Supports\Api;

use Bojaghi\Contract\Support;
use Exception;

/**
 * 알라딘 API
 *
 * @link https://docs.google.com/document/d/1mX-WxuoGs8Hy-QalhHcvuV17n50uGI2Sg_GHofgiePE/edit?tab=t.0
 */
readonly class Aladin implements Support
{
    public function __construct(private string $ttbKey)
    {
    }

    /**
     * 상품 조회 API
     *
     * @param string $isbn ISBN 코드 13자리
     *
     * @return array{
     *     author: string,
     *     cover: string,
     *     isbn: string,
     *     pressName: string,
     *     price: string,
     *     title: string,
     * }
     *
     * @throws Exception
     */
    public function getProductInfo(string $isbn): array
    {
        $url = add_query_arg(
            [
                'Cover'      => 'Big',
                'TTBKey'     => $this->ttbKey,
                'itemId'     => $isbn,
                'itemIdType' => 'ISBN',
                'output'     => 'JS',
                'Version'    => '20131101',
            ],
            'http://www.aladin.co.kr/ttb/api/ItemLookUp.aspx',
        );

        $r = wp_remote_get($url);

        $code = wp_remote_retrieve_response_code($r);
        $body = wp_remote_retrieve_body($r);

        if (200 !== $code) {
            throw new Exception($body, $code);
        }

        $data = json_decode($body, true);

        $item = $data['item'][0] ?? null;
        if (!$item) {
            throw new Exception('item not found', 404);
        }

        return [
            'author'      => $item['author'],
            'cover'       => $item['cover'],
            'description' => $item['description'],
            'isbn'        => $item['isbn13'],
            'pressName'   => $item['publisher'],
            'price'       => $item['priceStandard'],
            'releaseDate' => $item['pubDate'],
            'title'       => $item['title'],
        ];
    }
}