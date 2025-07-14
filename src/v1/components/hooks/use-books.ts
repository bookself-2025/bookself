import ApiV1 from '@/v1/api'
import useBookselfContext from '@/v1/libs/context'
import queryKeys from '@/v1/libs/query-keys'
import {useQuery} from '@tanstack/react-query'

function useBooks() {
    const {
        state: {
            filter
        },
    } = useBookselfContext()

    return useQuery({
        queryKey: queryKeys.books(filter),
        queryFn: () => ApiV1.Book.query(filter),
    })
}

export default useBooks
