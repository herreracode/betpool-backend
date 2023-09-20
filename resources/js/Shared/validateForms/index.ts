import {useToast} from 'vue-toast-notification';

const $toast = useToast();

const isMandatoryField = (value) => {


    if(typeof value == 'object' && !!value){
        if(value.length > 0){
            return true
        }
    }else{
        if (value) return true
    }

    return 'Este campo es requerido'
}

const moreThanCharateres =
    function (lengthCharaters) {
        return (value) => {

            if (value?.length > lengthCharaters) return true

            return 'El campo debe tener mas de ' + lengthCharaters + ' caracteres.'
    }
}

const formValidate = async (form) : Promise<boolean> => {

    let validForm = await form.value.validate()

    if(!validForm.valid){
        $toast.warning("Revise los campos de su formulario")
        return false
    }

    return true
}

export {
    isMandatoryField,
    moreThanCharateres,
    formValidate
}
