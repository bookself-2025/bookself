import Labelled from '@/v1/components/fields/labelled'
import {InputHTMLAttributes} from 'react'

type Props = InputHTMLAttributes<HTMLInputElement> & {
    label?: string
}

export default function LabelInput(props: Props) {
    const {
        children,
        id,
        label,
        ...rest
    } = props

    return (
        <Labelled htmlFor={id} label={label}>
            <input
                id={id}
                {...rest}
            />
            {children}
        </Labelled>
    )
}