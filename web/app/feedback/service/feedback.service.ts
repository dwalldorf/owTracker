import {Injectable} from '@angular/core';
import {Feedback} from "../model/feedback";
import {HttpService} from "../../core/service/http.service";
import {AppConfig} from "../../app.config";

@Injectable()
export class FeedbackService {

    private httpService: HttpService;

    constructor(httpService: HttpService) {
        this.httpService = httpService;
    }

    submitFeedback(feedback: Feedback) {
        console.log('submitFeedback');
        console.log(feedback);

        return this.httpService
            .makeRequest(HttpService.METHOD_POST, AppConfig.API_PREFIX + '/feedback', feedback);
    }

}