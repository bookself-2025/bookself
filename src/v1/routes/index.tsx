import {createFileRoute, redirect} from '@tanstack/react-router'

export const Route = createFileRoute('/')({
    component: RouteComponent,
    loader: () => {
        redirect({
            to: '/books',
            throw: true,
        })
    },
})

function RouteComponent() {
    return null
}
