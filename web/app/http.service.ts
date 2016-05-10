import {Injectable} from '@angular/core';
import {Http, Headers} from '@angular/http';

@Injectable()
export class HttpService {

    private headers: Headers;

    constructor(private http: Http) {
        this.headers = new Headers();
        this.headers.append('Content-Type', 'application/json');
        this.headers.append('Accept', 'application/json');
    }

    get(url: string) {
        return this.http.get(url, this.headers);
    }

    post(url: string, dataObj) {
        return this.http.post(url, JSON.stringify(dataObj), this.headers);
    }

}