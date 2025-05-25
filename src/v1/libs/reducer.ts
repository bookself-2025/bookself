import {StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {useReducer} from 'react'

enum ActionType {}

type Action = { type: ActionType, payload: undefined };

function reducer(prevState: StateType, action: Action): StateType {
    const {type} = action

    switch (type) {
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
