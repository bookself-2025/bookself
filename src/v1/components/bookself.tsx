import ApiV1 from '@/v1/api'
import Books from '@/v1/components/parts/books'
import SheetBookInfo from '@/v1/components/parts/sheet-book-info'
import VaulBottomSheet from '@/v1/components/parts/vaul-bottom-sheet'
import Layout from '@/v1/layouts/layout'
import useBookselfContext from '@/v1/libs/context'
import queryKeys from '@/v1/libs/query-keys'
import {ActionType} from '@/v1/libs/reducer'
import {ReadType} from '@/v1/libs/types'
import {useQueryClient} from '@tanstack/react-query'

export default function Bookself() {
    const queryClient = useQueryClient()

    const {
        dispatch,
        state: {
            book,
        },
    } = useBookselfContext()

    return (
        <Layout>
            <Books />
            <VaulBottomSheet
                open={!!book}
                onOpenChange={(open) => {
                    if (!open) {
                        dispatch({type: ActionType.SET_BOOK, payload: undefined})
                    }
                }}
            >
                {book && (<SheetBookInfo
                    book={book}
                    onChangeOwn={(own) => {
                        dispatch({
                            type: ActionType.SET_BOOK,
                            payload: {
                                ...book,
                                own,
                            },
                        })
                        ApiV1.Book.update({
                            ...book,
                            own: own,
                        }).then(() => {
                            queryClient.invalidateQueries({queryKey: queryKeys.books()}).then()
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
                            queryClient.invalidateQueries({queryKey: queryKeys.books()}).then()
                        })
                    }}
                />)}
            </VaulBottomSheet>
        </Layout>
    )
}
