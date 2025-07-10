import ApiV1 from '@/v1/api'
import FormSubmit from '@/v1/components/fields/form-submit'
import ImagePreview from '@/v1/components/fields/image-preview'
import LabelInput from '@/v1/components/fields/label-input'
import Labelled from '@/v1/components/fields/labelled'
import useBookselfContext from '@/v1/libs/context'
import {createFormHook, createFormHookContexts} from '@tanstack/react-form'

const {fieldContext, formContext} = createFormHookContexts()

const {useAppForm} = createFormHook({
    fieldComponents: {
        ImagePreview,
        LabelInput,
        Labelled,
    },
    formComponents: {
        FormSubmit,
    },
    fieldContext,
    formContext,
})

export default function useAddBookForm() {
    const {
        state: {
            ownTerms,
        }
    } = useBookselfContext()

    return useAppForm({
        defaultValues: {
            coverImage: '',
            isbn: '',
            title: '',
            author: '',
            pressName: '',
            releaseDate: '',
            price: '',
            own: ownTerms['own-by-me'],
            read: 'not-read',
        },
        onSubmit: ({value, formApi}) => {
            ApiV1.Book.add(value).then(() => {
                alert('책이 등록되었습니다.')
                formApi.reset()
            }).catch((err: Error) => {
                alert(err.message)
            })
        },
    })
}
