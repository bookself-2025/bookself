import BookImage from '@/v1/components/parts/book-image'
import {BookType} from '@/v1/libs/types'

type Props = {
    book: BookType,
}

export default function SheetBookInfo(props: Props) {
    const {
        book,
    } = props

    return (
        <div>
            <BookImage images={book.coverImage} />
        </div>
    )
}
