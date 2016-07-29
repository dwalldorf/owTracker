import {UserSettings} from "./userSettings";
export class User {

    public id: string;
    public username: string;
    public email: string;
    public password: string;
    public registered: number;
    public userSettings: UserSettings;

}