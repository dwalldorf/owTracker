import {UserScore} from "./user.score";
import {ItemCollection} from "../../core/model/item.collection";
export class Scoreboard {

    higher: ItemCollection<UserScore>;
    self: UserScore;
    lower: ItemCollection<UserScore>;

    constructor() {
        this.higher = new ItemCollection<UserScore>();
        this.self = new UserScore();
        this.lower = new ItemCollection<UserScore>();
    }
}