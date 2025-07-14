import useBooks from '@/v1/components/hooks/use-books'
import Book from '@/v1/components/parts/book'
import ListFilters from '@/v1/components/parts/list-filters'
import Pagination from '@/v1/components/parts/pagination'
import useBookselfContext from '@/v1/libs/context'
import {ActionType} from '@/v1/libs/reducer'
import {BookType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'

export default function Books() {
    const {data, isLoading, isSuccess} = useBooks()

    const {
        dispatch,
        state: {
            filter,
        },
    } = useBookselfContext()

    if (!data) {
        return null
    }

    const {
        totalPages,
        items: books,
    } = data

    return (
        <div
            className={cn(
                'books-list', 'px-6',
                'max-w-full sm:max-w-[720px] mx-auto',
            )}
        >
            <ListFilters className="mt-4 mb-12 sm:mb-8" />
            <div
                className={cn(
                    'mt-6 px-2',
                    'grid grid-cols-1 sm:grid-cols-2',
                    'gap-x-2 gap-y-8 md:gap-x-6',
                )}
            >
                {isLoading && (<>불러오는 중</>)}
                {0 === books.length && (<div>등록된 책이 없습니다</div>)}
                {isSuccess && books.map((book) => (
                    <Book
                        key={book.id}
                        book={book}
                        onClickBook={(book: BookType) => dispatch({type: ActionType.SET_BOOK, payload: book})}
                    />
                ))}
            </div>
            <div className="w-full text-center">
                <Pagination
                    className="mt-8 mb-4"
                    onClickPage={(page) => dispatch({
                        type: ActionType.SET_FILTER,
                        payload: {
                            ...filter,
                            page,
                        },
                    })}
                    page={filter.page ?? 1}
                    range={getRange(filter.page ?? 1, totalPages, 5)}
                />
            </div>
        </div>
    )
}

function getRange(page: number, totalPages: number, size: number): [number, number] {
    if (!page) {
        return [0, 0]
    }

    const section = Math.floor(page / size),
        begin = section * size + 1,
        end = Math.min(totalPages, begin + size - 1)

    return [begin, end]
}
