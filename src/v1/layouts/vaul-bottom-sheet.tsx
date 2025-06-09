import {cn} from '@/v1/libs/utils'
import {PropsWithChildren} from 'react'
import {Drawer} from 'vaul'

type Props = PropsWithChildren<{
    onOpenChange?: (open: boolean) => void
    open?: boolean
}>

export default function VaulBottomSheet(props: Props) {
    const {
        children,
        onOpenChange,
        open,
    } = props

    return (
        <Drawer.Root open={open} onOpenChange={onOpenChange}>
            <Drawer.Portal>
                <Drawer.Overlay className="fixed inset-0 bg-black/40" />
                <Drawer.Content
                    className={cn(
                        'bg-gray-100 flex flex-col mt-24',
                        'fixed bottom-[64px] left-1/2 transform -translate-x-1/2', // fixed position setup
                        'max-h-[90%] h-fit', // height setup
                        'w-10/12 sm:w-2/3 lg:w-1/2', // width setup
                        'rounded-t-[10px] outline-none', // outline and roundness
                    )}
                >
                    <div className="p-4 bg-white rounded-t-[10px] flex-1 overflow-y-auto">
                        <div className="max-w-md mx-auto space-y-4">
                            <div
                                aria-hidden
                                className="mx-auto w-12 h-1.5 flex-shrink-0 rounded-full bg-gray-300 mb-8"
                            />
                            {children}
                        </div>
                    </div>
                </Drawer.Content>
            </Drawer.Portal>
        </Drawer.Root>
    )
}