import FormSubmit from '@/v1/components/fields/form-submit'
import ImagePreview from '@/v1/components/fields/image-preview'
import LabelInput from '@/v1/components/fields/label-input'
import Labelled from '@/v1/components/fields/labelled'
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
    return useAppForm({
        defaultValues: {
            coverImage: '',
            isbn: '9788962813609',
            title: '',
            author: '',
            pressName: '',
            releaseDate: '',
            price: '',
            own: 'own',
            read: 'not-read',
        },
        onSubmit: ({value}) => {
            alert(JSON.stringify(value, null, 2))
        },
    })
}