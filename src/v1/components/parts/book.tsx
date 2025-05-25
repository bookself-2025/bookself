import BookImage from '@/v1/components/parts/book-image'
import {BookType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'
import {forwardRef, HTMLAttributes} from 'react'

type Props = {
    book: BookType
} & HTMLAttributes<HTMLDivElement>

const Book = forwardRef<HTMLDivElement, Props>((props: Props, ref) => {
    const {
        book,
        className,
        ...rest
    } = props

    const onClick = () => {
        alert(`${book.title}을 클릭했습니다.`)
    }

    return (
        <div
            className={cn(
                'book-item',
                'mt-2',
                'p-2',
                'w-full md:w-1/2 lg:w-1/4',
                className,
            )}
            ref={ref}
            {...rest}
        >
            <div className="flex gap-4">
                <figure className="max-w-1/2">
                    <BookImage
                        alt={`${book.title}의 커버 이미지`}
                        className={'hover:cursor-pointer'}
                        images={book.coverImage}
                        onClick={() => onClick()}
                    />
                </figure>
                <div>
                    <h2
                        className={'font-bold text-primary text-lg hover:cursor-pointer'}
                        onClick={() => onClick()}
                    >
                        {book.title}
                    </h2>
                    <p className={''}>{book.author}</p>
                </div>
            </div>
        </div>
    )
})
Book.displayName = 'Book'

export default Book

