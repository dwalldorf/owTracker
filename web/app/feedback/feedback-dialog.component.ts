import {Component} from '@angular/core';
import {FeedbackService} from "./service/feedback.service";
import {Feedback} from "./model/feedback";

declare var jQuery: any;
@Component({
    selector: 'feedback-dialog',
    templateUrl: 'app/feedback/views/feedback-dialog.html',
})
export class FeedbackDialogComponent {

    private feedbackService: FeedbackService;

    feedback = new Feedback();
    isVisible = false;

    constructor(feedbackService: FeedbackService) {
        this.feedbackService = feedbackService;
    }

    submitFeedback() {
        this.feedbackService.submitFeedback(this.feedback)
            .subscribe(() => this.resetDialog());
    }

    showDialog() {
        jQuery('#feedback-dialog').modal('show');
    }

    feedbackLike() {
        this.feedback.like = true;
    }

    feedbackDisike() {
        this.feedback.like = false;
    }

    resetDialog() {
        jQuery('#feedback-dialog').modal('hide');
        this.feedback = new Feedback();
    }
}