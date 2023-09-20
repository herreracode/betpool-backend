import axios from 'axios';
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

const HttpClient = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
});

HttpClient.interceptors.response.use(function (response) {

    return response;

}, function (error) {

    if (error.response.status !== 500) {

        $toast.error(error.response.data.error.message)

    } else {
        $toast.error("hubo un error en el servidor intente más tarde")
    }


    return Promise.reject(error);
});

export default HttpClient
