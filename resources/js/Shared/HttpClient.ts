import axios from 'axios';

const HttpClient = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
});

export default HttpClient
