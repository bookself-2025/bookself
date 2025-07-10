// 새롭게 책을 등록할 경우
type AddBookType = {
    coverImage: string
    isbn: string
    title: string
    author: string
    pressName: string
    releaseDate: string
    price: string
    own: number
    read: string
}

// 프론트에서 보이는 가장 일반적인 책 타입
type BookType = {
    id: number
    author: string
    currency: string
    isbn: string
    own: OwnType
    pressName: string
    price: string
    rate: number
    read: ReadType
    releaseDate: string
    thumbnailId: number
    title: string

    // read-only
    coverImage: { [key: string]: ImageType }
    formattedPrice: string
}

// 알라딘 API 상품 조회 결과 타입
type GetBookInfoType = {
    author: string
    cover: string
    isbn: string
    pressName: string
    price: number
    releaseDate: string
    title: string
}

type ImageType = {
    url: string,
    width: number,
    height: number,
}

type OwnType =
    | 'own-by-me'
    | 'own-borrowed'
    | 'own-want-to-sell'
    | 'not-own'
    | number

type ReadType =
    | 'not-read'
    | 'reading'
    | 'read'

type StateType = {
    book?: BookType
    ownTerms: { [key: string]: number }
    siteMeta: {
        baseUrl: string
        title: string
        version: string
    }
}

export type{
    AddBookType,
    BookType,
    GetBookInfoType,
    ImageType,
    OwnType,
    ReadType,
    StateType,
}
