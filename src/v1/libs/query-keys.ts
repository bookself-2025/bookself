const queryKeys = {
    default: ['bookself', 'v1'] as const,
    books: () => [...queryKeys.default, 'books'],
} as const

export default queryKeys