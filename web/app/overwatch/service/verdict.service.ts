import {EventEmitter, Injectable} from '@angular/core';

import {HttpService} from "../../core/service/http.service";
import {UserService} from "../../user/service/user.service";
import {CacheService} from "../../core/service/cache.service";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";
import {Verdict} from "../model/verdict";

@Injectable()
export class VerdictService {

    private MAPPOOL_URI = '/overwatch/mappool';
    private USER_VERDICTS_URI = '/overwatch/verdicts/';

    private httpService: HttpService;

    private cacheService: CacheService;

    private userService: UserService;

    public verdictAddedEventEmitter = new EventEmitter();

    constructor(httpService: HttpService, cacheService: CacheService, userService: UserService) {
        this.httpService = httpService;
        this.cacheService = cacheService;
        this.userService = userService;
    }

    /**
     * @returns {EventEmitter}
     */
    getMapPool() {
        var eventEmitter  = new EventEmitter(),
            cachedMapPool = this.cacheService.get(CacheIdentifiers.CACHE_ID_MAPPOOL);

        if (cachedMapPool !== null) {
            this.cacheService.emitCachedEvent(cachedMapPool, eventEmitter);
        } else {
            this.httpService
                .makeRequest(HttpService.METHOD_GET, this.MAPPOOL_URI)
                .subscribe(
                    res => {
                        this.cacheService.cache(CacheIdentifiers.CACHE_ID_MAPPOOL, res, 60000);
                        eventEmitter.emit(res);
                    }
                );
        }

        return eventEmitter;
    }

    getUserVerdicts(userId: string) {
        var eventEmitter   = new EventEmitter(),
            cachedVerdicts = this.cacheService.get(CacheIdentifiers.CACHE_ID_USER_VERDICTS);

        if (cachedVerdicts !== null) {
            this.cacheService.emitCachedEvent(cachedVerdicts, eventEmitter);
            return eventEmitter;
        } else {
            this.httpService.makeRequest(HttpService.METHOD_GET, this.USER_VERDICTS_URI + userId)
                .subscribe(res => {
                    this.cacheService.cache(
                        CacheIdentifiers.CACHE_ID_USER_VERDICTS,
                        res,
                        10
                    );
                    eventEmitter.emit(res);
                });
        }

        return eventEmitter;
    }

    getHigherScores(userId: string, period: number, offset = 0) {
        var eventEmitter = new EventEmitter(),
            uri          = this.buildQueryUri('higher', userId, period, offset);

        this.httpService
            .makeRequest(HttpService.METHOD_GET, uri)
            .subscribe(res => eventEmitter.emit(res));
        return eventEmitter;
    }

    getLowerScores(userId: string, period, offset = 0) {
        var eventEmitter = new EventEmitter(),
            uri          = this.buildQueryUri('lower', userId, period, offset);

        this.httpService
            .makeRequest(HttpService.METHOD_GET, uri)
            .subscribe(res => eventEmitter.emit(res));
        return eventEmitter;
    }

    getUserScores(userId: string, period: number) {
        var eventEmitter = new EventEmitter(),
            cacheId      = 'userScores:' + userId + ':' + period,
            cachedScores = this.cacheService.get(cacheId);

        if (cachedScores !== null) {
            this.cacheService.emitCachedEvent(cachedScores, eventEmitter);
        } else {
            this.httpService.makeRequest(HttpService.METHOD_GET, '/overwatch/scores/' + userId + '?period=' + period)
                .subscribe(res => {
                        res = res[ 0 ];
                        this.cacheService.cache(cacheId, res, 60);
                        eventEmitter.emit(res);
                    },
                    err => eventEmitter.error(err));
        }
        return eventEmitter;
    }

    submitVerdict(verdict: Verdict) {
        var requestObservable = this.httpService.makeRequest(HttpService.METHOD_POST, '/overwatch/verdicts', verdict);
        requestObservable.subscribe(verdict => {
            this.verdictAddedEventEmitter.emit(verdict);
        });
        return requestObservable;
    }

    private getCacheId(prefix: string, userId: string, period: number) {
        return prefix + ':' + userId + ':' + period;
    }

    /**
     *
     * @param lowerHigher "lower" or "higher"
     * @param userId
     * @param period
     * @param offset
     * @returns {string}
     */
    private buildQueryUri(lowerHigher: string, userId: string, period: number, offset: number = 0) {
        var uri = '/overwatch/scores/' + lowerHigher + '/' + userId + '/' + period;

        if (offset > 0) {
            uri += '?offset=' + offset;
        }

        return uri;
    }

}