import { Component, OnInit } from '@angular/core';

import { ApiService } from '../Services/api.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-article-by-user',
  templateUrl: './article-by-user.component.html',
  styleUrls: ['./article-by-user.component.css']
})
export class ArticleByUserComponent implements OnInit {
id:any;
  public ListArticles: any = [];
  constructor(private _ApiService: ApiService, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.id=this.route.snapshot.params['id'];
    this.articlesbyuser();
  }
  public articlesbyuser(){
    this._ApiService.articlesbyuser(this.id).subscribe((res) => (this.ListArticles = res));
  
  }
  public deleteArticle(id : number){
    this._ApiService.delete(id).subscribe(res => {
     
    
      this.articlesbyuser();
  
  });
  }
}
