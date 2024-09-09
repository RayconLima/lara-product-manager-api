import Http from "../http/http.init"

export default class BaseService {
    instance:any
    
    constructor() {
        this.instance = new BaseService
    }

    static request (status = { auth: false }) {
        return new Http(status)
    }
}