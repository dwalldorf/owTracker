import {Injectable} from '@angular/core';
import {Feedback} from "../model/feedback";
import {HttpService} from "../../core/service/http.service";

@Injectable()
export class FeedbackService {

    private httpService: HttpService;

    constructor(httpService: HttpService) {
        this.httpService = httpService;
    }

    submitFeedback(feedback: Feedback) {
        return this.httpService
            .makeRequest(HttpService.METHOD_POST, '/feedback', feedback);
    }

}