import {Component} from '@angular/core';
import {AdminFeedbackService} from "./service/admin-feedback.service";
import {UserService} from "../user/service/user.service";

@Component({
    templateUrl: 'app/admin/views/feedback.html',
})
export class AdminFeedbackComponent {

    private userService: UserService;

    private adminFeedbackService: AdminFeedbackService;

    private feedback = null;

    private restFinished = false;

    constructor(userService: UserService, adminFeedbackService: AdminFeedbackService) {
        this.userService = userService;
        this.adminFeedbackService = adminFeedbackService;
    }

    ngOnInit() {
        this.restFinished = false;
        this.userService.getCurrentUser().subscribe(() => {
            this.adminFeedbackService.getUserFeedback().subscribe(feedbacks => {
                this.restFinished = true;
                this.feedback = feedbacks;

                console.log(this.feedback);
            })
        });
    }
}