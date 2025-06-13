import {_add, _getBookInfo, _query, _update} from './book'
import {_initApi} from './init'

namespace ApiV1 {
    export const initApi = _initApi

    export namespace Book {
        export const add = _add
        export const getBookInfo = _getBookInfo
        export const query = _query
        export const update = _update
    }
}

export default ApiV1
