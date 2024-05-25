
import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost/birthingHome/3c-enrollment/public/api', 
    timeout: 5000,
    headers: {
        'Content-Type': 'multipart/form-data', 
        'Accept': 'application/json'
    }
});

export default instance;