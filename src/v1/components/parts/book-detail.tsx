import BookImage from '@/v1/components/parts/book-image'
import TaxSelector from '@/v1/components/parts/tax-selector'
import useBookselfContext from '@/v1/libs/context'
import {BookType, ReadType} from '@/v1/libs/types'
import {cn, getOwnStati, getReadStai} from '@/v1/libs/utils'
import {Drawer} from 'vaul'

type Props = {
    book: BookType,
    onChangeOwn: (own: number) => void
    onChangeRead: (read: ReadType) => void
}

export default function BookDetail(props: Props) {
    const {
        state: {
            ownTerms,
        },
    } = useBookselfContext()

    const {
        book,
        onChangeOwn,
        onChangeRead,
    } = props

    return (
        <div className="sheet-book-info overflow-y-auto">
            <div className={cn('w-full flex flex-col justify-center')}>
                <figure className="inline-flex justify-center w-full">
                    <BookImage
                        className="w-[160px]"
                        images={book.coverImage}
                    />
                </figure>
                <div className="mt-4">
                    <Drawer.Title className="text-xl text-center font-semibold opacity-80">
                        {book.title}
                    </Drawer.Title>
                    <div className="mt-3 text-center text-sm">
                        {book.author} | {book.pressName}
                    </div>
                    <div className="mt-4">
                        {/* own */}
                        <TaxSelector
                            className="tax--own mt-4 gap-0.25"
                            onChange={(value) => onChangeOwn(value as number)}
                            terms={getOwnStati(ownTerms)}
                            value={book.own}
                        />
                        {/* read */}
                        <TaxSelector
                            className="tax--read mt-4 gap-0.25 "
                            disabled={ownTerms['not-own'] === book.own}
                            onChange={(value) => onChangeRead(value as ReadType)}
                            terms={getReadStai()}
                            value={book.read}
                        />
                    </div>
                    <div className="divider" />
                    <div className="book-properties mt-4 overflow-x-auto">
                        <details className="collapse collapse-arrow bg-base-100 border-base-300 border">
                            <summary className="collapse-title font-semibold">
                                도서 상세 정보
                            </summary>
                            <div className="collapse-content text-sm">
                                <table className="table">
                                    {Object.entries({
                                        author: '저자',
                                        pressName: '출판사',
                                        releaseDate: '출판일',
                                        formattedPrice: '정가',
                                        isbn: 'ISBN',
                                        rate: '평점',
                                    }).map(([key, label]) => (
                                        <tr key={key}>
                                            <th className="inline-block min-w-16 font-semibold text-sm px-2 py-1">{label}</th>
                                            <td className="text-sm px-2 py-1">
                                                {key in book && book[key as keyof BookType].toString()}
                                            </td>
                                        </tr>
                                    ))}
                                </table>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    )
}
