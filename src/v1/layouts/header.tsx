import {cn} from '@/v1/libs/utils'

export default function Header() {
    return (
        <header className={cn()}>
            <div className="navbar bg-base-100 shadow-sm">
                <a className="btn btn-ghost text-3xl">Bookself 2025</a>
            </div>
        </header>
    )
}
