

import { Injectable } from '@angular/core';
import { HttpClient,HttpErrorResponse,HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';

import { catchError } from 'rxjs/operators';
import { likemodel } from '../articles/like.model';
@Injectable()
   
  export class ApiService { 
    constructor(private http: HttpClient) {}
    
  
  
  public Like: likemodel = new likemodel;
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
  /**
   * Create a new rent
   * @param article new rent to create
   */
   createArticle(article: any) :Observable<any>  {
    article.user_id=1;
    return this.http.post("http://127.0.0.1:8000/Articles", article).pipe(
      catchError(this.handleError)
  )
  }
   /**
   * Create a new rent
   * @param like new rent to create
   */
    like(article_id: number,user_id:number) :Observable<any>  {
 
      
  
      this.Like.article_id=article_id;
      this.Like.user_id=user_id;
   
      return this.http.post("http://127.0.0.1:8000/LikeArticles", this.Like).pipe(
        catchError(this.handleError)
    )
    }
   /**
   *
   * @param error 
   * @returns
   */
    handleError(error: HttpErrorResponse) {
        let msg = '';
        if (error.error instanceof ErrorEvent) {
          // client-side error
          msg = error.error.message;
        } else {
          // server-side error
          msg = `Error Code: ${error.status}\nMessage: ${error.message}`;
        }
        return throwError(msg);
      }

        /**
   * Update a rent with the given id
   * @param id rent id to update
   * @param rent new course data
   */
  update(id: number, article: any) {
    return this.http.put("http://127.0.0.1:8000/article/edit/"+ id, article);
  }
  }