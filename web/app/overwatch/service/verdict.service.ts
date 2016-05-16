import {EventEmitter, Injectable} from '@angular/core';

import {HttpService} from "../../core/service/http.service";
import {UserService} from "../../user/service/user.service";
import {CacheService} from "../../core/service/cache.service";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";
import {Verdict} from "../model/verdict";

@Injectable()
export class VerdictService {

    private MAPPOOL_URI = '/api/overwatch/mappool';
    private USER_VERDICTS_URI = '/api/overwatch/verdicts/';

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

    getUserVerdicts() {
        var eventEmitter   = new EventEmitter(),
            cachedVerdicts = this.cacheService.get(CacheIdentifiers.CACHE_ID_USER_VERDICTS);

        if (cachedVerdicts !== null) {
            this.cacheService.emitCachedEvent(cachedVerdicts, eventEmitter);
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

    getHigherScores(userId: string, period: number) {
        var eventEmitter = new EventEmitter(),
            cacheId      = 'higherScores:' + userId + ':' + period,
            cachedScores = this.cacheService.get(cacheId);

        if (cachedScores !== null) {
            this.cacheService.emitCachedEvent(cachedScores, eventEmitter);
        } else {
            this.httpService.makeRequest(HttpService.METHOD_GET, '/api/overwatch/scores/higher/' + userId + '/' + period)
                .subscribe(res => {
                    this.cacheService.cache(cacheId, res, 60);
                    eventEmitter.emit(res);
                });
        }
        return eventEmitter;
    }

    getLowerScores(userId: string, period) {
        var eventEmitter = new EventEmitter(),
            cacheId      = 'lowerScores:' + userId + ':' + period,
            cachedScores = this.cacheService.get(cacheId);

        if (cachedScores !== null) {
            this.cacheService.emitCachedEvent(cachedScores, eventEmitter);
        } else {
            this.httpService.makeRequest(HttpService.METHOD_GET, '/api/overwatch/scores/lower/' + userId + '/' + period)
                .subscribe(res => {
                    this.cacheService.cache(cacheId, res, 60);
                    eventEmitter.emit(res);
                });
        }
        return eventEmitter;
    }

    getUserScores(userId: string, period: number) {
        var eventEmitter = new EventEmitter(),
            cacheId      = 'userScores:' + userId + ':' + period,
            cachedScores = this.cacheService.get(cacheId);

        if (cachedScores !== null) {
            this.cacheService.emitCachedEvent(cachedScores, eventEmitter);
        } else {
            this.httpService.makeRequest(HttpService.METHOD_GET, '/api/overwatch/scores/' + userId + '?period=' + period)
                .subscribe(res => {
                    res = res[ 0 ];
                    this.cacheService.cache(cacheId, res, 60);
                    eventEmitter.emit(res);
                });
        }
        return eventEmitter;
    }

    submitVerdict(verdict: Verdict) {
        var requestObservable = this.httpService.makeRequest(HttpService.METHOD_POST, '/api/overwatch/verdicts', verdict);
        requestObservable.subscribe(verdict => {
            this.verdictAddedEventEmitter.emit(verdict);
        });
        return requestObservable;
    }

    private getCacheId(prefix: string, userId: string, period: number) {
        return prefix + ':' + userId + ':' + period;
    }

}