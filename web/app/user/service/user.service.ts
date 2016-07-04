import {Injectable, EventEmitter} from '@angular/core';
import {Router} from '@angular/router-deprecated';
import {AppConfig} from "../../app.config";
import {HttpService} from "../../core/service/http.service";
import {CacheService} from "../../core/service/cache.service";
import {CacheIdentifiers} from "../../core/config/cache.identifiers";
import {User} from "../model/user";
import {AppLoadingService} from "../../core/service/apploading.service";

@Injectable()
export class UserService {

    private CURRENT_USER_URI = '/users/me';
    private LOGIN_URI = '/user/login';
    private LOGOUT_URI = '/user/logout';
    private USERS_URI = '/users';

    private _router: Router;

    private _httpService: HttpService;

    private _appLoadingService: AppLoadingService;

    private _cacheService: CacheService;

    public currentUser: User;

    constructor(router: Router, httpService: HttpService, cacheService: CacheService, appLoadingService: AppLoadingService) {
        this._router = router;
        this._httpService = httpService;
        this._cacheService = cacheService;
        this._appLoadingService = appLoadingService;
    }

    /**
     * @returns {EventEmitter}
     */
    getCurrentUser(preventRedirectToLogin = false) {
        var eventEmitter = new EventEmitter(),
            cachedUser   = this._cacheService.get(CacheIdentifiers.CACHE_ID_CURRENT_USER);

        if (cachedUser !== null) {
            this._cacheService.emitCachedEvent(cachedUser, eventEmitter);
            return eventEmitter;
        } else {
            eventEmitter = this._httpService.makeRequest(HttpService.METHOD_GET, this.CURRENT_USER_URI);
            eventEmitter.subscribe(user => {
                this.currentUser = user;
                this._cacheService.cache(CacheIdentifiers.CACHE_ID_CURRENT_USER, this.currentUser, 600);
            }, () => this.handleNotLoggedin(preventRedirectToLogin));
        }
        return eventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    login(user) {
        var requestEventEmitter = this._httpService.makeRequest(HttpService.METHOD_POST, this.LOGIN_URI, user);

        requestEventEmitter.subscribe(user => {
            this.currentUser = user;
            this._cacheService.cache(CacheIdentifiers.CACHE_ID_CURRENT_USER, this.currentUser, 600);
        });

        return requestEventEmitter;
    }

    /**
     * @returns {EventEmitter}
     */
    register(user: User) {
        return this._httpService.makeRequest(HttpService.METHOD_POST, this.USERS_URI, user);
    }

    /**
     * @returns {EventEmitter}
     */
    logout() {
        this.currentUser = null;
        this._cacheService.invalidate(CacheIdentifiers.CACHE_ID_CURRENT_USER);

        return this._httpService.makeRequest(HttpService.METHOD_POST, this.LOGOUT_URI, null);
    }

    private handleNotLoggedin(preventRedirectToLogin = false) {
        this._appLoadingService.resetAll();

        if(!preventRedirectToLogin) {
            this._router.navigate([ AppConfig.ROUTE_NAME_LOGIN ]);
        }
    }
}