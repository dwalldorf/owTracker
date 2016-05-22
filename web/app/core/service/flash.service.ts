import {Injectable, EventEmitter} from '@angular/core';
import {FlashMessage} from "../model/flash.message";

@Injectable()
export class FlashService {

    public flashEventEmitter = new EventEmitter();

    public addMessage(message: FlashMessage) {
        this.flashEventEmitter.emit(message);
    }

}