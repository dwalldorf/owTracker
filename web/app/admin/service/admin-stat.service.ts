import {Injectable} from '@angular/core';
import {HttpService} from "../../core/service/http.service";
import {AppConfig} from "../../app.config";

@Injectable()
export class AdminStatsService {

    private httpService: HttpService;

    constructor(httpService: HttpService) {
        this.httpService = httpService;
    }

    public getAdminStats() {
        return this.httpService.makeRequest(HttpService.METHOD_GET, AppConfig.API_PREFIX + '/adminstats');
    }
}