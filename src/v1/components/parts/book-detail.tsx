import BookImage from '@/v1/components/parts/book-image'
import TaxSelector from '@/v1/components/parts/tax-selector'
import {BookType, OwnType, ReadType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'
import {Drawer} from 'vaul'

type Props = {
    book: BookType,
    onChangeOwn: (own: OwnType) => void
    onChangeRead: (read: ReadType) => void
}

export default function BookDetail(props: Props) {
    const {
        book,
        onChangeOwn,
        onChangeRead,
    } = props

    console.log('book', book)

    return (
        <div className="sheet-book-info overflow-y-auto">
            <div className={cn('w-full flex justify-center items-start gap-x-4')}>
                <figure className="inline-flex justify-center w-[160px] shrink-0">
                    <BookImage
                        className="w-[160px]"
                        images={book.coverImage}
                    />
                </figure>
                <div className="">
                    <Drawer.Title className="text-xl font-semibold opacity-80">
                        {book.title}
                    </Drawer.Title>
                    <ul className="book-properties mt-4 leading-6">
                        {Object.entries({
                            author: '저자',
                            pressName: '출판사',
                            releaseDate: '출판일',
                            formattedPrice: '정가',
                            isbn: 'ISBN',
                            rate: '평점',
                        }).map(([key, label]) => (
                            <li key={key}>
                                <span className="inline-block min-w-16 font-semibold text-sm">{label}</span>
                                <span className="text-sm">
                                {key in book && book[key as keyof BookType].toString()}
                            </span>
                            </li>
                        ))}
                    </ul>
                </div>
            </div>
            <div className="divider" />
            <div className="mt-4">
                {/* own */}
                <TaxSelector
                    className="tax--own mt-4 gap-0.25"
                    onChange={(value) => onChangeOwn(value as OwnType)}
                    terms={{
                        'own': '소장',
                        'borrow': '대여',
                        'sold': '판매',
                        'wish': '구매희망',
                    }}
                    value={book.own}
                />
                {/* read */}
                <TaxSelector
                    className="tax--read mt-4 gap-0.25 "
                    onChange={(value) => onChangeRead(value as ReadType)}
                    terms={{
                        'not-read': '읽기 전',
                        'reading': '읽는 중',
                        'read': '읽음',
                    }}
                    value={book.read}
                />
            </div>
        </div>
    )
}
