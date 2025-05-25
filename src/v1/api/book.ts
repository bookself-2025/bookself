import {BookType} from '@/v1/libs/types'
import {baseUrl, nonce} from './init'

async function query() {
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

export {
    query,
}
