import { Component } from '@angular/core';
import {Http} from "@angular/http";
import {NgModel} from '@angular/forms';
import 'rxjs/add/operator/toPromise';
import {Observable} from 'rxjs/Rx';

@Component({
  selector: 'app-root',
  template: `
    <h1>Welcome to shortener link!</h1>
    <input type="text" [(ngModel)]="originalLink" />
    <input type="button" value="Get short link!" (click)="getShortLink()">
    <div *ngIf="shortLink && !errorMessage" style="margin-top: 20px;">Yout short link: {{shortLink}}</div>
    <div *ngIf="errorMessage" style="margin-top: 20px;">Error: {{errorMessage}}</div>
`,
})

export class AppComponent
{
  originalLink = '';
  shortLink = '';
  errorMessage = '';

  constructor(
      private http: Http
  ) {}

  getShortLink() {
    this.http.post('http://127.0.0.1:8000/links', JSON.stringify({'originalLink': this.originalLink}))
        .subscribe(
            (data) => {
                let response = data.json();
                this.shortLink = response.data.shortLink;
                this.errorMessage = '';
            },
            (error)  => {
                let response = error.json();
                this.errorMessage = response.error.message;
            }
        );



    // if (response.success) {
    //   this.shortLink = response.data.shortLink;
    //   this.errorMessage = '';
    // } else {
    //   this.errorMessage = response.error.message;
    // }

  }
}