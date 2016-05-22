import {Component} from '@angular/core';
import {AdminFeedbackService} from "./service/admin-feedback.service";
import {UserService} from "../user/service/user.service";
import {Feedback} from "../feedback/model/feedback";

@Component({
    templateUrl: 'app/admin/views/feedback.html',
})
export class AdminFeedbackComponent {

    private userService: UserService;

    private adminFeedbackService: AdminFeedbackService;

    private feedbackArray: Feedback[];

    constructor(userService: UserService, adminFeedbackService: AdminFeedbackService) {
        this.userService = userService;
        this.adminFeedbackService = adminFeedbackService;
    }

    ngOnInit() {
        console.log('admin feedback');

        this.userService.getCurrentUser().subscribe(() => {
            this.adminFeedbackService.getUserFeedback().subscribe(feedbacks => {
                this.feedbackArray = feedbacks;
                console.log(this.feedbackArray);
            })
        });
    }
}