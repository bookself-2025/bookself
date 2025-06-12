import {useEffect, useRef} from 'react'

type Props = {
    value?: string
}

export default function ImagePreview(props: Props) {
    const {value} = props

    const ref = useRef<HTMLImageElement>(null)

    useEffect(() => {
        if (value && (value.startsWith('http://') || value?.startsWith('https://')) && ref.current) {
            ref.current.src = value
        }
    }, [value])

    if (!value || !value.length) {
        return '선택된 이미지가 없습니다.'
    }

    return (
        <figure className="image w-full text-center py-2">
            <img
                alt="책 커버 이미지 미리보기"
                className="book-image-preview inline "
                ref={ref}
            />
        </figure>
    )
}
