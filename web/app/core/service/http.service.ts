import {Injectable, EventEmitter} from '@angular/core';
import {Http, Headers, Response} from '@angular/http';
import {Observable} from "rxjs/Observable";
import {AppConfig} from "../../app.config";

@Injectable()
export class HttpService {

    static METHOD_GET = 'get';
    static METHOD_POST = 'post';
    static METHOD_DELETE = 'delete';
    static METHOD_PUT = 'put';

    static ALLOWED_METHODS = [
        HttpService.METHOD_GET,
        HttpService.METHOD_POST,
        HttpService.METHOD_DELETE,
        HttpService.METHOD_PUT
    ];

    private headers: Headers;

    private requestsInProgress;

    constructor(private http: Http) {
        this.headers = new Headers();
        this.headers.append('Content-Type', 'application/json');
        this.headers.append('Accept', 'application/json');

        this.requestsInProgress = [];
    }

    /**
     *
     * @param method string
     * @param url string
     * @param payload
     * @returns {EventEmitter}
     */
    makeRequest(method: string, url: string, payload = null) {
        if (!this.isValidMethod(method)) {
            throw new Error('invalid http method: ' + method);
        }

        url = AppConfig.API_PREFIX + url;
        var requestEventEmitter = new EventEmitter(),
            requestHash         = this.getRequestHash(method, url);

        if (this.hasRequestInProgress(requestHash)) {
            return this.getRequestInProgress(requestHash);
        }

        payload = JSON.stringify(payload);
        var observable: Observable<Response>;

        switch (method) {
            case HttpService.METHOD_GET:
                observable = this.http.get(url, this.headers);
                break;
            case HttpService.METHOD_POST:
                observable = this.http.post(url, payload, this.headers);
                break;
            case HttpService.METHOD_PUT:
                observable = this.http.put(url, payload, this.headers);
                break;
            case HttpService.METHOD_DELETE:
                observable = this.http.delete(url, this.headers);
                break;
        }

        this.requestsInProgress[ requestHash ] = requestEventEmitter;

        observable.subscribe(
            res => {
                var emitVal = true;
                try {
                    emitVal = res.json();
                } catch (error) {

                }

                requestEventEmitter.emit(emitVal);
                this.finishRequest(requestHash);
            },
            err => {
                requestEventEmitter.error(err);
                this.finishRequest(requestHash);
            },
            () => {
                this.finishRequest(requestHash);
            }
        );
        return requestEventEmitter;
    }

    private isValidMethod(method: string) {
        return (HttpService.ALLOWED_METHODS.indexOf(method) >= 0);
    }

    private isRequestInProgress(method: string, url: string) {
        var hash = this.getRequestHash(method, url),
            res  = false;

        if (this.requestsInProgress.hasOwnProperty(hash)) {
            res = this.requestsInProgress[ hash ];
        }

        return res;
    }

    private hasRequestInProgress(requestHash: string) {
        return this.requestsInProgress.hasOwnProperty(requestHash);
    }

    /**
     * @param requestHash string
     * @returns EventEmitter
     */
    private getRequestInProgress(requestHash: string) {
        if (!this.hasRequestInProgress(requestHash)) {
            throw new Error('no such request in progress: ' + requestHash);
        }

        return this.requestsInProgress[ requestHash ];
    }

    private finishRequest(requestHash: string) {
        delete this.requestsInProgress[ requestHash ];
    }

    private handleRequest(method: string, url: string, request) {
        var requestEventEmitter = new EventEmitter();
        request.subscribe(res => requestEventEmitter.emit(res.json()));

        this.requestsInProgress[ this.getRequestHash(method, url) ] = requestEventEmitter;
        return requestEventEmitter;
    }

    private getRequestHash(method: string, url: string) {
        return method + ':' + url;
    }

}