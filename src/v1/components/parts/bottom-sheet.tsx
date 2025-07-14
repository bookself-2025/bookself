import ApiV1 from '@/v1/api'
import BookDetail from '@/v1/components/parts/book-detail'
import VaulBottomSheet from '@/v1/layouts/vaul-bottom-sheet'
import useBookselfContext from '@/v1/libs/context'
import queryKeys from '@/v1/libs/query-keys'
import {ActionType} from '@/v1/libs/reducer'
import {ReadType} from '@/v1/libs/types'
import {useQueryClient} from '@tanstack/react-query'

export default function BottomSheet() {
    const queryClient = useQueryClient()

    const {
        dispatch,
        state: {
            book,
            filter,
        },
    } = useBookselfContext()

    return (
        <VaulBottomSheet
            open={!!book}
            onOpenChange={(open) => {
                if (!open) {
                    dispatch({type: ActionType.SET_BOOK, payload: undefined})
                }
            }}
        >
            {book && (<BookDetail
                book={book}
                onChangeOwn={(termId) => {
                    dispatch({
                        type: ActionType.SET_BOOK,
                        payload: {
                            ...book,
                            own: termId,
                        },
                    })
                    ApiV1.Book.update({
                        ...book,
                        own: termId,
                    }).then(() => {
                        queryClient.invalidateQueries({queryKey: queryKeys.books(filter)}).then()
                    })
                }}
                onChangeRead={(read) => {
                    dispatch({
                        type: ActionType.SET_BOOK,
                        payload: {
                            ...book,
                            read,
                        },
                    })
                    ApiV1.Book.update({
                        ...book,
                        read: read as ReadType,
                    }).then(() => {
                        queryClient.invalidateQueries({queryKey: queryKeys.books(filter)}).then()
                    })
                }}
            />)}
        </VaulBottomSheet>
    )
}
