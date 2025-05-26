import {BookType, StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {useReducer} from 'react'

enum ActionType {
    SET_BOOK = 'SET_BOOK',
}

type Action =
    | { type: ActionType, payload: BookType | undefined };

function reducer(prevState: StateType, action: Action): StateType {
    const {type, payload} = action

    switch (type) {
        case ActionType.SET_BOOK:
            return {
                ...prevState,
                book: payload,
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
