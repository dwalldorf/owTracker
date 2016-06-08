import {User} from "../../user/model/user";
export class Feedback {

    id: string;
    createdBy: User;
    createdTimestamp: number;
    displayDate: string;
    feedback = {
        like: true,
        fixplease: '',
        featureplease: '',
        freetext: '',
    };
    status: string;
    archived: boolean;

}