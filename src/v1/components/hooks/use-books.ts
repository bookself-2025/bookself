import ApiV1 from '@/v1/api'
import queryKeys from '@/v1/libs/query-keys'
import {useQuery} from '@tanstack/react-query'

function useBooks() {
    return useQuery({
        queryKey: queryKeys.books(),
        queryFn: () => ApiV1.Book.query(),
    })
}

export default useBooks
