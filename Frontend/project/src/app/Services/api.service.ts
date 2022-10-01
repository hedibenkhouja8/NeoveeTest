

import { Injectable } from '@angular/core';
import { HttpClient,HttpErrorResponse,HttpHeaders } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';

import { catchError } from 'rxjs/operators';
import { likemodel } from '../articles/like.model';
@Injectable()
   
  export class ApiService { 
    private apiUrl ='http://127.0.0.1:8000/';
    constructor(private http: HttpClient) {}
    
  
  
  public Like: likemodel = new likemodel;

    /**
     *Get all articles
     * @returns Observable<any>
     */
    allarticles() {
      return this.http.get(this.apiUrl+ 'articles');
    }


    /**
 * Get articles with given user id
 * @param id : article id
 * @returns Observable<Article>
 */
     articlesbyuser(id: number) {
      return this.http.get(this.apiUrl + 'articles/' + id);
    }

    /**
 * check if article is already liked
 */
likeExists(user_id: number,article_id : number) {
  
    return this.http.get(this.apiUrl + 'likes/' + user_id +'/'+article_id);
  }
 



/**
 * Delete an article with the given id
 * @param id article id to delete
 */
 delete(id: number) {
    return this.http.delete(this.apiUrl + 'supprimer/' + id);
  }


  /**
   * Create a new article
   * @param article new article to create
   */
   createArticle(article: any) :Observable<any>  {
    return this.http.post(this.apiUrl + 'ajouter', article).pipe(
      catchError(this.handleError)
  )
  } /**
  * login
  * @param user 
  */
  login(user: any) :Observable<any>  {
   return this.http.post(this.apiUrl + 'login', user).pipe(
     catchError(this.handleError)
 )
 }
 


    like(article_id: number,user_id:number) :Observable<any>  {
 
      this.Like.article_id=article_id;
      this.Like.user_id=user_id;
   
      return this.http.post(this.apiUrl+'LikeArticles', this.Like).pipe(
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
   * Update a article with the given id
   * @param id article id to update
   * @param article new course data
   */
  update(id: number, article: any) {
    return this.http.put(this.apiUrl + 'modifier/' + id, article);
  }
  }