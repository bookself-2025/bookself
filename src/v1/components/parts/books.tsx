import useBooks from '@/v1/components/hooks/useBooks'
import Book from '@/v1/components/parts/book'
import useBookselfContext from '@/v1/libs/context'
import {ActionType} from '@/v1/libs/reducer'
import {BookType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'

export default function Books() {
    const {data, isLoading} = useBooks()

    const {
        dispatch,
    } = useBookselfContext()

    if (isLoading) {
        return <>불러오는 중</>
    }

    if (!data) {
        return null
    }

    if (0 === data.length) {
        return (
            <div>등록된 책이 없습니다</div>
        )
    }

    return (
        <div className={cn('books-list', 'px-6')}>
            <h1 className={cn('text-2xl font-bold mt-4')}>
                내 책
            </h1>
            <div className={cn(
                'mt-6 px-2',
                'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
                'gap-x-2 gap-y-8 md:gap-x-6',
            )}>
                {data.map((book) => (
                    <Book
                        key={book.id}
                        book={book}
                        onClickBook={(book: BookType) => dispatch({type: ActionType.SET_BOOK, payload: book})}
                    />
                ))}
            </div>
        </div>
    )
}
