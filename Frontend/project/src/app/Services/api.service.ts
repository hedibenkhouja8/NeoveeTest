

import { Injectable } from '@angular/core';
import { HttpClient,HttpErrorResponse,HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
@Injectable()
   
  export class ApiService { 
    constructor(private http: HttpClient) {}
    /**
     *Get all articless
     * @returns Observable<any>
     */
    allarticles() {
      return this.http.get("http://127.0.0.1:8000/articles");
    }

  }