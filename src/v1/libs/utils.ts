import {StateType} from '@/v1/libs/types'
import {type ClassValue, clsx} from 'clsx'
import {twMerge} from 'tailwind-merge'

function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

function getDefaultState(override: Partial<StateType> = {}) {
    return {
        book: undefined,
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
    const cleanIsbn = isbn.replace(/[^0-9]/g, '');

    if (cleanIsbn.length !== 13) {
        return false;
    }

    const sum = cleanIsbn
        .slice(0, -1)
        .split('')
        .reduce((acc, digit, index) => {
            const multiplier = index % 2 === 0 ? 1 : 3;
            return acc + (parseInt(digit) * multiplier);
        }, 0);

    const checkDigit = 10 - (sum % 10);
    const lastDigit = parseInt(cleanIsbn[12]);

    return checkDigit === lastDigit;
}

export {
    cn,
    getDefaultState,
    isValidIsbn,
}
