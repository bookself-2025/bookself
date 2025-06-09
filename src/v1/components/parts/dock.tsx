import {cn} from '@/v1/libs/utils'
import {Link, useMatch} from '@tanstack/react-router'
import {Book, CirclePlus} from 'lucide-react'

export default function Dock() {
    return (
        <div className="dock">
            <Link
                className={cn({
                    'dock-active': useMatch({
                        from: '/books',
                        shouldThrow: false,
                    }),
                })}
                id="dock-books"
                to="/books"
            >
                <Book size={20} />
                <span className="mt-0.5 dock-label">내 책</span>
            </Link>
            <Link
                className={cn({
                    'dock-active': useMatch({
                        from: '/add-book',
                        shouldThrow: false,
                    }),
                })}
                id="dock-books"
                to="/add-book"
            >
                <CirclePlus size={20} />
                <span className="mt-0.5 dock-label">책 등록</span>
            </Link>
        </div>
    )
}
