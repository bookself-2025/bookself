import ApiV1 from '@/v1/api'
import {BookselfContext} from '@/v1/libs/context'
import {useBookselfReducer} from '@/v1/libs/reducer'
import type {StateType} from '@/v1/libs/types'
import {getDefaultState} from '@/v1/libs/utils'
import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {createHashHistory, createRouter, RouterProvider} from '@tanstack/react-router'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import './app.css'
// Import the generated route tree
import {routeTree} from './route-tree.gen'

declare module '@tanstack/react-router' {
    interface Register {
        router: typeof router
    }
}

declare global {
    const bookselfVars: {
        api: {
            baseUrl: string
            nonce: string
        },
    }
}

// React route
const history = createHashHistory()
const router = createRouter({routeTree, history})

// React query client
const queryClient = new QueryClient()

// Init API
const {baseUrl, nonce} = bookselfVars.api
ApiV1.initApi(baseUrl, nonce)

// Our main app props
type Props = {
    initialState?: Partial<StateType>
}

// Our main app
const App = (props: Props) => {
    const {
        initialState,
    } = props

    const [state, dispatch] = useBookselfReducer(getDefaultState(initialState))

    return (
        <QueryClientProvider client={queryClient}>
            <BookselfContext.Provider value={{state, dispatch}}>
                <RouterProvider router={router} />
            </BookselfContext.Provider>
        </QueryClientProvider>
    )
}

createRoot(document.getElementById('bookself-root')!).render(
    <StrictMode>
        <App />
    </StrictMode>,
)
