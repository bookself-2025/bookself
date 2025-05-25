import {initApi as _initApi} from './init'
import {query as bookQuery} from './book'

namespace ApiV1 {
    export const initApi = _initApi

    export namespace Book {
        export const query = bookQuery
    }
}

export default ApiV1
