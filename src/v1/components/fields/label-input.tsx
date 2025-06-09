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
        <>
            <label className="label mt-2" htmlFor={id}>
                {label}
            </label>
            <input
                id={id}
                {...rest}
            />
            {children}
        </>
    )
}