import {Component} from '@angular/core';
import {FeedbackService} from "./service/feedback.service";
import {Feedback} from "./model/feedback";
import {FlashService} from "../core/service/flash.service";
import {FlashMessage} from "../core/model/flash.message";
import {AppLoadingService} from "../core/service/apploading.service";

declare var jQuery: any;
@Component({
    selector: 'feedback-dialog',
    templateUrl: 'app/feedback/views/feedback-dialog.html',
})
export class FeedbackDialogComponent {

    private STATUS_ID = 'feedback';

    private appLoadingService: AppLoadingService;
    private flashService: FlashService;
    private feedbackService: FeedbackService;

    feedback: Feedback;

    constructor(appLoadingService: AppLoadingService, flashService: FlashService, feedbackService: FeedbackService) {
        this.appLoadingService = appLoadingService;
        this.flashService = flashService;
        this.feedbackService = feedbackService;
    }

    ngOnInit() {
        this.resetFeedback();
    }

    submitFeedback() {
        this.appLoadingService.setLoading(this.STATUS_ID);
        this.feedbackService.submitFeedback(this.feedback)
            .subscribe(() => {
                this.appLoadingService.finishedLoading(this.STATUS_ID);
                this.resetDialog();
                this.flashService.addMessage(new FlashMessage('Your feedback was submitted!', FlashMessage.SUCCESS));
            });
    }

    showDialog() {
        jQuery('#feedback-dialog').modal('show');
    }

    resetDialog() {
        jQuery('#feedback-dialog').modal('hide');
        this.resetFeedback();
    }

    private resetFeedback() {
        this.feedback = new Feedback();
    }
}