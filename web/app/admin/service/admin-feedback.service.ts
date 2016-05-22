import {Injectable} from '@angular/core';
import {HttpService} from "../../core/service/http.service";
import {AppConfig} from "../../app.config";

@Injectable()
export class AdminFeedbackService {

    private httpService: HttpService;

    constructor(httpService: HttpService) {
        this.httpService = httpService;
    }

    public getUserFeedback() {
        return this.httpService.makeRequest(HttpService.METHOD_GET, AppConfig.API_PREFIX + '/feedback');
    }

}