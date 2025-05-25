import {ImageType} from '@/v1/libs/types'
import {cn} from '@/v1/libs/utils'
import {forwardRef, ImgHTMLAttributes} from 'react'

type Props = {
    images: { [key: string]: ImageType }
} & ImgHTMLAttributes<HTMLImageElement>

const BookImage = forwardRef<HTMLImageElement, Props>((props: Props, ref) => {
    const {
        alt,
        className,
        images,
        ...rest
    } = props

    const srcset = Object.values(images)
        .sort((a, b) => a.width - b.width)
        .map((item) => `${item.url} ${item.width}w`)
        .join(', ')

    if (!('full' in images)) {
        return null
    }

    return (
        <img
            alt={alt}
            className={cn('book-image', className)}
            ref={ref}
            src={images.full.url}
            srcSet={srcset}
            {...rest}
        />
    )
})
BookImage.displayName = 'BookImage'

export default BookImage
