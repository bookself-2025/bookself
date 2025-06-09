import Books from '@/v1/components/parts/books'
import BottomSheet from '@/v1/components/parts/bottom-sheet'
import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/books')({
    component: RouteComponent,
})

function RouteComponent() {
    return (
        <>
            <Books />
            <BottomSheet />
        </>
    )
}
