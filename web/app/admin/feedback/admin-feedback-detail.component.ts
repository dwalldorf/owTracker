import {Component, Input} from '@angular/core';
import {Feedback} from "../../feedback/model/feedback";

@Component({
    selector: 'admin-feedback-detail',
    templateUrl: 'app/admin/feedback/views/feedback-detail.html',
})
export class AdminFeedbackDetailComponent {

    @Input()
    feedback: Feedback;

}
