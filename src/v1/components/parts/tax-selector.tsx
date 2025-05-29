import {cn} from '@/v1/libs/utils'
import {HTMLAttributes} from 'react'

type Props = HTMLAttributes<HTMLDivElement> & {
    onChange?: (value: string) => void
    terms?: { [key: string]: string }
    value?: string
}

export default function TaxSelector(props: Props) {
    const {
        className,
        onChange,
        terms,
        value,
        ...rest
    } = props

    return (
        <div
            className={cn(
                'tax-selector flex justify-center',
                className
            )}
            {...rest}
        >
            {!!terms && Object.entries(terms).map(([key, label]) => (
                <button
                    className={cn(
                        'btn btn-sm shrink',
                        {'btn-neutral': value === key},
                    )}
                >
                    {label}
                </button>
            ))}
        </div>
    )
}