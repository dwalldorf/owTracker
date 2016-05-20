import {Component} from '@angular/core';
import {FeedbackService} from "./service/feedback.service";
import {Feedback} from "./model/feedback";

@Component({
    selector: 'feedback-modal',
    templateUrl: 'app/feedback/views/feedback-dialog.html',
})
export class FeedbackDialogComponent {

    private feedbackService: FeedbackService;

    feedback = new Feedback();

    constructor(feedbackService: FeedbackService) {
        this.feedbackService = feedbackService;
    }

    submitFeedback() {
        this.feedbackService.submitFeedback(this.feedback)
            .subscribe(() => console.log('feedback submitted'));
    }

}