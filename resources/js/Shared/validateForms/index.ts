const isMandatoryField = (value) => {

    if (value) return true

    return 'Este campo es requerido'

}

const moreThanCharateres =
    function (lengthCharaters) {
        return (value) => {

            if (value?.length > lengthCharaters) return true

            return 'El campo debe tener mas de ' + lengthCharaters + ' caracteres.'
    }
}

export {
    isMandatoryField,
    moreThanCharateres
}
