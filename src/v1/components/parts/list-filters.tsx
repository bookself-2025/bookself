import useBookselfContext from '@/v1/libs/context'
import {ActionType} from '@/v1/libs/reducer'
import {ReadType} from '@/v1/libs/types'
import {getOwnStati, getReadStai} from '@/v1/libs/utils'
import {cn} from '@/v1/libs/utils'
import {useState} from 'react'

type Props = {
    className?: string,
}

export default function ListFilters(props: Props) {
    const {
        dispatch,
        state: {
            filter,
            ownTerms,
        },
    } = useBookselfContext()

    const {
        className,
    } = props

    const [search, setSearch] = useState(filter.s ?? '')

    const ownStatis = getOwnStati(ownTerms),
        readStatis = getReadStai()

    return (
        <div className={cn('list-filter', className)}>
            <div className="mb-4 w-full text-right">
                <input
                    className="input w-3/8"
                    onChange={(e) => setSearch(e.target.value)}
                    placeholder="도서 검색"
                    type="search"
                    value={search}
                />
                <button
                    className="btn btn-secondary ms-2"
                    onClick={() => dispatch({
                        type: ActionType.SET_FILTER,
                        payload: {
                            ...filter,
                            page: 1,
                            s: search,
                        },
                    })}
                    type="button"
                >검색
                </button>
            </div>
            <div className="flex flex-wrap justify-center gap-y-4 gap-x-8">
                <div className="own-filter filter">
                    <input
                        aria-label="모든 소유 상태"
                        className="btn filter-reset"
                        name="own_filter"
                        onChange={() => dispatch({
                            type: ActionType.SET_FILTER,
                            payload: {
                                ...filter,
                                page: 1,
                                own: undefined,
                            },
                        })}
                        type="radio"
                    />
                    {[...ownStatis.entries()].map(([key, label]) => (
                        <input
                            aria-label={label}
                            className="btn"
                            checked={filter.own === key}
                            key={key}
                            name="own_filter"
                            onChange={() => dispatch({
                                type: ActionType.SET_FILTER,
                                payload: {
                                    ...filter,
                                    page: 1,
                                    own: key,
                                },
                            })}
                            type="radio"
                            value={key}
                        />
                    ))}
                </div>
                <div className="read-filter filter">
                    <input
                        aria-label="모든 도서 상태"
                        className="btn filter-reset"
                        name="read_filter"
                        onChange={() => dispatch({
                            type: ActionType.SET_FILTER,
                            payload: {
                                ...filter,
                                page: 1,
                                read: undefined,
                            },
                        })}
                        type="radio"
                    />
                    {[...readStatis.entries()].map(([key, label]) => (
                        <input
                            aria-label={label}
                            checked={filter.read === key}
                            className="btn"
                            key={key}
                            name="read_filter"
                            onChange={() => dispatch({
                                type: ActionType.SET_FILTER,
                                payload: {
                                    ...filter,
                                    page: 1,
                                    read: key as ReadType,
                                },
                            })}
                            type="radio"
                            value={key}
                        />
                    ))}
                </div>
            </div>
        </div>
    )
}
