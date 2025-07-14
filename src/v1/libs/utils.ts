import {StateType} from '@/v1/libs/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

function getDefaultState(override: Partial<StateType> = {}) {
    return {
        book: undefined,
        filter: {},
        ownTerms: {},
        siteMeta: {
            baseUrl: '',
            title: '',
            version: '',
            ...override.siteMeta,
        },
        ...override,
    }
}

function isValidIsbn(isbn: string) {
    const cleanIsbn = isbn.replace(/[^0-9]/g, '')

    if (cleanIsbn.length !== 13) {
        return false
    }

    const sum = cleanIsbn
        .slice(0, -1)
        .split('')
        .reduce((acc, digit, index) => {
            const multiplier = index % 2 === 0 ? 1 : 3
            return acc + (parseInt(digit) * multiplier)
        }, 0)

    const checkDigit = 10 - (sum % 10)
    const lastDigit = parseInt(cleanIsbn[12])

    return checkDigit === lastDigit
}

function getOwnStati(ownTerms: { [key: string]: number }): Map<number, string> {
    if (!ownStatiMap) {
        ownStatiMap = new Map([
            [ownTerms['own-by-me'], '소유'],
            [ownTerms['own-borrowed'], '대여중'],
            [ownTerms['own-want-to-sell'], '판매 희망'],
            [ownTerms['not-own'], '미소유'],
        ])
    }
    return ownStatiMap
}

let ownStatiMap: Map<number, string> | null = null

function getReadStai(): Map<string, string> {
    if (!readStaiMap) {
        readStaiMap = new Map([
            ['not-read', '읽기 전'],
            ['reading', '읽는 중'],
            ['read', '읽음'],
        ])
    }
    return readStaiMap
}

let readStaiMap: Map<string, string> | null = null

export {
    cn,
    getDefaultState,
    getOwnStati,
    getReadStai,
    isValidIsbn,
}
