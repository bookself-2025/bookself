import {cn} from '@/v1/libs/utils'
import {HTMLAttributes} from 'react'

type Props = Omit<HTMLAttributes<HTMLDivElement>, 'onChange'> & {
    terms?: { [key: string]: string }
    value?: string
    onChange?: (value: string) => void
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
                    onClick={() => onChange && onChange(key)}
                    key={key}
                >
                    {label}
                </button>
            ))}
        </div>
    )
}