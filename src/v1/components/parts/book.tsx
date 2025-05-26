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
                'w-full md:w-96',
                className,
            )}
            ref={ref}
            {...rest}
        >
            <figure>
                <BookImage
                    alt={`${book.title}의 커버 이미지`}
                    images={book.coverImage}
                />
            </figure>
            <div className="card-body">
                <h2 className="card-title">
                    {book.title}
                </h2>
                <p className="">
                    저자: {book.author} 출판사: {book.pressName}
                </p>
                <div className="card-actions justify-end mt-8">
                    <button
                        className="btn btn-primary"
                        onClick={() => onClickBook && onClickBook(book)}
                    >
                        자세히 보기
                    </button>
                </div>
            </div>
        </div>
    )
})
Book.displayName = 'Book'

export default Book

