import {Component} from '@angular/core';
import {FeedbackService} from "./service/feedback.service";
import {Feedback} from "./model/feedback";
import {FlashService} from "../core/service/flash.service";
import {FlashMessage} from "../core/model/flash.message";

declare var jQuery: any;
@Component({
    selector: 'feedback-dialog',
    templateUrl: 'app/feedback/views/feedback-dialog.html',
})
export class FeedbackDialogComponent {

    private feedbackService: FeedbackService;
    private flashService: FlashService;

    feedback = new Feedback();

    constructor(feedbackService: FeedbackService, flashService: FlashService) {
        this.feedbackService = feedbackService;
        this.flashService = flashService;
    }

    submitFeedback() {
        this.feedbackService.submitFeedback(this.feedback)
            .subscribe(() => {
                this.resetDialog();
                this.flashService.addMessage(new FlashMessage('Your feedback was submitted!', FlashMessage.SUCCESS));
            });
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