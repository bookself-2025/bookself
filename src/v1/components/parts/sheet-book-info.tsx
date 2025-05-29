import BookImage from '@/v1/components/parts/book-image'
import TaxSelector from '@/v1/components/parts/tax-selector'
import {BookType} from '@/v1/libs/types'

type Props = {
    book: BookType,
}

export default function SheetBookInfo(props: Props) {
    const {
        book,
    } = props

    return (
        <div className="sheet-book-info">
            <figure
                className="inline-flex justify-center"
            >
                <BookImage
                    className="w-1/2"
                    images={book.coverImage}
                />
            </figure>
            <div className="mt-6">
                <h2 className="text-xl font-semibold opacity-80">
                    {book.title}
                </h2>
                <ul className="book-properties mt-2 px-2 leading-6">
                    {Object.entries({
                        author: '저자',
                        pressName: '출판사',
                        releaseDate: '출판일',
                        price: '정가',
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
            <div className="">
                {/* own */}
                <TaxSelector
                    className="tax--own mt-4 gap-0.25"
                    terms={{
                        'own': '소장',
                        'borrow': '대여',
                        'sold': '판매',
                        'wish': '구매희망',
                    }}
                    value={'own'}
                />
                {/* read */}
                <TaxSelector
                    className="tax--read mt-4 gap-0.25 "
                    terms={{
                        'not-read': '읽기 전',
                        'reading': '읽는 중',
                        'read': '읽음',
                    }}
                    value={'read'}
                />
            </div>
        </div>
    )
}
