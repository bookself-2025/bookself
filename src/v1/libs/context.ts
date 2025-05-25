import {Action} from '@/v1/libs/reducer'
import {StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {ActionDispatch, createContext, useContext} from 'react'

type BookselfContextType = {
    dispatch: ActionDispatch<[action: Action]>
    state: StateType
}

const BookselfContext = createContext<BookselfContextType>({
    dispatch: () => {},
    state: getDefaultState(),
})

const useBookselfContext = () => (useContext(BookselfContext))

export default useBookselfContext

export {
    BookselfContext,
}
