let baseUrl: string = '',
    nonce: string = ''

function _initApi(_baseUrl: string, _nonce: string): void {
    baseUrl = _baseUrl
    nonce = _nonce
}

async function request(endpoint: string, init?: RequestInit) {
    const r = await fetch(endpoint, {
        ...init,
        headers: {
            'Origin': location.origin,
            'Content-Type': 'application/json',
            'X-WP-Nonce': nonce,
            ...init?.headers,
        },
    })

    if (!r.ok) {
        console.error(r)
        throw new Error(`${r.status}: ${await r.json()}`)
    }

    return await r.json()
}

export {
    _initApi,
    baseUrl,
    nonce,
    request,
}
