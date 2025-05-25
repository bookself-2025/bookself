import useBooks from '@/v1/components/hooks/useBooks'
import Book from '@/v1/components/parts/book'
import {cn} from '@/v1/libs/utils'

export default function Books() {
    const {data, isLoading} = useBooks()

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
        <div className={cn('books-list')}>
            <h1 className={cn('text-2xl font-bold mt-4')}>
                내 책
            </h1>
            <div className="flex flex-row flex-wrap">
                {data.map((book) => (<Book key={book.id} book={book} />))}
            </div>
        </div>
    )
}
