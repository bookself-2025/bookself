import Footer from '@/v1/layouts/footer'
import Header from '@/v1/layouts/header'
import {cn} from '@/v1/libs/utils'
import {PropsWithChildren} from 'react'

export default function Layout(props: PropsWithChildren) {
    const {
        children,
    } = props

    return (
        <div
            className={cn(
                'bookself-top-level-container',
                'flex flex-col',
            )}
        >
            <Header />
            <main
                className={cn(
                    'grow',
                )}
            >
                {children}
            </main>
            <Footer />
        </div>
    )
}
