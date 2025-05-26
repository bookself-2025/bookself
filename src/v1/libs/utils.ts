import {StateType} from '@/v1/libs/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

function getDefaultState(override: Partial<StateType> = {}) {
    return {
        book: undefined,
        ...override,
    }
}

export {
    cn,
    getDefaultState,
}
