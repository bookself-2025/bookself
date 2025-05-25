let baseUrl: string = '',
    nonce: string = ''

function initApi(_baseUrl: string, _nonce: string): void {
    baseUrl = _baseUrl
    nonce = _nonce
}

export {
    initApi,
    baseUrl,
    nonce,
}
