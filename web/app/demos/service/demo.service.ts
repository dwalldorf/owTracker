import {EventEmitter, Injectable} from '@angular/core';
import {UserService} from "../../user/service/user.service";
import {HttpService} from "../../core/service/http.service";
import {CacheService} from "../../core/service/cache.service";

@Injectable()
export class DemoService {

    private DEMOS_URI = '/demos';

    private _httpService: HttpService;

    private _cacheService: CacheService;

    private _userService: UserService;

    constructor(httpService: HttpService, cacheService: CacheService, userService: UserService) {
        this._httpService = httpService;
        this._cacheService = cacheService;
        this._userService = userService;
    }

    getDemos() {
        var eventEmitter = new EventEmitter();
        this._userService.getCurrentUser().subscribe(
            user => {
                this._httpService.makeRequest(HttpService.METHOD_GET, '/demos/user/' + user.id)
                    .subscribe(
                        res => {
                            eventEmitter.emit(res);
                        }
                    );
            }
        );
        return eventEmitter;
    }

    getDemo(id: string) {
        var eventEmitter = new EventEmitter();
        this._httpService.makeRequest(HttpService.METHOD_GET, '/demos/' + id)
            .subscribe(
                res => {
                    eventEmitter.emit(res);
                }
            );
        return eventEmitter;
    }
}