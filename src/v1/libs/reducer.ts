import {BookType, FilterType, StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {useReducer} from 'react'

enum ActionType {
    SET_BOOK = 'SET_BOOK',
    SET_BOOKS = 'SET_BOOKS',
    SET_FILTER = 'SET_FILTER',
}

type Action =
    | { type: ActionType.SET_BOOK, payload: BookType | undefined }
    | { type: ActionType.SET_FILTER, payload: FilterType }

function reducer(prevState: StateType, action: Action): StateType {
    const {type, payload} = action

    switch (type) {
        case ActionType.SET_BOOK:
            return {
                ...prevState,
                book: payload,
            }

        case ActionType.SET_FILTER:
            return {
                ...prevState,
                filter: payload,
            }

        default:
            return prevState
    }
}

const useBookselfReducer = (state: Partial<StateType> = {}) => (
    useReducer<StateType, [action: Action]>(reducer, getDefaultState(state))
)

export type {
    Action,
}

export {
    ActionType,
    useBookselfReducer,
}
