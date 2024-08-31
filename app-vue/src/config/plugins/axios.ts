import axios from 'axios';

axios.defaults.baseURL          = import.meta.env.VITE_APP_URL_API
axios.defaults.withCredentials  = true;

axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    const response = error.response;

    return Promise.reject({
        status: response?.status
    });
})