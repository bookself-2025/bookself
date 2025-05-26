type BookType = {
    id: number
    author: string
    coverImage: { [key: string]: ImageType }
    isbn: string
    own: OwnType
    pressName: string
    price: string
    releaseDate: string
    rate: number
    read: ReadType
    title: string
}

type ImageType = {
    url: string,
    width: number,
    height: number,
}

type OwnType = string

type ReadType = string

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
