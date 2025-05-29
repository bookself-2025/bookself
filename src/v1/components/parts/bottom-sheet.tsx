import {cn} from '@/v1/libs/utils'
import {HTMLAttributes, useEffect, useRef, useState} from 'react'
import './bottom-sheet.css'

type Props = HTMLAttributes<HTMLDivElement> & {
    open?: boolean
    onClose?: () => void
}

const BottomSheet = (props: Props) => {
    const {
        className,
        children,
        onClose,
        open,
        ...rest
    } = props

    const ref = useRef<HTMLDivElement>(null)
    const backdropRef = useRef<HTMLDivElement>(null)

    const [initialEffectLimit, setInitialEffectLimit] = useState(true)

    useEffect(() => {
        const onAnimationEnd = (e: AnimationEvent) => {
            if ('fade-out' === e.animationName) {
                (e.target as HTMLDivElement).classList.remove('is-closing')
            }
        }
        if (backdropRef.current) {
            backdropRef.current.addEventListener('animationend', onAnimationEnd)
        }
        return () => {
            if (backdropRef.current) {
                backdropRef.current.removeEventListener('animationend', onAnimationEnd)
            }
        }
    }, [])

    useEffect(() => {
        if (backdropRef.current) {
            const elem = backdropRef.current
            if (open) {
                elem.classList.remove('is-closing')
                elem.classList.add('is-active')
            } else {
                if (initialEffectLimit) {
                    setInitialEffectLimit(false)
                    return
                }
                elem.classList.add('fade-out')
                elem.addEventListener('animationend', () => {})
                elem.classList.remove('is-active')
                elem.classList.add('is-closing')
                setTimeout(() => {
                    elem.classList.remove('is-closing')
                }, 1000)
            }
        }
    }, [open])

    return (
        <div
            className={cn(
                'bottom-sheet--backdrop',
                'bg-neutral-950/50',
            )}
            onClickCapture={(e) => {
                if (ref.current && !ref.current.contains(e.target as Node)) {
                    onClose && onClose()
                }
            }}
            ref={backdropRef}
        >
            <div
                className={cn(
                    'bottom-sheet--main',
                    'bg-neutral-200',                                   // background
                    'fixed bottom-0 left-1/2 transform -translate-x-1/2', // fixed position
                    'w-10/12 sm:w-2/3 lg:w-1/2',                          // width
                    'max-h-80vh overflow-y-auto',                         // height
                    'rounded-tl-3xl rounded-tr-3xl',                      // roundness
                    'z-50',                                               // z-index
                    className,
                )}
                ref={ref}
                {...rest}
            >
                <div
                    className={cn(
                        'bottom-sheet-handle--outer',
                        'py-3',
                    )}
                >
                    <div
                        className={cn(
                            'bottom-sheet-handle--inner',
                            'bg-neutral-400',
                            'rounded-2xl',
                            'w-2/3 h-2 mx-auto',
                        )}
                    />
                </div>

                <div
                    className={cn(
                        'bottom-sheet--content',
                        'p-6',
                    )}
                >
                    {children}
                </div>
            </div>
        </div>
    )
}

export default BottomSheet
