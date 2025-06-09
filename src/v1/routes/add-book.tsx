import AddBook from '@/v1/components/parts/add-book'
import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/add-book')({
    component: RouteComponent,
})

function RouteComponent() {
    return <AddBook />
}
