import {QueryClient, QueryClientProvider} from '@tanstack/react-query'
import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'
import './app.css'

const queryClient = new QueryClient()

const App = () => {
    return (
        <div>App</div>
    )
}

createRoot(document.getElementById('bookself-root')!).render(
    <StrictMode>
        <QueryClientProvider client={queryClient}>
            <App />
        </QueryClientProvider>
    </StrictMode>,
)
