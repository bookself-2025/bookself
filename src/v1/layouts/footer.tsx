import useBookselfContext from '@/v1/libs/context'

export default function Footer() {
    const {
        state: {
            siteMeta: {
                version,
            },
        },
    } = useBookselfContext()

    return (
        <footer className="footer sm:footer-horizontal footer-center bg-base-300 text-base-content p-4">
            <aside>
                <p>Bookself 2025 사이트 프로젝트, v.{version}</p>
            </aside>
        </footer>
    )
}
