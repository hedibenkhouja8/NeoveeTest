

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
    /**
 * Get a buy with the given id
 * @param id : buy id
 * @returns Observable<Buy>
 */
articlesbyuser(id: number) {
    return this.http.get("http://127.0.0.1:8000/ArticleByUser/" + id);
  }
/**
 * Delete a buy with the given id
 * @param id buy id to delete
 */
 delete(id: number) {
    return this.http.delete("http://127.0.0.1:8000/article/supprimer/" + id);
  }
  }