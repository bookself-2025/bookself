import {cn} from '@/v1/libs/utils'
import {ButtonHTMLAttributes, forwardRef} from 'react'

type Props = ButtonHTMLAttributes<HTMLButtonElement>

const FormSubmit = forwardRef<HTMLButtonElement, ButtonHTMLAttributes<HTMLButtonElement>>((props: Props, ref) => {
    const {className, children, type, ...rest} = props

    return (
        <button
            className={cn('btn btn-primary mt-8', className)}
            ref={ref}
            type={type ?? 'submit'}
            {...rest}
        >
            {children}
        </button>
    )
})
FormSubmit.displayName = 'FormSubmit'

export default FormSubmit
