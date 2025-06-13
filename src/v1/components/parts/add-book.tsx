import ApiV1 from '@/v1/api'
import useAddBookForm from '@/v1/components/hooks/use-add-book-form'
import TaxSelector from '@/v1/components/parts/tax-selector'
import {useStore} from '@tanstack/react-form'
import {Barcode, Search} from 'lucide-react'
import {useState} from 'react'
import {BarcodeScanner} from 'react-barcode-scanner'
import 'react-barcode-scanner/polyfill'

export default function AddBook() {
    const form = useAddBookForm()

    const [
        coverImage,
        isbn,
        own,
        read,
        title,
    ] = useStore(form.store, (state) => [
        state.values.coverImage,
        state.values.isbn,
        state.values.own,
        state.values.read,
        state.values.title,
    ])

    const [showBarcodeScanner, setShowBarcodeScanner] = useState<boolean>(false)

    const formatIsbn = (value: string) => {
        value = value.replace(/[^0-9]/g, '')

        const parts = [
            value.substring(0, 3),
            value.substring(3, 5),
            value.substring(5, 9),
            value.substring(9, 12),
            value.substring(12, 13),
        ]

        return parts.filter((part) => part.length > 0).join('-')
    }

    return (
        <div className="add-book w-full inline-flex justify-center py-8 px-4">
            <div className="max-w-[320px]">
                <h1 className="text-lg font-semibold mb-2">새 책 등록</h1>

                <div className="">
                    <button className="btn btn-accent" onClick={() => setShowBarcodeScanner(!showBarcodeScanner)}>
                        <Barcode className="me-1" />
                        {showBarcodeScanner ? '스캔 닫기' : '바코드 스캔'}
                    </button>
                    {showBarcodeScanner && (
                        <>
                            <div className="mt-2 w-[320px] h-[200px]">
                                <BarcodeScanner
                                    id="add-book-barcode-scanner"
                                    className="mt-2"
                                    onCapture={(barcodes) => {
                                        if (barcodes.length > 0 && barcodes[0].rawValue.length > 0) {
                                            form.setFieldValue('isbn', barcodes[0].rawValue)
                                            setShowBarcodeScanner(false)
                                        }
                                    }}
                                    options={{
                                        formats: ['ean_13'],
                                    }}
                                    trackConstraints={{
                                        aspectRatio: {min: 1, max: 2},
                                        height: {min: 300},
                                        width: {min: 450},
                                    }}
                                />
                            </div>
                        </>
                    )}
                </div>

                <form
                    className="mt-4"
                    onSubmit={e => {
                        e.preventDefault()
                        form.handleSubmit().then()
                    }}
                >
                    <fieldset className="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                        <legend className="fieldset-legend">책 정보</legend>

                        {/* Cover image */}
                        <form.AppField
                            name="coverImage"
                            children={(field) => {
                                return (
                                    <field.Labelled
                                        label={'커버 이미지'}
                                    >
                                        <field.ImagePreview value={coverImage} />
                                        <input
                                            id="book-comverImage"
                                            name={field.name}
                                            type="hidden"
                                            value={field.state.value}
                                        />
                                    </field.Labelled>
                                )
                            }}
                        />

                        {/* ISBN */}
                        <form.AppField
                            name="isbn"
                            children={(field) => {
                                return (
                                    <field.Labelled label={'ISBN'}>
                                        <div className="join">
                                            <input
                                                id="book-isbn"
                                                className="input"
                                                name={field.name}
                                                onBlur={field.handleBlur}
                                                onChange={(e) => field.handleChange(e.target.value.replace(/[^0-9]/g, ''))}
                                                placeholder=""
                                                type="text"
                                                value={formatIsbn(isbn)}
                                            />
                                            <button
                                                className="btn btn-secondary"
                                                disabled={13 !== isbn.length}
                                                type="button"
                                                onClick={() => {
                                                    ApiV1.Book.getBookInfo(field.state.value).then((data) => {
                                                        form.setFieldValue('author', data.author)
                                                        form.setFieldValue('coverImage', data.cover)
                                                        form.setFieldValue('pressName', data.pressName)
                                                        form.setFieldValue('price', data.price.toString())
                                                        form.setFieldValue('releaseDate', data.releaseDate)
                                                        form.setFieldValue('title', data.title)
                                                    })
                                                }}
                                            >
                                                <Search size={18} />
                                            </button>
                                        </div>
                                    </field.Labelled>
                                )
                            }}
                        />

                        {/* 도서 제목 */}
                        <form.AppField
                            name="title"
                            children={(field) => {
                                return (
                                    <field.LabelInput
                                        id="book-title"
                                        className="input"
                                        label="제목"
                                        name={field.name}
                                        onBlur={field.handleBlur}
                                        onChange={(e) => field.handleChange(e.target.value)}
                                        placeholder="책 제목은 필수 입력합니다"
                                        required={true}
                                        type="text"
                                        value={title}
                                    />
                                )
                            }}
                        />

                        {/* 저자 */}
                        <form.AppField
                            name="author"
                            children={(field) => {
                                return (
                                    <field.LabelInput
                                        id="book-author"
                                        className="input"
                                        label="저자"
                                        name={field.name}
                                        onBlur={field.handleBlur}
                                        onChange={(e) => field.handleChange(e.target.value)}
                                        type="text"
                                        value={field.state.value}
                                    />
                                )
                            }}
                        />

                        {/* 출판사 */}
                        <form.AppField
                            name="pressName"
                            children={(field) => {
                                return (
                                    <field.LabelInput
                                        id="book-pressName"
                                        className="input"
                                        label="출판사"
                                        name={field.name}
                                        onBlur={field.handleBlur}
                                        onChange={(e) => field.handleChange(e.target.value)}
                                        type="text"
                                        value={field.state.value}
                                    />
                                )
                            }}
                        />

                        {/* 출간일 */}
                        <form.AppField
                            name="releaseDate"
                            children={(field) => {
                                return (
                                    <field.LabelInput
                                        id="book-releaseDate"
                                        className="input"
                                        label="출간일"
                                        name={field.name}
                                        onBlur={field.handleBlur}
                                        onChange={(e) => field.handleChange(e.target.value)}
                                        type="date"
                                        value={field.state.value}
                                    />
                                )
                            }}
                        />

                        {/* 정가 */}
                        <form.AppField
                            name="price"
                            children={(field) => {
                                return (
                                    <field.LabelInput
                                        id="book-price"
                                        className="input"
                                        label="정가"
                                        name={field.name}
                                        onBlur={field.handleBlur}
                                        onChange={(e) => field.handleChange(e.target.value)}
                                        type="text"
                                        value={field.state.value}
                                    />
                                )
                            }}
                        />

                        {/* 소유 */}
                        <form.AppField
                            name="own"
                            children={(field) => {
                                return (
                                    <field.Labelled label="소유 상태">
                                        <TaxSelector
                                            id="book-own"
                                            className="mt-1"
                                            onChange={(value) => field.setValue(value)}
                                            terms={{
                                                'own': '소장',
                                                'borrow': '대여',
                                                'sold': '판매',
                                                'wish': '구매희망',
                                            }}
                                            value={own}
                                        />
                                    </field.Labelled>
                                )
                            }}
                        />

                        {/* 독서 */}
                        <form.AppField
                            name="read"
                            children={(field) => {
                                return (
                                    <field.Labelled label="독서 상태">
                                        <TaxSelector
                                            id="book-own"
                                            className="mt-1"
                                            onChange={(value) => field.setValue(value)}
                                            terms={{
                                                'not-read': '읽기 전',
                                                'reading': '읽는 중',
                                                'read': '읽음',
                                            }}
                                            value={read}
                                        />
                                    </field.Labelled>
                                )
                            }}
                        />
                        <form.AppForm>
                            <form.Subscribe
                                selector={(state) => [state.canSubmit, state.isSubmitting]}
                                children={([canSubmit, isSubmitting]) => (
                                    <form.FormSubmit disabled={!canSubmit || isSubmitting}>
                                        {canSubmit ? '저장하기' : (isSubmitting ? '저장하는 중...' : '저장할 수 없습니다')}
                                    </form.FormSubmit>
                                )}
                            />
                        </form.AppForm>
                    </fieldset>
                </form>
            </div>
        </div>
    )
}
