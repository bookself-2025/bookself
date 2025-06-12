import {cn} from '@/v1/libs/utils'
import {LabelHTMLAttributes} from 'react'

type Props = LabelHTMLAttributes<HTMLLabelElement> & {
    label?: string
}

export default function Labelled(props: Props) {
    const {className, children, label, ...rest} = props

    return (
        <>
            <label className={cn('label mt-2', className)} {...rest}>
                {label}
            </label>
            {children}
        </>

    )
}
