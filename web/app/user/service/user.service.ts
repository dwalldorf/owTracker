import {Injectable, EventEmitter} from '@angular/core';

import {User} from "../model/user";
import {HttpService} from "../../core/service/http.service";
import {CacheService} from "../../core/service/cache.service";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";
import {AppComponent} from "../../app.component";
import {AppConfig} from "../../app.config";

@Injectable()
export class UserService {

    private CURRENT_USER_URI = AppConfig.API_PREFIX + '/users/me';
    private LOGIN_URI = AppConfig.API_PREFIX + '/user/login';
    private LOGOUT_URI = AppConfig.API_PREFIX + '/user/logout';
    private USERS_URI = AppConfig.API_PREFIX + '/users';

    private httpService: HttpService;

    private cacheService: CacheService;

    public currentUser: User;

    constructor(httpService: HttpService, cacheService: CacheService) {
        this.httpService = httpService;
        this.cacheService = cacheService;
    }

    /**
     * @returns {EventEmitter}
     */
    getCurrentUser() {
        var eventEmitter = new EventEmitter(),
            cachedUser   = this.cacheService.get(CacheIdentifiers.CACHE_ID_CURRENT_USER);

        if (cachedUser !== null) {
            this.cacheService.emitCachedEvent(cachedUser, eventEmitter);
            return eventEmitter;
        } else {
            eventEmitter = this.httpService.makeRequest(HttpService.METHOD_GET, this.CURRENT_USER_URI);
            eventEmitter.subscribe(user => {
                this.currentUser = user;

                this.cacheService.cache(CacheIdentifiers.CACHE_ID_CURRENT_USER, this.currentUser, 600);
            });
        }

        return eventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    login(user) {
        var requestEventEmitter = this.httpService.makeRequest(HttpService.METHOD_POST, this.LOGIN_URI, user);

        requestEventEmitter.subscribe(user => {
            this.currentUser = user;

            this.cacheService.cache(CacheIdentifiers.CACHE_ID_CURRENT_USER, this.currentUser, 600);
        });

        return requestEventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    register(user: User) {
        return this.httpService.makeRequest(HttpService.METHOD_POST, this.USERS_URI, user);
    }

    hasCurrentUser() {
        return this.currentUser instanceof User;
    }

    /**
     * @returns {EventEmitter}
     */
    logout() {
        this.currentUser = null;
        this.cacheService.invalidate(CacheIdentifiers.CACHE_ID_CURRENT_USER);

        return this.httpService.makeRequest(HttpService.METHOD_POST, this.LOGOUT_URI, null);
    }

}