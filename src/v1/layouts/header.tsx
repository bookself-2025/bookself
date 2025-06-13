import useBookselfContext from '@/v1/libs/context'
import {cn} from '@/v1/libs/utils'

export default function Header() {
    const {
        state: {
            siteMeta: {
                baseUrl,
                title,
            },
        },
    } = useBookselfContext()

    return (
        <header className={cn()}>
            <div className="navbar bg-base-100 shadow-sm">
                <a href={baseUrl} className="btn btn-ghost text-3xl">{title}</a>
            </div>
        </header>
    )
}
