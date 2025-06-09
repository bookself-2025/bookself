import Dock from '@/v1/components/parts/dock'
import Layout from '@/v1/layouts/layout'
import {createRootRoute, Outlet} from '@tanstack/react-router'
import {TanStackRouterDevtools} from '@tanstack/react-router-devtools'

export const Route = createRootRoute({
    component: RootComponent,
})

function RootComponent() {
    return (
        <>
            <Layout>
                <Outlet />
                <Dock />
            </Layout>
            <TanStackRouterDevtools />
        </>
    )
}
