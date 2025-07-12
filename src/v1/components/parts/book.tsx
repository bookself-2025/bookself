import BookImage from '@/v1/components/parts/book-image'
import {BookType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'
import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement> & {
    book: BookType
    onClickBook?: (book: BookType) => void
}

const Book = forwardRef<HTMLDivElement, Props>((props: Props, ref) => {
    const {
        book,
        className,
        onClickBook,
        ...rest
    } = props

    return (
        <div
            className={cn(
                'book-item card bg-base-100 shadow-sm',
                'w-full',
                className,
            )}
            ref={ref}
            {...rest}
        >
            <figure className="">
                <a
                    href="#"
                    onClick={(e) => {
                        e.preventDefault()
                        onClickBook && onClickBook(book)
                    }}
                >
                    <BookImage
                        alt={`${book.title}의 커버 이미지`}
                        className="w-1/3 h-auto mx-auto"
                        images={book.coverImage}
                    />
                </a>
            </figure>
            <div className="card-body">
                <h2 className="card-title opacity-80">
                    <a
                        href="#"
                        onClick={(e) => {
                            e.preventDefault()
                            onClickBook && onClickBook(book)
                        }}
                    >
                        {book.title}
                    </a>
                </h2>
                <p className="opacity-75">
                    <span
                        className="inline-block max-w-2/3 overflow-hidden text-nowrap whitespace-nowrap text-ellipsis me-2"
                        title={`저자: ${book.author}`}
                    >{book.author}</span>
                    <span
                        className="inline-block max-w-2/3 overflow-hidden text-nowrap whitespace-nowrap text-ellipsis before:content-['|'] before:me-2"
                        title={`저자: ${book.pressName}`}
                    >{book.pressName}</span>
                </p>
            </div>
        </div>
    )
})
Book.displayName = 'Book'

export default Book

