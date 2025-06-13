import {AddBookType, BookType, GetBookInfoType} from '@/v1/libs/types'
import {baseUrl, nonce, request} from './init'

async function _add(book: AddBookType) {
    return await request(`${baseUrl}/books`, {
        method: 'POST',
        body: JSON.stringify(book),
    }) as BookType
}

async function _getBookInfo(isbn: string) {
    return await request(`${baseUrl}/book-info/${isbn}`) as GetBookInfoType
}

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
    _add,
    _getBookInfo,
    _query,
    _update,
}
