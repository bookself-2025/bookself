import {cn} from '@/v1/libs/utils'
import {forwardRef, HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement> & {
    onClickPage?: (page: number) => void
    page?: number
    range?: [number, number]
}

const Pagination = forwardRef<HTMLDivElement, Props>((props, ref) => {
    const {
        className,
        onClickPage,
        page,
        range,
        ...rest
    } = props

    const [begin, end] = range ?? [0, 0]

    if ((end - begin) <= 0) {
        return null
    }

    return (
        <div
            className={cn(
                'pagination join',
                className,
            )}
            ref={ref}
            {...rest}
        >
            {Array.from({length: end - begin + 1}, (_, i) => (
                <button
                    className={cn('join-item btn', {'btn-active': page === i + 1})}
                    key={begin + i}
                    onClick={() => onClickPage && onClickPage(begin + i)}
                >
                    {begin + i}
                </button>
            ))}
        </div>
    )
})

Pagination.displayName = 'Pagination'

export default Pagination
