import {Injectable} from '@angular/core';
import {HttpService} from "../../core/service/http.service";

@Injectable()
export class DemoUploadService {

    private httpService: HttpService;

    constructor(httpService: HttpService) {
        this.httpService = httpService;
    }

}