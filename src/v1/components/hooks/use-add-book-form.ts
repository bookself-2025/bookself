import FormSubmit from '@/v1/components/fields/form-submit'
import LabelInput from '@/v1/components/fields/label-input'
import {createFormHook, createFormHookContexts} from '@tanstack/react-form'

const {fieldContext, formContext} = createFormHookContexts()

const {useAppForm} = createFormHook({
    fieldComponents: {
        LabelInput,
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
            isbn: '9788962813609',
            title: '',
            author: '',
            pressName: '',
            releaseDate: '',
            price: '',
            own: '',
            read: '',
        },
        onSubmit: ({value}) => {
            alert(JSON.stringify(value, null, 2))
        },
    })
}