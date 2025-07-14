import {FilterType} from '@/v1/libs/types'

const queryKeys = {
    default: ['bookself', 'v1'] as const,
    books: (filter: FilterType) => [...queryKeys.default, 'books', filter],
} as const

export default queryKeys