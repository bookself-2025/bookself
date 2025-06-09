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

type ImageType = {
    url: string,
    width: number,
    height: number,
}

type OwnType =
    | 'own'
    | 'borrow'
    | 'sold'
    | 'wish'

type ReadType =
    | 'not-read'
    | 'reading'
    | 'read'

type StateType = {
    book?: BookType
}

export type{
    BookType,
    ImageType,
    OwnType,
    ReadType,
    StateType,
}
