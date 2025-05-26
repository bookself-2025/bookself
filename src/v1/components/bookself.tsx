import Books from '@/v1/components/parts/books'
import BottomSheet from '@/v1/components/parts/bottom-sheet'
import SheetBookInfo from '@/v1/components/parts/sheet-book-info'
import Layout from '@/v1/layouts/layout'
import useBookselfContext from '@/v1/libs/context'
import {ActionType} from '@/v1/libs/reducer'
import {cn} from '../libs/utils'

export default function Bookself() {
    const {
        dispatch,
        state: {
            book,
        },
    } = useBookselfContext()

    return (
        <Layout
            className={cn(
                {'overflow-y-hidden': !!book},
            )}
        >
            <Books />
            <BottomSheet
                open={!!book}
                onClose={() => dispatch({type: ActionType.SET_BOOK, payload: undefined})}
            >
                {book && <SheetBookInfo book={book} />}
            </BottomSheet>
        </Layout>
    )
}
