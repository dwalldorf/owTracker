import {EventEmitter, Injectable} from '@angular/core';

import {HttpService} from "../../core/service/http.service";
import {UserService} from "../../user/service/user.service";
import {CacheService} from "../../core/service/cache.service";
import {Verdict} from "../model/verdict";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";

@Injectable()
export class VerdictService {

    private USER_VERDICTS_URI = '/api/overwatch/verdicts/';

    private MAPPOOL_URI = '/api/overwatch/mappool';

    private httpService: HttpService;

    private cacheService: CacheService;

    private userService: UserService;

    constructor(httpService: HttpService, cacheService: CacheService, userService: UserService) {
        this.httpService = httpService;
        this.cacheService = cacheService;
        this.userService = userService;
    }

    /**
     * @returns {EventEmitter}
     */
    getUserVerdicts() {
        var eventEmitter   = new EventEmitter(),
            cachedVerdicts = this.cacheService.get(CacheIdentifiers.CACHE_ID_USER_VERDICTS);

        if (cachedVerdicts !== null) {
            setTimeout(function () {
                eventEmitter.emit(cachedVerdicts);
            }, 10);
            return eventEmitter;
        } else {
            this.userService.getCurrentUser().subscribe(user => {
                    this.httpService.makeRequest(HttpService.METHOD_GET, this.USER_VERDICTS_URI + user.id)
                        .subscribe(res => {
                            this.cacheService.cache(
                                CacheIdentifiers.CACHE_ID_USER_VERDICTS,
                                res,
                                10
                            );
                            eventEmitter.emit(res);
                        });
                }
            );
        }

        return eventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    getMapPool() {
        var mapPoolEvent = new EventEmitter();
        this.httpService
            .makeRequest(HttpService.METHOD_GET, this.MAPPOOL_URI)
            .subscribe(
                res => mapPoolEvent.emit(res)
            );

        return mapPoolEvent;
    }

}