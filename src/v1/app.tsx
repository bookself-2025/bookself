import ApiV1 from '@/v1/api'
import Bookself from '@/v1/components/bookself'
import {BookselfContext} from '@/v1/libs/context'
import {useBookselfReducer} from '@/v1/libs/reducer'
import type {StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import './app.css'

declare global {
    const bookselfVars: {
        api: {
            baseUrl: string
            nonce: string
        },
    }
}

const queryClient = new QueryClient()

const {baseUrl, nonce} = bookselfVars.api

ApiV1.initApi(baseUrl, nonce)

type Props = {
    initialState?: Partial<StateType>
}

const App = (props: Props) => {
    const {
        initialState,
    } = props

    const [state, dispatch] = useBookselfReducer(getDefaultState(initialState))

    return (
        <QueryClientProvider client={queryClient}>
            <BookselfContext.Provider value={{state, dispatch}}>
                <Bookself />
            </BookselfContext.Provider>
        </QueryClientProvider>
    )
}

createRoot(document.getElementById('bookself-root')!).render(
    <StrictMode>
        <App />
    </StrictMode>,
)
