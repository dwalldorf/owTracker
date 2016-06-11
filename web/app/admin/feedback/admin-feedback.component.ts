import {Component} from '@angular/core';
import {AdminFeedbackService} from "../service/admin-feedback.service";
import {UserService} from "../../user/service/user.service";
import {AdminFeedbackDetailComponent} from "./admin-feedback-detail.component";
import {ItemCollection} from "../../core/model/item.collection";
import DateTimeFormat = Intl.DateTimeFormat;
import {TimeFormatUtil} from "../../core/util/time-format.util";
import {Feedback} from "../../feedback/model/feedback";

@Component({
    templateUrl: 'app/admin/feedback/views/feedback.html',
    directives: [ AdminFeedbackDetailComponent ],
})
export class AdminFeedbackComponent {

    private userService: UserService;

    private adminFeedbackService: AdminFeedbackService;

    private feedback: ItemCollection<Feedback>;

    private restFinished = false;

    selectedFeedback: Feedback;

    constructor(userService: UserService, adminFeedbackService: AdminFeedbackService) {
        this.userService = userService;
        this.adminFeedbackService = adminFeedbackService;
    }

    ngOnInit() {
        this.restFinished = false;
        this.userService.getCurrentUser().subscribe(() => {
            this.adminFeedbackService.getUserFeedback().subscribe(feedbackCollection => {
                this.restFinished = true;
                this.feedback = feedbackCollection;

                for (let i = 0; i < this.feedback.totalItems; i++) {
                    let currentFeedback = this.feedback.items[ i ];
                    currentFeedback.displayDate = TimeFormatUtil.toDateTimeString(currentFeedback.createdTimestamp);

                    this.feedback.items[ i ] = currentFeedback;
                }
            })
        });
    }

    onSelect(selectedFeedback: Feedback) {
        if (this.selectedFeedback == selectedFeedback) {
            this.selectedFeedback = null;
        } else {
            this.selectedFeedback = selectedFeedback;
        }
    }
}