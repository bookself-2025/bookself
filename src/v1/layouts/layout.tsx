import Footer from '@/v1/layouts/footer'
import Header from '@/v1/layouts/header'
import {cn} from '@/v1/libs/utils'
import {HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement>

export default function Layout(props: Props) {
    const {
        className,
        children,
        ...rest
    } = props

    // See app.css for admin_bar adjustment.
    return (
        <div
            className={cn(
                'bookself-top-level-container',
                'flex flex-col',
                'w-full min-h-dvh',
                className,
            )}
            {...rest}
        >
            <Header />
            <main className={cn('grow')}>
                {children}
            </main>
            <Footer />
            {/* Spaing for dock */}
            <div className="h-[64px]" />
        </div>
    )
}
