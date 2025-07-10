import {cn} from '@/v1/libs/utils'
import {HTMLAttributes} from 'react'

type Props = Omit<HTMLAttributes<HTMLDivElement>, 'onChange'> & {
    disabled?: boolean
    onChange?: (value: string | number) => void
    terms?: Map<number | string, string>
    value?: string | number
}

export default function TaxSelector(props: Props) {
    const {
        className,
        disabled,
        onChange,
        terms,
        value,
        ...rest
    } = props

    return (
        <div
            className={cn(
                'tax-selector flex justify-center',
                className,
            )}
            {...rest}
        >
            <div className="join">
                {!!terms && [...terms.entries()].map(([key, label]) => (
                    <button
                        className={cn(
                            'btn btn-sm shrink',
                            {'btn-neutral': value?.toString() === key.toString()},
                        )}
                        disabled={disabled}
                        key={key}
                        onClick={() => onChange && onChange(key)}
                        type="button"
                    >
                        {label}
                    </button>
                ))}
            </div>
        </div>
    )
}