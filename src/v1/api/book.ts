import {BookType} from '@/v1/libs/types'
import {baseUrl, nonce, request} from './init'

async function _query() {
    const endpoint = `${baseUrl}/books`

    const r = await fetch(endpoint, {
        method: 'GET',
        headers: {
            'Origin': location.origin,
            'X-WP-Nonce': nonce,
        },
    })

    return await r.json() as BookType[]
}

async function _update(book: BookType) {
    return await request(`${baseUrl}/book/${book.id}`, {
        method: 'POST',
        body: JSON.stringify({
            author: book.author,
            currency: book.currency,
            isbn: book.isbn,
            own: book.own,
            pressName: book.pressName,
            price: book.price,
            rate: book.rate,
            read: book.read,
            releaseDate: book.releaseDate,
            thumbnailId: book.thumbnailId,
            title: book.title,
        }),
    }) as BookType
}

export {
    _query,
    _update,
}
